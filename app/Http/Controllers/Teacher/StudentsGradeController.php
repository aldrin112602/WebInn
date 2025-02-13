<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Admin\SubjectModel;
use App\Models\GradingHeader;
use App\Models\HighestPossibleScoreGradingSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherGradeHandle;
use App\Models\StudentHandle;
use App\Models\Student\StudentAccount;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\DB;

class StudentsGradeController extends Controller
{
    public
        $user,
        $handleSubjects,
        $allStudents,
        $allMaleStudents,
        $allFemaleStudents,
        $gradingHeaders,
        $gradeHandles,
        $studentGrades;

    public function __construct(Request $request)
    {
        $this->user = Auth::user();

    }

    public function grading(Request $request)
    {
        // New added from _construct
        // Apply filters dynamically based on the request
        $filters = [
            'grade' => $request->grade,
            'strand' => $request->strand,
            'section' => $request->section,
            'semester' => $request->semester,
            'quarter' => $request->quarter,
            'subject' => $request->subject,
        ];
        
        
        // percentage filters
        /*$percentage_filters = [
            'Applied Subject' => [
                'written_work' => '35%',
                'performance_task' => '45%',
                'quarterly_assessment' => '20%',
                ],
            'Core Subject' => [
                'written_work' => '25%',
                'performance_task' => '50%',
                'quarterly_assessment' => '20%',
                ],
            'Specialized Subject' => [
                'written_work' => '20%',
                'performance_task' => '60%',
                'quarterly_assessment' => '20%',
                ],
            ];
            
            $percentage_filters = [
            'Core Subject' => [
                'written_work' => '25%',
                'performance_task' => '50%',
                'quarterly_assessment' => '20%',
                ],
            'Applied Subject' => [
                'written_work' => '35%',
                'performance_task' => '45%',
                'quarterly_assessment' => '20%',
                ],
            'Specialized Subject' => [
                'written_work' => '20%',
                'performance_task' => '60%',
                'quarterly_assessment' => '20%',
                ],
            ]; */
            
            
          

        // Handle Subjects / filter only grade, strand and section to get subjects
        $this->handleSubjects = TeacherGradeHandle::where('teacher_id', $this->user->id)
            ->when($filters['grade'], fn($query, $grade) => $query->where('grade', $grade))
            ->when($filters['strand'], fn($query, $strand) => $query->where('strand', $strand))
            ->when($filters['section'], fn($query, $section) => $query->where('section', $section))
            ->when($filters['subject'], fn($query, $subject) => $query->whereHas('subjects', fn($q) => $q->where('subject', $subject)))
            ->distinct()
            ->get();


        // All Students
        $this->allStudents = StudentHandle::with('account')
            ->where('teacher_id', $this->user->id)
            ->when($filters['grade'], fn($query, $grade) => $query->whereHas('gradeHandle', fn($q) => $q->where('grade', $grade)))
            ->when($filters['strand'], fn($query, $strand) => $query->whereHas('gradeHandle', fn($q) => $q->where('strand', $strand)))
            ->when($filters['section'], fn($query, $section) => $query->whereHas('gradeHandle', fn($q) => $q->where('section', $section)))
            ->when($filters['subject'], fn($query, $subject) => $query->whereHas('subject', fn($q) => $q->where('subject', $subject)))
            ->get();





        // Male Students
        $this->allMaleStudents = $this->allStudents->filter(fn($student) => $student->account->gender === 'Male');



        // Female Students
        $this->allFemaleStudents = $this->allStudents->filter(fn($student) => $student->account->gender === 'Female');

        // Grading Headers
        $this->gradingHeaders = GradingHeader::first();

        // Grade Handles
        $this->gradeHandles = TeacherGradeHandle::where('teacher_id', $this->user->id)
            ->distinct()
            ->get(['grade', 'section', 'strand']);

        // Student Grades
        $this->studentGrades = StudentGrade::where('teacher_id', $this->user->id)
            ->when($filters['grade'], fn($query, $grade) => $query->whereHas('studentHandle.gradeHandle', fn($q) => $q->where('grade', $grade)))
            ->when($filters['strand'], fn($query, $strand) => $query->whereHas('studentHandle.gradeHandle', fn($q) => $q->where('strand', $strand)))
            ->when($filters['section'], fn($query, $section) => $query->whereHas('studentHandle.gradeHandle', fn($q) => $q->where('section', $section)))
            ->when($filters['subject'], fn($query, $subject) => $query->whereHas('studentHandle.gradeHandle.subjects', fn($q) => $q->where('subject', $subject)))
            ->get();
        
        // End 
        
        
        
        $grades = TeacherGradeHandle::where('teacher_id', $this->user->id)
            ->distinct()
            ->pluck('grade');

            
            
            $strands = DB::table('teacher_grade_handles')
    ->join('subject_models', 'teacher_grade_handles.id', '=', 'subject_models.grade_handle_id')
    ->join('student_handles', 'teacher_grade_handles.id', '=', 'student_handles.grade_handle_id')
    ->join('student_accounts', 'student_accounts.id', '=', 'student_handles.student_id')
    ->where('teacher_grade_handles.teacher_id', Auth::id())
    ->when($request->grade, fn($query) => $query->where('student_accounts.grade', $request->grade))
    ->distinct()
    ->pluck('student_accounts.strand');
    
    $sections = DB::table('teacher_grade_handles')
    //->join('subject_models', 'teacher_grade_handles.id', '=', 'subject_models.grade_handle_id')
    ->join('student_handles', 'teacher_grade_handles.id', '=', 'student_handles.grade_handle_id')
    ->join('student_accounts', 'student_accounts.id', '=', 'student_handles.student_id')
    ->where('teacher_grade_handles.teacher_id', Auth::id())
    ->when($request->grade, fn($query) => $query->where('student_accounts.grade', $request->grade))
    ->when($request->strand, fn($query) => $query->where('student_accounts.strand', $request->strand))
    ->distinct()
    ->pluck('student_accounts.section');
            
        

        $allStudents = collect();
        $allMaleStudents = collect();
        $allFemaleStudents = collect();
        $studentGrades = collect();
        $highestPossibleScores = HighestPossibleScoreGradingSheet::where('teacher_id', $this->user->id)->first();

        if ($request->filled('section')) {
            $studentQuery = StudentHandle::with('account')
                ->join('teacher_grade_handles', 'student_handles.grade_handle_id', '=', 'teacher_grade_handles.id')
                ->join('subject_models', 'student_handles.grade_handle_id', '=', 'subject_models.grade_handle_id')
                ->select('student_handles.*', 'teacher_grade_handles.grade', 'teacher_grade_handles.strand', 'teacher_grade_handles.section')
                ->where('student_handles.teacher_id', $this->user->id);

            if ($request->filled('grade')) {
                $studentQuery->where('teacher_grade_handles.grade', $request->grade);
            }
            if ($request->filled('strand')) {
                $studentQuery->where('teacher_grade_handles.strand', $request->strand);
            }
            if ($request->filled('section')) {
                $studentQuery->where('teacher_grade_handles.section', $request->section);
            }

            if ($request->filled('subject')) {
                $studentQuery->where('subject_models.subject', $request->subject);
            }

            $allStudents = $studentQuery->distinct()->get();
            $allMaleStudents = $allStudents->filter(fn($student) => $student->account->gender === 'Male');
            $allFemaleStudents = $allStudents->filter(fn($student) => $student->account->gender === 'Female');

            $studentIds = $allStudents->pluck('id');
            $studentGrades = StudentGrade::whereIn('student_id', $studentIds)
                ->where('teacher_id', $this->user->id)
                ->get();
        }

        $gradeHandle = null;
        $subjects = [];

        if ($request->filled('grade') && $request->filled('section') && $request->filled('strand')) {
            $gradeHandle = TeacherGradeHandle::where('teacher_id', Auth::id())
                ->where('grade', $request->grade)
                ->where('section', $request->section)
                ->where('strand', $request->strand)->first();
        }

        if (isset($gradeHandle)) {
            $subjects = SubjectModel::where('teacher_id', Auth::id())
                ->where('grade_handle_id', $gradeHandle->id)->get();
        }

        return view('teacher.students_grade.grading', [
            'user' => $this->user,
            'handleSubjects' => $this->handleSubjects,
            'allFemaleStudents' => $allFemaleStudents,
            'allMaleStudents' => $allMaleStudents,
            'StudentAccount' => StudentAccount::class,
            'gradingHeaders' => $this->gradingHeaders,
            'strands' => $strands,
            'sections' => $sections,
            'grades' => $grades,
            'highestPossibleScores' => $highestPossibleScores,
            'studentGrades' => $studentGrades,
            'subjects' => $subjects,
            //'percentage_filters' => $percentage_filters,
            'SubjectModel' => SubjectModel::class
        ]);
    }


    /**
     * ////////////////////////
     * //// FORM 137 PAGE /////
     * ////////////////////////
     */


    //  FRONT PAGE
    public function form137Front(Request $request, $id)
    {

        $student = StudentAccount::where('id', $id)
            ->first();



            $semesterQuarterCombinations = [
                ['semester' => 'First Semester', 'quarter' => 'First Quarter'],
                ['semester' => 'First Semester', 'quarter' => 'Second Quarter'],
                ['semester' => 'Second Semester', 'quarter' => 'Third Quarter'],
                ['semester' => 'Second Semester', 'quarter' => 'Fourth Quarter'],
            ];
    
            $grades = collect($semesterQuarterCombinations)
                ->mapWithKeys(function ($combination) use ($id) {
                    $key = "{$combination['semester']}_{$combination['quarter']}";
                    return [
                        $key => StudentGrade::where('student_id', $id)
                            ->where('semester', $combination['semester'])
                            ->where('quarter', $combination['quarter'])
                            ->get(),
                    ];
                });



        return view(
            'teacher.students_grade.form_137_card.form_137_front',
            [
                'user' => $this->user,
                'handleSubjects' => $this->handleSubjects,
                'student' => $student,
                'grades' => $grades,
                //'percentage_filters' => $percentage_filters
            ]
        );
    }

    //  BACK PAGE
    public function form137Back(Request $request, $id)
    {

        $student = StudentAccount::where('id', $id)
            ->first();

        $semesterQuarterCombinations = [
            ['semester' => 'First Semester', 'quarter' => 'First Quarter'],
            ['semester' => 'First Semester', 'quarter' => 'Second Quarter'],
            ['semester' => 'Second Semester', 'quarter' => 'Third Quarter'],
            ['semester' => 'Second Semester', 'quarter' => 'Fourth Quarter'],
        ];

        $grades = collect($semesterQuarterCombinations)
            ->mapWithKeys(function ($combination) use ($id) {
                $key = "{$combination['semester']}_{$combination['quarter']}";
                return [
                    $key => StudentGrade::where('student_id', $id)
                        ->where('semester', $combination['semester'])
                        ->where('quarter', $combination['quarter'])
                        ->get(),
                ];
            });


            // dd($grades);





        return view(
            'teacher.students_grade.form_137_card.form_137_back',
            [
                'user' => $this->user,
                'handleSubjects' => $this->handleSubjects,
                'student' => $student,
                'grades' => $grades
            ]
        );
    }

    /**
     * ///////////////////////////
     * ////END FORM 137 PAGE /////
     * ///////////////////////////
     */



    /**
     * //////////////////////
     * //// REPORT CARD /////
     * //////////////////////
     */


    //  FRONT PAGE
    public function reportCardFront(Request $request, $id)
    {

        $student = StudentAccount::where('id', $id)
            ->first();



        return view(
            'teacher.students_grade.report_card.report_card_front',
            [
                'user' => $this->user,
                'handleSubjects' => $this->handleSubjects,
                'student' => $student,
            ]
        );
    }

    //  BACK PAGE
    public function reportCardBack(Request $request, $id)
    {

        $student = StudentAccount::where('id', $id)
            ->first();

        $semesterQuarterCombinations = [
            ['semester' => 'First Semester', 'quarter' => 'First Quarter'],
            ['semester' => 'First Semester', 'quarter' => 'Second Quarter'],
            ['semester' => 'Second Semester', 'quarter' => 'Third Quarter'],
            ['semester' => 'Second Semester', 'quarter' => 'Fourth Quarter'],
        ];

        $grades = collect($semesterQuarterCombinations)
            ->mapWithKeys(function ($combination) use ($id) {
                $key = "{$combination['semester']}_{$combination['quarter']}";
                return [
                    $key => StudentGrade::where('student_id', $id)
                        ->where('semester', $combination['semester'])
                        ->where('quarter', $combination['quarter'])
                        ->distinct('subject')
                        ->get(),
                ];
            });


            // dd($grades);





        return view(
            'teacher.students_grade.report_card.report_card_back',
            [
                'user' => $this->user,
                'handleSubjects' => $this->handleSubjects,
                'student' => $student,
                'grades' => $grades
            ]
        );
    }

    /**
     * //////////////////////////
     * ////END REPORT CARD /////
     * /////////////////////////
     */
}