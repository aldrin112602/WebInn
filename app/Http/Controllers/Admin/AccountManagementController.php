<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\ValidFullName;


use Illuminate\{
    Http\Request,
    Support\Facades\Auth,
    Support\Carbon
};

use App\Models\{
    Student\StudentAccount,
    Admin\AdminAccount,
    Teacher\TeacherAccount,
    Guidance\GuidanceAccount,
    History,
    TeacherGradeHandle,
    StudentImage
};
use App\Services\PHPMailerService;


class AccountManagementController extends Controller
{


    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }


    public function submitAddHandleGrade(Request $request)
    {
        $teacher = TeacherAccount::find($request->id);
        if (!$teacher) {
            return redirect()->route('admin.teacher_list')->with('error', "User does not exist");
        }

        $validatedData = $request->validate(
            [
                'grade' => 'required|integer',
                'section' => 'required|string|max:255',
                'strand' => 'required|string|max:255'
            ]
        );

        $teacherGradeHandle = new TeacherGradeHandle($validatedData);
        $teacherGradeHandle->teacher_id = $request->teacher_id;
        $teacherGradeHandle->save();

        return redirect()->route('admin.view.grade_handle', $request->teacher_id)->with('success', "Grade handle added successfully");
    }



    public function viewAddHandleGrade($id)
    {
        $user = Auth::guard('admin')->user();

        // if user does not exist
        $teacher = TeacherAccount::find($id);
        if (!$teacher) {
            return redirect()->route('admin.teacher_list')->with('error', "User does not exist");
        }

        return view(
            'admin.account_management.add_grade_handle',
            [
                'user' => $user,
                'id' => $id
            ]
        );
    }



    public function viewGradeHandle($id)
    {
        // if user does not exist
        $teacher = TeacherAccount::find($id);
        if (!$teacher) {
            return redirect()->route('admin.teacher_list')->with('error', "User does not exist");
        }

        $records = TeacherGradeHandle::where('teacher_id', $id)->paginate(10);
        $user = Auth::guard('admin')->user();

        $records->each(function ($list) {
            $list->time_ago = Carbon::parse($list->created_at);
        });


        return view(
            'admin.account_management.grade_handle',
            [
                'records' => $records,
                'id' => $id,
                'user' => $user,
            ]
        );
    }

    public function grade_student_list(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            $query = StudentAccount::query();


            // Apply gender filter
            if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
                $query->where('gender', $request->gender);
            }

            // Apply strand filter
            if ($request->has('strand') && $request->strand != '' && $request->strand != 'All') {
                $query->where('strand', $request->strand);
            }

            // Apply grade filter
            if ($request->has('grade') && $request->grade != '' && $request->grade != 'All') {
                $query->where('grade', $request->grade);
            }

            $account_list = $query->paginate(10);

            return view(
                'admin.grade.student_list',
                [
                    'user' => $user,
                    'account_list' => $account_list
                ]
            );
        }

        return redirect()->route('admin.login');
    }




    public function student_list(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            $query = StudentAccount::query();


            // Apply gender filter
            if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
                $query->where('gender', $request->gender);
            }

            // Apply strand filter
            if ($request->has('strand') && $request->strand != '' && $request->strand != 'All') {
                $query->where('strand', $request->strand);
            }

            // Apply grade filter
            if ($request->has('grade') && $request->grade != '' && $request->grade != 'All') {
                $query->where('grade', $request->grade);
            }

            $account_list = $query->paginate(10);

            return view('admin.account_management.student_list', ['user' => $user, 'account_list' => $account_list]);
        }

        return redirect()->route('admin.login');
    }

    public function admin_list(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $query = AdminAccount::where('id', '!=', Auth::id());


            // Apply gender filter
            if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
                $query->where('gender', $request->gender);
            }



            $account_list = $query->paginate(10);
            return view('admin.account_management.admin_list', ['user' => $user, 'account_list' => $account_list]);
        }

        return redirect()->route('admin.login');
    }

    public function teacher_list(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            $query = TeacherAccount::query();

            // Apply gender filter
            if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
                $query->where('gender', $request->gender);
            }

            // Apply position filter
            if ($request->has('position') && $request->position != '' && $request->position != 'All') {
                $query->where('position', $request->position);
            }

            // Apply grade_handle filter
            if ($request->has('grade_handle') && $request->grade_handle != '' && $request->grade_handle != 'All') {
                $query->where('grade_handle', $request->grade_handle);
            }

            $account_list = $query->paginate(10);

            return view('admin.account_management.teacher_list', ['user' => $user, 'account_list' => $account_list]);
        }

        return redirect()->route('admin.login');
    }

    public function guidance_list(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $query = GuidanceAccount::query();


            // Apply gender filter
            if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
                $query->where('gender', $request->gender);
            }



            $account_list = $query->paginate(10);
            return view('admin.account_management.guidance_list', ['user' => $user, 'account_list' => $account_list]);
        }

        return redirect()->route('admin.login');
    }


    /***
     * 
     * //////////////////////////////////////////////////
     * ////// Student account (Update, delete, view) ////
     * //////////////////////////////////////////////////
     * 
     */
    public function deleteStudent($id)
    {
        if (Auth::guard('admin')->check()) {
            $student = StudentAccount::findOrFail($id);

            // Delete face images for the student
            StudentImage::where('student_id', $student->id)->delete();

            $directory = public_path('storage/face_images/' . $student->name);
            if (is_dir($directory)) {
                array_map('unlink', glob($directory . '/*'));
                rmdir($directory);
            }


            // Delete the student's profile photo if it exists
            if ($student->profile && file_exists(public_path($student->profile))) {
                unlink(public_path($student->profile));
            }


            $student->delete();

            $user = Auth::user();
            History::create(
                [
                    'user_id' => $user->id,
                    'position' => $user->role ?? 'Admin',
                    'history' => "Deleted student account",
                    'description' => 'ID Number: ' . $student->id_number . ', Name: ' . $student->name
                ]
            );

            return redirect()->route('admin.student_list')->with('success', 'Student deleted successfully');
        }

        return redirect()->route('admin.login');
    }

    public function editStudent($id)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $student = StudentAccount::findOrFail($id);

            return view('admin.account_management.edit_student', ['user' => $user, 'student' => $student]);
        }

        return redirect()->route('admin.login');
    }



    public function updateStudent(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $user = StudentAccount::findOrFail($id);



            // Validate input
            $request->validate([
                'name' => ['required', 'string', 'max:255', new ValidFullName],
                'new_password' => 'nullable|string|min:6|max:255',
                'parents_contact_number' => 'required|string|min:11|max:11',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'phone_number' => 'required|string|min:11|max:11',
                'address' => 'nullable|string|max:255',
                'parents_email' => 'required',
                'lrn' => 'required|min:12|max:12',
                'birthdate' => 'required',
                'extension_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:student_accounts,email,' . $user->id,
                'id_number' => 'required|min:5|max:255|unique:student_accounts,id_number,' . $user->id,
            ]);

            $oldName = $user->name;
            $newName = $request->name;

            // If the name has changed, rename the face images folder
            $oldFaceImagesPath = public_path("storage/face_images/$oldName");
            $newFaceImagesPath = public_path("storage/face_images/$newName");

            if ($oldName !== $newName && file_exists($oldFaceImagesPath)) {
                rename($oldFaceImagesPath, $newFaceImagesPath);
            }

            // Update basic user information
            $user->update([
                'name' => $request->name,
                'id_number' => $request->id_number,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'gender' => $request->gender,
                'parents_email' => $request->parents_email,
                'extension_name' => $request->extension_name,
                'parents_contact_number' => $request->parents_contact_number,
                'lrn' => $request->lrn,
                'birthdate' => $request->birthdate,
            ]);

            // Update password if provided
            if ($request->filled('new_password')) {
                $user->password = $request->new_password;
            }

            // Update username if provided
            if ($request->filled('username')) {
                $user->username = $request->username;
            }

            // Handle profile photo upload
            if ($request->hasFile('profile')) {
                $destinationPath = public_path('storage/profiles');
                $file = $request->file('profile');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Check if the directory exists, if not, create it
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Delete the existing profile photo if it exists
                if ($user->profile && file_exists(public_path($user->profile))) {
                    unlink(public_path($user->profile));
                }

                // Move the uploaded file
                $file->move($destinationPath, $fileName);
                $user->profile = 'profiles/' . $fileName;
            }

            // Handle face images upload (expecting exactly 3 images)
            if ($request->hasFile('face_images') && count($request->file('face_images')) === 3) {
                // Delete existing face images for the student
                StudentImage::where('student_id', $user->id)->delete();

                // Ensure the new folder exists
                if (!file_exists($newFaceImagesPath)) {
                    mkdir($newFaceImagesPath, 0777, true);
                }

                foreach ($request->file('face_images') as $index => $file) {
                    $imageName = "$index.jpg";
                    $file->move($newFaceImagesPath, $imageName);

                    StudentImage::create([
                        'student_id' => $user->id,
                        'image_path' => "face_images/$newName/$imageName",
                    ]);
                }
            }

            $user->save();


            // Log history of the update
            $auth_user = Auth::user();
            History::create([
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Updated user account",
                'description' => 'ID Number: ' . $user->id_number . ', Name: ' . $user->name,
            ]);


            if (isset($request->new_password)) {
                $sent = $this->mailerService->sendUpdatedPassword($user->email, $request->new_password, $user->username, $user->name, 'student');

                if (!$sent) {
                    return redirect()->back()->with('error', 'Failed to send account credentials via email.');
                }
            }

            // Redirect with success message
            return redirect()->route('admin.student_list')->with('success', 'Student updated successfully');
        }

        return redirect()->route('admin.login');
    }


    /////////////////// END /////////////////////





    /***
     * 
     * //////////////////////////////////////////////////
     * ////// Teacher account (Update, delete, view) ////
     * //////////////////////////////////////////////////
     * 
     */
    public function deleteTeacher($id)
    {
        if (Auth::guard('admin')->check()) {
            $teacher = TeacherAccount::findOrFail($id);
            $teacher->delete();

            return redirect()->route('admin.teacher_list')->with('success', 'Teacher deleted successfully');
        }

        return redirect()->route('admin.login');
    }

    public function editTeacher($id)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $teacher = TeacherAccount::findOrFail($id);

            return view('admin.account_management.edit_teacher', ['user' => $user, 'teacher' => $teacher]);
        }

        return redirect()->route('admin.login');
    }


    public function updateTeacher(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $user = TeacherAccount::findOrFail($id);

            // Validate input
            $request->validate([
                'id_number' => 'required|min:5|max:255|unique:teacher_accounts,id_number,' . $user->id,
                'name' => ['required', 'string', 'max:255', new ValidFullName],
                'new_password' => 'nullable|string|min:6|max:255',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'phone_number' => 'required|string|min:11|max:11',
                'address' => 'nullable|string|max:255',
                'extension_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:teacher_accounts,email,' . $user->id,
                'position' => 'required',
            ]);

            // Update basic user information
            $user->update([
                'id_number' => $request->id_number,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'extension_name' => $request->extension_name,
                'gender' => $request->gender,
                'grade_handle' => $request->grade_handle,
                'position' => $request->position,
            ]);

            // Update password if provided
            if ($request->filled('new_password')) {
                $user->password = $request->new_password;
            }

            // Handle profile photo upload with folder check
            if ($request->hasFile('profile')) {
                // Define the target directory in the public path
                $destinationPath = public_path('storage/profiles');
                $file = $request->file('profile');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Check if the directory exists, if not, create it
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Check if the user has an existing profile photo and delete it
                if ($user->profile && file_exists(public_path($user->profile))) {
                    unlink(public_path($user->profile));
                }

                // Move the uploaded file to the target directory
                $file->move($destinationPath, $fileName);

                // Save the file path without extra 'storage/' prefix in the database
                $user->profile = 'profiles/' . $fileName;
            }
            $user->save();



            if (isset($request->new_password)) {
                $sent = $this->mailerService->sendUpdatedPassword($user->email, $request->new_password, $user->username, $user->name, 'teacher');

                if (!$sent) {
                    return redirect()->back()->with('error', 'Failed to send account credentials via email.');
                }
            }

            // Redirect with success message
            return redirect()->route('admin.teacher_list')->with('success', 'Teacher updated successfully');
        }

        return redirect()->route('admin.login');
    }


    /////////////////// END /////////////////////




    /***
     * 
     * //////////////////////////////////////////////////
     * ////// Guidance account (Update, delete, view) ////
     * //////////////////////////////////////////////////
     * 
     */
    public function deleteGuidance($id)
    {
        if (Auth::guard('admin')->check()) {
            $guidance = GuidanceAccount::findOrFail($id);
            $guidance->delete();

            $_user = Auth::user();
            History::create(
                [
                    'user_id' => $_user->id,
                    'position' => $_user->role ?? 'Admin',
                    'history' => "Deleted guidance account",
                    'description' => 'ID Number: ' . $guidance->id_number . ', Name: ' . $guidance->name
                ]
            );

            return redirect()->route('admin.guidance_list')->with('success', 'Guidance deleted successfully');
        }


        return redirect()->route('admin.login');
    }

    public function editGuidance($id)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $guidance = GuidanceAccount::findOrFail($id);

            return view('admin.account_management.edit_guidance', ['user' => $user, 'guidance' => $guidance]);
        }

        return redirect()->route('admin.login');
    }

    public function updateGuidance(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $user = GuidanceAccount::findOrFail($id);

            // Validate input
            $request->validate([
                'id_number' => 'required|min:5|max:255|unique:guidance_accounts,id_number,' . $user->id,
                'name' => ['required', 'string', 'max:255', new ValidFullName],
                'new_password' => 'nullable|string|min:6|max:255',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'phone_number' => 'required|string|min:11|max:11',
                'address' => 'nullable|string|max:255',
                'extension_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:guidance_accounts,email,' . $user->id,
            ]);

            // Update user attributes
            $user->update([
                'id_number' => $request->id_number,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'extension_name' => $request->extension_name,
                'gender' => $request->gender,
            ]);

            // Handle new password if provided
            if ($request->filled('new_password')) {
                $user->password = $request->new_password;
            }

            // Handle profile photo upload with folder existence check
            if ($request->hasFile('profile')) {
                // Define the target directory in the public path
                $destinationPath = public_path('storage/profiles');
                $file = $request->file('profile');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Check if the directory exists, if not, create it
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Check if the user has an existing profile photo and delete it
                if ($user->profile && file_exists(public_path($user->profile))) {
                    unlink(public_path($user->profile));
                }

                // Move the uploaded file to the target directory
                $file->move($destinationPath, $fileName);

                // Save the file path without extra 'storage/' prefix in the database
                $user->profile = 'profiles/' . $fileName;
            }

            $user->save();

            // Log history of the update
            $_user = Auth::user();
            History::create([
                'user_id' => $_user->id,
                'position' => $_user->role ?? 'Admin',
                'history' => "Updated guidance account",
                'description' => 'ID Number: ' . $user->id_number . ', Name: ' . $user->name,
            ]);

            if (isset($request->new_password)) {
                $sent = $this->mailerService->sendUpdatedPassword($user->email, $request->new_password, $user->username, $user->name, 'guidance');

                if (!$sent) {
                    return redirect()->back()->with('error', 'Failed to send account credentials via email.');
                }
            }

            return redirect()->route('admin.guidance_list')->with('success', 'Guidance updated successfully');
        }

        return redirect()->route('admin.login');
    }

    /////////////////// END /////////////////////







    /***
     * 
     * //////////////////////////////////////////////////
     * ////// Admin account (Update, delete, view) ////
     * //////////////////////////////////////////////////
     * 
     */
    public function deleteAdmin($id)
    {
        if (Auth::guard('admin')->check()) {
            $admin = AdminAccount::findOrFail($id);
            $admin->delete();



            $user = Auth::user();
            History::create(
                [
                    'user_id' => $user->id,
                    'position' => $user->role ?? 'Admin',
                    'history' => "Deleted admin account",
                    'description' => 'ID Number: ' . $admin->id_number . ', Name: ' . $admin->name
                ]
            );

            return redirect()->route('admin.admin_list')->with('success', 'Admin deleted successfully');
        }

        return redirect()->route('admin.login');
    }

    public function editAdmin($id)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $admin = AdminAccount::findOrFail($id);

            return view('admin.account_management.edit_admin', ['user' => $user, 'admin' => $admin]);
        }

        return redirect()->route('admin.login');
    }


    public function updateAdmin(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $user = AdminAccount::findOrFail($id);

            // Validate input
            $request->validate([
                'id_number' => 'required|min:5|max:255|unique:admin_accounts,id_number,' . $user->id,
                'name' => ['required', 'string', 'max:255', new ValidFullName],
                'new_password' => 'nullable|string|min:6|max:255',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'phone_number' => 'required|string|min:11|max:11',
                'address' => 'nullable|string|max:255',
                'extension_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:admin_accounts,email,' . $user->id,
            ]);

            // Update user attributes
            $user->update([
                'id_number' => $request->id_number,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'extension_name' => $request->extension_name,
                'gender' => $request->gender,
            ]);

            // Handle new password if provided
            if ($request->filled('new_password')) {
                $user->password = $request->new_password;
            }

            // Handle profile photo upload with folder existence check
            if ($request->hasFile('profile')) {
                // Define the target directory in the public path
                $destinationPath = public_path('storage/profiles');
                $file = $request->file('profile');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Check if the directory exists, if not, create it
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Check if the user has an existing profile photo and delete it
                if ($user->profile && file_exists(public_path($user->profile))) {
                    unlink(public_path($user->profile));
                }

                // Move the uploaded file to the target directory
                $file->move($destinationPath, $fileName);

                // Save the file path without extra 'storage/' prefix in the database
                $user->profile = 'profiles/' . $fileName;
            }

            $user->save();

            // Log the update in history
            $_user = Auth::user();
            History::create([
                'user_id' => $_user->id,
                'position' => $_user->role ?? 'Admin',
                'history' => "Updated admin account",
                'description' => 'ID Number: ' . $user->id_number . ', Name: ' . $user->name,
            ]);



            $sent = $this->mailerService->sendUpdatedPassword($user->email, $request->new_password, $user->username, $user->name, 'admin');

            if (!$sent) {
                return redirect()->back()->with('error', 'Failed to send account credentials via email.');
            }

            return redirect()->route('admin.admin_list')->with('success', 'Admin updated successfully');
        }


        return redirect()->route('admin.login');
    }

    /////////////////// END /////////////////////
}
