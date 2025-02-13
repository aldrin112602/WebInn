<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\{Http\Request, Support\Facades\Auth};
use App\Models\{
    Student\StudentAccount as Student,
    Admin\AdminAccount as Admin,
    Teacher\TeacherAccount as Teacher,
    Guidance\GuidanceAccount as Guidance,
    Admin\SubjectModel as Subject,
    History,
    StudentHandle,
    StudentImage
};

class deleteSelected extends Controller
{
    public function deleteSelectedStudents(Request $request)
    {
        $ids = $request->input('selected_ids');
        $idsArray = explode(',', $ids);

        Student::whereIn('id', $idsArray)->delete();
        StudentHandle::whereIn('student_id', $idsArray)->delete();
        StudentImage::whereIn('student_id', $idsArray)->delete();

        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted all selected students account",
                'description' => "Deleted ids: $ids"
            ]
        );

        return redirect()->route('admin.student_list')->with('success', 'Selected row' . (count($idsArray) == 1 ? '' : 's') . ' have been deleted!');
    }

    public function deleteSelectedAdmins(Request $request)
    {
        $ids = $request->input('selected_ids');
        $idsArray = explode(',', $ids);

        Admin::whereIn('id', $idsArray)->delete();

        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted all selected admins account",
                'description' => "Deleted ids: $ids"
            ]
        );

        return redirect()->route('admin.admin_list')->with('success', 'Selected row' . (count($idsArray) == 1 ? '' : 's') . ' have been deleted!');
    }

    public function deleteSelectedTeachers(Request $request)
    {
        $ids = $request->input('selected_ids');
        $idsArray = explode(',', $ids);

        Teacher::whereIn('id', $idsArray)->delete();

        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted all selected teachers account",
                'description' => "Deleted ids: $ids"
            ]
        );

        return redirect()->route('admin.teacher_list')->with('success', 'Selected row' . (count($idsArray) == 1 ? '' : 's') . ' have been deleted!');
    }

    public function deleteSelectedGuidances(Request $request)
    {
        $ids = $request->input('selected_ids');
        $idsArray = explode(',', $ids);

        Guidance::whereIn('id', $idsArray)->delete();

        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted all selected guidances account",
                'description' => "Deleted ids: $ids"
            ]
        );

        return redirect()->route('admin.guidance_list')->with('success', 'Selected row' . (count($idsArray) == 1 ? '' : 's') . ' have been deleted!');
    }


    public function deleteSelectedSubjects(Request $request)
    {
        $ids = $request->input('selected_ids');
        $idsArray = explode(',', $ids);

        Subject::whereIn('id', $idsArray)->delete();
        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted all selected subjects",
                'description' => "Deleted ids: $ids"
            ]
        );

        return redirect()->route('admin.subject_list')->with('success', 'Selected row' . (count($idsArray) == 1 ? '' : 's') . ' have been deleted!');
    }
}
