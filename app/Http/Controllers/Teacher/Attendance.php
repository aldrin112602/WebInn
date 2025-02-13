<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\{Http\Request, Support\Facades\Auth};
use App\Models\{TeacherGradeHandle, Student\StudentAccount};

class Attendance extends Controller
{

    public function absents(Request $request)
    {
        $id = request()->query('id');
        $user = Auth::user();


        if (!$id || !TeacherGradeHandle::find($id)) {
            return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
        }

        $grade_handle = TeacherGradeHandle::find($id);
        $query = StudentAccount::query();

        // Apply gender filter
        if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
            $query->where('gender', $request->gender);
        }


        $grade_handle = TeacherGradeHandle::find($id);

        $query->where('grade', $grade_handle->grade);
        $query->where('strand', $grade_handle->strand);
        $query->where('section', $grade_handle->section);


        // Only get students taught by the teacher with the specified grade handle
        $account_list = $query->whereHas('studentHandles', function ($q) use ($user, $id) {
            $q
                ->where('teacher_id', $user->id)
                ->where('grade_handle_id', $id);
        })->paginate(10);


        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();


        return view(
            'teacher.students.absents',
            [
                'id' => $id,
                'grade_handle' => $grade_handle,
                'account_list' => $account_list,
                'handleSubjects' => $handleSubjects,
                'user' => $user
            ]
        );
    }



    public function presents(Request $request)
    {
        $id = request()->query('id');
        $user = Auth::user();


        if (!$id || !TeacherGradeHandle::find($id)) {
            return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
        }

        $grade_handle = TeacherGradeHandle::find($id);
        $query = StudentAccount::query();

        // Apply gender filter
        if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
            $query->where('gender', $request->gender);
        }


        $grade_handle = TeacherGradeHandle::find($id);

        $query->where('grade', $grade_handle->grade);
        $query->where('strand', $grade_handle->strand);
        $query->where('section', $grade_handle->section);


        // Only get students taught by the teacher with the specified grade handle
        $account_list = $query->whereHas('studentHandles', function ($q) use ($user, $id) {
            $q
                ->where('teacher_id', $user->id)
                ->where('grade_handle_id', $id);
        })->paginate(10);


        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();


        return view(
            'teacher.students.presents',
            [
                'id' => $id,
                'grade_handle' => $grade_handle,
                'account_list' => $account_list,
                'handleSubjects' => $handleSubjects,
                'user' => $user
            ]
        );
    }
}
