<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\FaceScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherGradeHandle;
use App\Models\Student\StudentAccount;
use Carbon\Carbon;

class FaceScanController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $faceScans = FaceScan::select('student_id', 'time', 'created_at')->get();
        $face_scanned_student_ids = $faceScans->pluck('student_id');
        $query = StudentAccount::whereIn('id', $face_scanned_student_ids);
        if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
            $query->where('gender', $request->gender);
        }
        if ($request->has('strand') && $request->strand != '' && $request->strand != 'All') {
            $query->where('strand', $request->strand);
        }
        if ($request->has('grade') && $request->grade != '' && $request->grade != 'All') {
            $query->where('grade', $request->grade);
        }
        $account_list = $query->paginate(10);
        $account_list->map(function($student) use ($faceScans) {
            $scan = $faceScans->firstWhere('student_id', $student->id);
            if ($scan) {
                $student->time_in = Carbon::parse($scan->time)->format('h:i A');
                $student->scan_created_at = Carbon::parse($scan->created_at)->format('Y-m-d h:i A');
            } else {
                $student->time_in = null;
                $student->scan_created_at = null;
            }
            return $student;
        });

        // Return the view with relevant data
        return view('admin.facescan.index', [
            'user' => $user,
            'account_list' => $account_list,
        ]);
    }
}
