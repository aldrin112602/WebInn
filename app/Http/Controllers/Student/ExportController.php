<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\{Spreadsheet, Writer\Xlsx};
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Student\{AttendanceHistory, StudentAccount};
use App\Models\Teacher\TeacherAccount;
use App\Models\Admin\SubjectModel;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\Auth;


class ExportController extends Controller
{
    public function exportAttendanceHistory($id) 
    {
        
        $attendanceList = null;
        if(request()->query('status') && in_array(request()->query('status'), ['absent', 'present'])) {
            $attendanceList = AttendanceHistory::where('student_id', $id)->where('status', request()->query('status'))->get();
        } else {
            $attendanceList = AttendanceHistory::where('student_id', $id)->get();
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Day');
        $sheet->setCellValue('C1', 'Subject');
        $sheet->setCellValue('D1', 'Teacher');
        $sheet->setCellValue('E1', 'Time');
        $sheet->setCellValue('F1', 'Time-In');
        $sheet->setCellValue('G1', 'Status');

        // Populate data
        $row = 2;

        foreach ($attendanceList as $attendance) {
            $subject = SubjectModel::where('id', $attendance->subject_model_id)->first();
            $teacher = TeacherAccount::where('id', $attendance->teacher_id)->first();

            $sheet->setCellValue('A' . $row, $attendance->date);
            $sheet->setCellValue('B' . $row, $subject->day);
            $sheet->setCellValue('C' . $row, $subject->subject);
            $sheet->setCellValue('D' . $row, $teacher->name);
            $sheet->setCellValue('E' . $row, $subject->time);
            $sheet->setCellValue('F' . $row, $attendance->time_in);
            $sheet->setCellValue('G' . $row, $attendance->status);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'attendance_history_' . StudentAccount::where('id', $id)->first()->name . '__' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');


        return $response;
    }


    // export grade
    public function exportGrades(Request $request, $id = null) 
    {


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $grades = StudentGrade::where('student_id', ($id ?? Auth::id()))->get();

        // Set the header
        $sheet->setCellValue('A1', 'Subject');
        $sheet->setCellValue('B1', 'Semester');
        $sheet->setCellValue('C1', 'Quarter');
        $sheet->setCellValue('D1', 'Quarterly Grade');
        $sheet->setCellValue('E1', 'Remarks');


        // Populate data
        $row = 2;

        foreach ($grades as $grade) {
            $sheet->setCellValue('A' . $row, $grade->subject);
            $sheet->setCellValue('B' . $row, $grade->semester);
            $sheet->setCellValue('C' . $row, $grade->quarter);
            $sheet->setCellValue('D' . $row, $grade->quarterly_grade);
            $sheet->setCellValue('E' . $row, ((int)$grade->quarterly_grade < 75 ? 'Failed' : 'Passed'));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Summary_of_grades_for_' . StudentAccount::where('id', ($id ?? Auth::id()))->first()->name . '__' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');


        return $response;
    }
}
