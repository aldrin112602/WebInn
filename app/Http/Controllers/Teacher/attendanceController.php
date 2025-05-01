<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Student\StudentAccount;
use Illuminate\Http\Request;
use App\Models\Student\AttendanceHistory;
use App\Models\TeacherGradeHandle;
use App\Models\Admin\SubjectModel;
use App\Models\FaceScan;
use App\Models\Teacher\TeacherAccount;



class attendanceController extends Controller
{

    public function attendaceReport(Request $request)
    {
        $user = Auth::guard('teacher')->user();
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        $query = StudentAccount::query();


        // Apply gender filter
        if ($request->has('gender') && $request->gender != ''  && $request->gender != 'All') {
            $query->where('gender', $request->gender);
        }

        // Apply strand filter
        if ($request->has('strand') && $request->strand != ''  && $request->strand != 'All') {
            $query->where('strand', $request->strand);
        }

        // Apply grade filter
        if ($request->has('grade') && $request->grade != ''  && $request->grade != 'All') {
            $query->where('grade', $request->grade);
        }

                
        
        $account_list = $query->paginate(10);


        return view('teacher.attendance.report', [
            'user' => $user,
            'account_list' => $account_list,
            'handleSubjects' => $handleSubjects
        ]);
    }


    public function viewAttendanceHistory(Request $request, $id)
    {
        $user = Auth::guard('teacher')->user();
        $attendace_histories = AttendanceHistory::where('student_id', $id)->get();
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();

        // Apply status filter
        // if ($request->has('status') && in_array($request->status, ['absent', 'present'])) {
        //     $attendace_histories_query->where('status', $request->status);
        // }
        
        


        return view('teacher.attendance.view_attendance_history', [
            'user' => $user,
            'attendace_histories' => $attendace_histories,
            'TeacherGradeHandle' => TeacherGradeHandle::class,
            'SubjectModel' => SubjectModel::class,
            'TeacherAccount' => TeacherAccount::class,
            'student' => StudentAccount::where('id', $id)->first(),
            'handleSubjects' => $handleSubjects
        ]);
    }



    public function attendaceAbsent(Request $request)
    {
        $user = Auth::guard('teacher')->user();
        $scannedStudentIds = FaceScan::pluck('student_id')->toArray();

        $query = StudentAccount::query()->whereNotIn('id', $scannedStudentIds);


        // Apply gender filter
        if ($request->has('gender') && $request->gender != ''  && $request->gender != 'All') {
            $query->where('gender', $request->gender);
        }

        // Apply strand filter
        if ($request->has('strand') && $request->strand != ''  && $request->strand != 'All') {
            $query->where('strand', $request->strand);
        }

        // Apply grade filter
        if ($request->has('grade') && $request->grade != ''  && $request->grade != 'All') {
            $query->where('grade', $request->grade);
        }


        $studentsWithoutFaceScan = $query->paginate(10);
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        return view('teacher.attendance.absent', [
            'user' => $user,
            'studentsWithoutFaceScan' => $studentsWithoutFaceScan,
            'handleSubjects' => $handleSubjects
        ]);
    }

    public function attendacePresent()
    {
        $user = Auth::guard('teacher')->user();
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        return view('teacher.attendance.present', [
            'user' => $user,
            'presents' => FaceScan::paginate(10),
            'StudentAccount' => StudentAccount::class,
            'handleSubjects' => $handleSubjects
        ]);
    }
}
