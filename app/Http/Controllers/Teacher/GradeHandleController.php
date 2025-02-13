<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherGradeHandle;
use Illuminate\{Http\Request, Support\Facades\Auth};


class GradeHandleController extends Controller
{
    public function viewUpdateGradeHandle($id)
    {
        $user = Auth::user();
        $grade_handle = TeacherGradeHandle::where('id', $id)->first();
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        return view('teacher.grade_handle.edit_grade_handle', [
            'grade_handle' => $grade_handle,
            'user' => $user,
            'id' => $id,
            'handleSubjects' => $handleSubjects
        ]);
    }

    public function getGradeId(Request $request)
    {
        // Retrieve the grade, strand, and section from the query parameters
        $grade = $request->query('grade');
        $strand = $request->query('strand');
        $section = $request->query('section');
        
        // Find the corresponding record in the teacher_grade_handle table
        $teacherGradeHandle = TeacherGradeHandle::where('grade', $grade)
                                                ->where('strand', $strand)
                                                ->where('section', $section)
                                                ->first();

        // Return the id if found, otherwise return null
        return response()->json([
            'id' => $teacherGradeHandle ? $teacherGradeHandle->id : null
        ]);
    }

public function updateGradeHandle(Request $request, $id)
{
    $validatedData = $request->validate([
        'grade' => 'required|integer',
        'section' => 'required|string|max:255',
        'strand' => 'required|string|max:255'
    ]);

    // Find the grade handle record by ID
    $grade_handle = TeacherGradeHandle::find($id);

    if (!$grade_handle) {
        return redirect()->route('teacher.dashboard')->with('error', 'Error: Data not found.');
    }

    // Check for duplicates excluding the current record
    $exists = TeacherGradeHandle::where('teacher_id', $grade_handle->teacher_id)
                ->where('grade', $validatedData['grade'])
                ->where('section', $validatedData['section'])
                ->where('strand', $validatedData['strand'])
                ->where('id', '!=', $id)
                ->exists();

    if ($exists) {
        return redirect()->back()->with('error', 'This grade handle combination already exists.');
    }

    // Update the grade handle details
    $grade_handle->update($validatedData);

    return redirect()->route('teacher.dashboard')->with('success', "Grade handle updated successfully");
}


    public function deleteGradeHandle(Request $request)
    {
        $grade_handle = TeacherGradeHandle::find($request->id);

        if (!$grade_handle) {
            return redirect()->route('teacher.dashboard')->with('error', 'Error: Data not found.');
        }

        $grade_handle->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Grade handle deleted successfully');
    }



    public function submitAddHandleGrade(Request $request)
    {
        $validatedData = $request->validate([
            'grade' => 'required|integer',
            'section' => 'required|string|max:255',
            'strand' => 'required|string|max:255'
        ]);

        $user = Auth::user();

        // Check if the grade handle exists for the authenticated teacher
        $exists = TeacherGradeHandle::where('teacher_id', $user->id)
            ->where('grade', $validatedData['grade'])
            ->where('section', $validatedData['section'])
            ->where('strand', $validatedData['strand'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This grade handle already exists.');
        }

        // Create the new grade handle
        $teacherGradeHandle = new TeacherGradeHandle($validatedData);
        $teacherGradeHandle->teacher_id = $user->id;
        $teacherGradeHandle->save();

        return redirect()->route('teacher.dashboard')->with('success', "Grade handle added successfully");
    }




    public function viewAddHandleGrade()
    {
        $user = Auth::user();
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        return view(
            'teacher.grade_handle.add_grade_handle',
            ['user' => $user, 'handleSubjects' => $handleSubjects]
        );
    }
}
