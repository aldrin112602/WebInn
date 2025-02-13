<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\{Http\Request, Support\Facades\Auth};
use App\Models\TeacherGradeHandle;

class GradeHandleController extends Controller
{
    public function viewUpdateGradeHandle($id)
    {
        $grade_handle = TeacherGradeHandle::where('id', $id)->first();
        if (!$grade_handle) {
            return redirect()->route('admin.teacher_list')->with('error', 'Error: Data not found.');
        }
        $user = Auth::user();
        return view('admin.account_management.edit_grade_handle', [
            'grade_handle' => $grade_handle,
            'id' => $id,
            'user' => $user
        ]);
    }

    public function updateGradeHandle(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|integer',
            'section' => 'required|string|max:255',
            'strand' => 'required|string|max:255'
        ]);

        $grade_handle = TeacherGradeHandle::where('id', $id)->first();
        if (!$grade_handle) {
            return redirect()->route('admin.view.grade_handle', ['id' => $id])->with('error', 'Error: Data not found.');
        }

        $grade_handle->grade = $request->grade;
        $grade_handle->section = $request->section;
        $grade_handle->strand = $request->strand;
        $grade_handle->save();

        return redirect()->route('admin.view.grade_handle', ['id' => $grade_handle->teacher_id])->with('success', "Grade handle updated successfully");
    }

    public function deleteGradeHandle(Request $request)
    {
        $grade_handle = TeacherGradeHandle::find($request->id);
        if (!$grade_handle) {
            return redirect()->route('admin.teacher_list')->with('error', 'Error: Data not found.');
        }

        $teacher_id = $grade_handle->teacher_id;
        $grade_handle->delete();

        return redirect()->route('admin.view.grade_handle', ['id' => $teacher_id])->with('success', 'Grade handle deleted successfully');
    }
}
