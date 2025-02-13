<?php

namespace App\Http\Controllers\Admin;

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
        $user = Auth::guard('admin')->user();

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


        return view('admin.attendance.report', [
            'user' => $user,
            'account_list' => $account_list
        ]);
    }


    public function viewAttendanceHistory(Request $request, $id)
    {
        $user = Auth::guard('admin')->user();
        $attendace_histories = AttendanceHistory::query()->where('student_id', $id);

        // Apply status filter
        if (request()->query('status') && in_array(request()->query('status'), ['absent', 'present'])) {
            $attendace_histories->where('status', request()->query('status'));
        }


        return view('admin.attendance.view_attendance_history', [
            'user' => $user,
            'attendace_histories' => $attendace_histories->get(),
            'TeacherGradeHandle' => TeacherGradeHandle::class,
            'SubjectModel' => SubjectModel::class,
            'TeacherAccount' => TeacherAccount::class,
            'student' => StudentAccount::where('id', $id)->first()
        ]);
    }



    public function attendaceAbsent(Request $request)
    {
        $user = Auth::guard('admin')->user();
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
        return view('admin.attendance.absent', [
            'user' => $user,
            'studentsWithoutFaceScan' => $studentsWithoutFaceScan
        ]);
    }

    public function attendacePresent(Request $request)
    {
        $user = Auth::guard('admin')->user();

        // Start a query with joins to link FaceScan and StudentAccount
        $query = FaceScan::query()
            ->join('student_accounts', 'face_scans.student_id', '=', 'student_accounts.id')
            ->select('face_scans.*', 'student_accounts.*');

        // Apply gender filter
        if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
            $query->where('student_accounts.gender', $request->gender);
        }

        // Apply strand filter
        if ($request->has('strand') && $request->strand != '' && $request->strand != 'All') {
            $query->where('student_accounts.strand', $request->strand);
        }

        // Apply grade filter
        if ($request->has('grade') && $request->grade != '' && $request->grade != 'All') {
            $query->where('student_accounts.grade', $request->grade);
        }

        return view('admin.attendance.present', [
            'user' => $user,
            'presents' => $query->paginate(10),
        ]);
    }
}
