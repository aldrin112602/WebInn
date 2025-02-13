<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Rules\ValidFullName;
use Illuminate\{Http\Request, Support\Facades\Auth};
use App\Models\{StudentHandle, Student\StudentAccount, History, StudentImage, TeacherGradeHandle};
use App\Services\PHPMailerService;


class Account extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function deleteStudentAccount(Request $request)
    {
        $id = request()->query('id');

        if (!$id || !TeacherGradeHandle::find($id)) {
            return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
        }

        $auth_user = Auth::user();

        // delete student account and student handle
        StudentAccount::where('id', $request->id)->delete();
        StudentHandle::where('student_id', $request->id)->delete();
        StudentImage::where('student_id', $request->id)->delete();

        // create history
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted student account",
                'description' => "Deleted id: $request->id"
            ]
        );

        return redirect()->route(
            'teacher.student_list',
            [
                'id' => $id
            ]
        )->with('success', 'Account deleted successfully');
    }

    public function deleteSelectedStudents(Request $request)
    {
        $id = request()->query('id');
        if (!$id || !TeacherGradeHandle::find($id)) {
            return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
        }


        $ids = $request->input('selected_ids');
        $idsArray = explode(',', $ids);
        $auth_user = Auth::user();

        // delete student account and student handle
        StudentAccount::whereIn('id', $idsArray)->delete();
        StudentHandle::whereIn('student_id', $idsArray)->delete();
        StudentImage::whereIn('student_id', $idsArray)->delete();

        // create history
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted all selected students account",
                'description' => "Deleted ids: $ids"
            ]
        );

        return redirect()->route(
            'teacher.student_list',
            [
                'id' => $id
            ]
        )->with('success', 'Selected row' . (count($idsArray) == 1 ? '' : 's') . ' have been deleted!');
    }



    public function viewAddStudent()
    {
        $user = Auth::user();
        $id_number = $this->getRandomNumbers();
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        $id = request()->query('id');
        if (!$id || !TeacherGradeHandle::find($id)) {
            return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
        }
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        $grade_handle = TeacherGradeHandle::find($id);

        return view('teacher.account.add_student', ['user' => $user, 'id_number' => $id_number, 'handleSubjects' => $handleSubjects, 'grade_handle' => $grade_handle]);
    }


    public function submitAddStudent(Request $request)
    {
        $request->validate([
            'id_number' => 'required|min:5|max:255|unique:student_accounts,id_number',
            'name' => ['required', 'string', 'max:255', new ValidFullName],
            'gender' => 'required|string|in:Male,Female',
            'username' => 'required|string|unique:student_accounts,username',
            'password' => 'required|string|min:6|max:255',
            'parents_email' => 'required',
            'lrn' => 'required|min:12|max:12',
            'birthdate' => 'required',
            'parents_contact_number' => 'required|string|min:11|max:11',
            'email' => 'required|email|unique:student_accounts,email',
            'profile' => 'required|image|max:10240',
            'phone_number' => 'required|string|min:11|max:11',
            'face_images' => 'required|array|min:3|max:3',
            'face_images.*' => 'required|image|max:10240',
        ]);

        $id = request()->query('id');
        if (!$id || !TeacherGradeHandle::find($id)) {
            return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
        }
        $grade_handle = TeacherGradeHandle::find($id);

        $account = new StudentAccount($request->all());

        // Handle profile photo upload
        $profileDestination = public_path('storage/profiles');
        if (!file_exists($profileDestination)) {
            mkdir($profileDestination, 0777, true);
        }

        $profileFile = $request->file('profile');
        $profileFileName = time() . '_' . $profileFile->getClientOriginalName();
        $profileFile->move($profileDestination, $profileFileName);
        $account->profile = 'profiles/' . $profileFileName;
        $account->save();

        // Handle face images upload (expecting exactly 3 images)
        if ($request->hasFile('face_images')) {
            $faceImagesPath = public_path('storage/face_images/' . $account->name);
            if (!file_exists($faceImagesPath)) {
                mkdir($faceImagesPath, 0777, true);
            }

            foreach ($request->file('face_images') as $index => $file) {
                $imageName = "$index.jpg";
                $file->move($faceImagesPath, $imageName);

                StudentImage::create([
                    'student_id' => $account->id,
                    'image_path' => 'face_images/' . $account->name . '/' . $imageName,
                ]);
            }
        }

        $auth_user = Auth::user();
        History::create([
            'user_id' => $auth_user->id,
            'position' => $auth_user->role,
            'history' => "Create student account",
            'description' => 'ID Number: ' . $account->id_number . ', Name: ' . $account->name
        ]);

        StudentHandle::create([
            'student_id' => $account->id,
            'teacher_id' => $auth_user->id,
            'grade_handle_id' => $grade_handle->id
        ]);

        $sent = $this->mailerService->sendAccountCredentials($account->email, $account->username, $request->password, $account->name, 'student');

        if (!$sent) {
            return redirect()->back()->with('error', 'Failed to send account credentials via email.');
        }

        return redirect()
            ->route('teacher.student_list', ['id' => $grade_handle->id])
            ->with('success', 'Account added successfully!');
    }










    public function getRandomNumbers($count = 1)
    {
        $randomNumbers = [];
        for ($i = 0; $i < $count; $i++) {
            $randomNumbers[] = rand(100000, 999999);
        }
        return $randomNumbers[0];
    }
}
