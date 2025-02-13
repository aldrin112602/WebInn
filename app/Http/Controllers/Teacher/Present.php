<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\{Carbon, Facades\Auth};
use App\Models\{
    StudentHandle, 
    Present as PresentModel, 
    Student\StudentAccount as Student
};


class Present extends Controller
{
    public function presentCount(Request $request) {
        $user = Auth::user();
        $today = Carbon::today();

        $presents = PresentModel::where('subject_id', $request->subject_id)
            ->where('teacher_id', $user->id)
            ->where('grade_handle_id', $request->grade_handle_id)
            ->whereDate('created_at', $today)
            ->get();

        return response()->json([
            'count' => $presents->count()
        ]);
    }

    public function absentCount(Request $request) {
        $user = Auth::user();
        $today = Carbon::today();

        // Count students who were present
        $presentCount = PresentModel::where('subject_id', $request->subject_id)
            ->where('teacher_id', $user->id)
            ->where('grade_handle_id', $request->grade_handle_id)
            ->whereDate('created_at', $today)
            ->count();

        $allHandleStudents = StudentHandle::where('grade_handle_id', $request->grade_handle_id)
        ->where('teacher_id', $user->id)->count();


        $absentCount = ($allHandleStudents - $presentCount) < 0 ? 0 : ($allHandleStudents - $presentCount);

        
        return response()->json([
            'count' => $absentCount
        ]);
    }
}
