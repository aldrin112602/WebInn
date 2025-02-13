<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherGradeHandle;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentHandle;
use App\Models\QrGenerate;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\SubjectModel;
use App\Models\Teacher\TeacherAccount;
use Illuminate\Support\Carbon;
use App\Models\Student\StudentAccount;


class ClassHistory extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();

            $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
            $allStudentsCount = count(StudentHandle::where('teacher_id', $user->id)->get());

            // Simplified query
            $qrHistory = QrGenerate::where('teacher_id', $user->id)
                ->whereIn('id', function ($query) use ($user) {
                    $query->select(DB::raw('MIN(id)'))
                        ->from('qr_generates')
                        ->where('teacher_id', $user->id)
                        ->groupBy(
                            DB::raw('DATE(created_at)'),
                            'subject_id'
                        );
                })
                ->orderBy('created_at', 'desc')
                ->get();

            // Get subject details for each QR code
            foreach ($qrHistory as $history) {
                $history->subjectDetails = SubjectModel::where('id', $history->subject_id)->where('teacher_id', Auth::id())->first();
            }

            return view(
                'teacher.class_history.index',
                [
                    'user' => $user,
                    'handleSubjects' => $handleSubjects,
                    "allStudentsCount" => $allStudentsCount,
                    "qrHistory" => $qrHistory,
                ]
            );
        }

        return redirect()->route('teacher.login');
    }



    public function view_class_history($id)
{
    if (Auth::guard('teacher')->check()) {
        $user = Auth::user();
        
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();

        // Get subject details
        $subject = SubjectModel::where('teacher_id', Auth::id())
            ->where('id', $id)
            ->first();

        // Get today's date
        $today = Carbon::now()->format('Y-m-d');

        // Get attendance records for the subject for today only
        $attendance = QrGenerate::where('teacher_id', $user->id)
            ->where('subject_id', $id)
            ->whereDate('created_at', $today)
            ->get();

        // Get all students handled by this teacher with their account details
        $students = StudentHandle::where('teacher_id', $user->id)
            ->join('student_accounts', 'student_handles.student_id', '=', 'student_accounts.id')
            ->select('student_accounts.*', 'student_handles.student_id')
            ->get();

        return view(
            'teacher.class_history.view_class_history',
            [
                'user' => $user,
                'handleSubjects' => $handleSubjects,
                'subject' => $subject,
                'teacher' => $user,
                'attendance' => $attendance,
                'students' => $students,
                'selected_date' => $today
            ]
        );
    }

    return redirect()->route('teacher.login');
}
}
