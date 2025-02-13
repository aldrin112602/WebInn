<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\FaceScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherGradeHandle;
use App\Models\Student\StudentAccount;
use App\Models\StudentHandle;
use Carbon\Carbon;

class FaceScanController extends Controller
{
    public function index(Request $request) {

        // Get the authenticated teacher
        $user = Auth::user();

        // Get the subjects/grades handled by the teacher
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();

        // Get student handles
        $student_handle_ids = StudentHandle::where('teacher_id', $user->id)->pluck('student_id');

        // Retrieve all face scans of handled students
        $faceScans = FaceScan::whereIn('student_id', $student_handle_ids)
            ->select('student_id', 'time', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);



        // Return the view with relevant data
        return view('teacher.facescan.index', [
            'user' => $user,
            'faceScans' => $faceScans,
            'handleSubjects' => $handleSubjects,
            'StudentAccount' => StudentAccount::class,
            'Carbon' => Carbon::class
        ]);
    }
}
