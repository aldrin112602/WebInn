<?php

namespace App\Http\Controllers;

use App\Services\PHPMailerService;
use App\Models\Student\StudentAccount;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\DB;

class SendMailAttendance extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function sendAttendance()
    {
        // Determine the current quarter dynamically
        $currentMonth = date('n');
        $quarter = match (true) {
            $currentMonth >= 1 && $currentMonth <= 3 => 'First Quarter',
            $currentMonth >= 4 && $currentMonth <= 6 => 'Second Quarter',
            $currentMonth >= 7 && $currentMonth <= 9 => 'Third Quarter',
            $currentMonth >= 10 && $currentMonth <= 12 => 'Fourth Quarter',
            default => 'Unknown Quarter',
        };

        // Calculate the dynamic report period
        $reportPeriod = match ($quarter) {
            'First Quarter' => 'January - March ' . date('Y'),
            'Second Quarter' => 'April - June ' . date('Y'),
            'Third Quarter' => 'July - September ' . date('Y'),
            'Fourth Quarter' => 'October - December ' . date('Y'),
            default => 'Unknown Period',
        };

        // Initialize sent and not sent lists
        $sent = [];
        $notSent = [];

        // Fetch all student accounts with their attendance histories

        $students = StudentAccount::with('attendanceHistories')
            ->get()
            ->unique('parents_email');
        
        //dd($students);
        
        
        foreach ($students as $student) {
            // Validate the parent email before proceeding
            if (!filter_var($student->parents_email, FILTER_VALIDATE_EMAIL)) {
               $notSent[] = [
               'email' => $student->parents_email ?? 'N/A',
               'reason' => 'Invalid or missing email address',
                ];
                continue;
            }
            
            
            if(in_array($student->parents_email, $sent) || in_array($student->parents_email, $notSent)) {
                continue;
            }
            
            
            $absences = [];
            $presents = 0;
            $highlightedAbsences = [];
            $patternsOfTardiness = [];

            // Process attendance histories for the student
            foreach ($student->attendanceHistories as $record) {
                if (strtolower($record->status) === 'absent') {
                    $absences[] = [
                        'date' => $record->date,
                        'reason' => $record->remarks ?? 'Unexcused',
                    ];

                    if ($record->remarks === null || strtolower($record->remarks) === 'unexcused') {
                        $highlightedAbsences[] = $record->date;
                    }
                } elseif (strtolower($record->status) === 'late') {
                    $patternsOfTardiness[] = $record->date;
                } else {
                    $presents++;
                }
            }

            // Get student grades dynamically
            $grades = StudentGrade::where('student_id', $student->id)
                ->where('quarter', $quarter)
                ->get(['subject', 'quarterly_grade']);
            
            // Skip the student if there are no grades for the specified quarter
            if ($grades->isEmpty() || $presents == 0) {
               $notSent[] = [
               'email' => $student->parents_email,
               'reason' => (($presents == 0) ? 'Doesn\'t have any attendance yet.' : 'No grades available for the specified quarter'),
               ];
               continue;
            }
            

            // Transform grades and add remarks dynamically
            $subjects = [];
            foreach ($grades as $grade) {
                $remark = $this->getRemarkForGrade($grade->quarterly_grade); // Generate remark dynamically
                $subjects[$grade->subject] = [
                    'score' => $grade->quarterly_grade,
                    'remark' => $remark,
                ];
            }

            // Prepare email data for this specific student
            $data = [
                'grade' => $student->grade,
                'quarter' => $quarter,
                'report_period' => $reportPeriod,
                'student_name' => $student->name,
                'subjects' => $subjects,
                'attendance' => [
                    'days_present' => $presents, // Replace with actual calculation if needed
                    'days_absent' => count($absences),
                    'tardies' => count($patternsOfTardiness),
                ],
            ];

            // Create the HTML email body
            $htmlBody = "
                <h2>Student Report</h2>
                <ul>
                    <li><strong>Student Name:</strong> {$data['student_name']}</li>
                    <li><strong>Grade:</strong> {$data['grade']}</li>
                    <li><strong>Report Period:</strong> {$data['quarter']} ({$data['report_period']})</li>
                </ul>
                <hr>
                <h3>Academic Performance:</h3>
                <ul>
            ";

            foreach ($data['subjects'] as $subject => $info) {
                $htmlBody .= "<li><strong>{$subject}:</strong> {$info['score']} - {$info['remark']}</li>";
            }

            $htmlBody .= "
                </ul>
                <hr>
                <h3>Attendance Record:</h3>
                <ul>
                    <li><strong>Days Present:</strong> {$data['attendance']['days_present']}</li>
                    <li><strong>Days Absent:</strong> {$data['attendance']['days_absent']}</li>
                    <li><strong>Tardies:</strong> {$data['attendance']['tardies']}</li>
                </ul>
            ";
            
            
            

            // Send the email only to the parent of this student
            try {
                if ($this->mailerService->sendAttendanceV2($student->parents_email, ['htmlBody' => $htmlBody])) {
                    $sent[] = $student->parents_email;
                } else {
                    $notSent[] = [
                        'email' => $student->parents_email,
                        'reason' => 'Failed to send email',
                    ];
                    continue;
                }
            } catch (\Exception $e) {
                $notSent[] = [
                    'email' => $student->parents_email,
                    'reason' => $e->getMessage(),
                ];
            }
        }

        // Return the response
        return response()->json([
            'sent' => $sent,
            'not_sent' => $notSent,
            'success' => true,
            'message' => 'Quarterly Report Sent Successfully',
        ], 200);
    }

    /**
     * Generate a remark dynamically based on the grade.
     *
     * @param int $grade
     * @return string
     */
    private function getRemarkForGrade(int $grade): string
    {
        return match (true) {
            $grade >= 90 => 'Outstanding',
            $grade >= 85 => 'Very Satisfactory',
            $grade >= 80 => 'Satisfactory',
            $grade >= 75 => 'Fairly Satisfactory',
            default => 'Needs Improvement',
        };
    }
}