<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\{Support\Facades\Auth, Http\Request};
use App\Rules\ValidFullName;
use App\Models\{
    Admin\AdminAccount,
    Guidance\GuidanceAccount,
    Student\StudentAccount,
    Teacher\TeacherAccount,
    StudentImage,
    History,
    StudentHandle,
    TeacherGradeHandle
};

use App\Notifications\AccountCreatedNotification;

class AdminCreateController extends Controller
{


    public function createAdmin(Request $request)
    {
        $request->validate([
            'id_number' => 'required|min:5|max:255|unique:admin_accounts,id_number',
            'name' => ['required', 'string', 'max:255', new ValidFullName],
            'gender' => 'required|string|in:Male,Female',
            'username' => 'required|string|unique:admin_accounts,username',
            'password' => 'required|string|min:6|max:255',
            'email' => 'required|email|unique:admin_accounts,email',
            'position' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|string|min:11|max:11'
        ]);

        // Create a new admin account with request data (excluding 'profile')
        $account = new AdminAccount($request->except('profile'));

        // Handle profile photo upload
        if ($request->hasFile('profile')) {
            $destinationPath = public_path('storage/profiles');
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Check if the directory exists, if not, create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded file to the target directory
            $file->move($destinationPath, $fileName);

            // Save the file path without the 'storage/' prefix in the database
            $account->profile = 'profiles/' . $fileName;
        }

        try {
            $account->notify(
                new AccountCreatedNotification($request->password, 'admin', $account->username)
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Failed to send notification: " . $e->getMessage());
        }


        // Save the new admin account to the database
        $account->save();


        // Record history
        $auth_user = Auth::user();
        History::create([
            'user_id' => $auth_user->id,
            'position' => $auth_user->role,
            'history' => "Create admin account",
            'description' => 'ID Number: ' . $account->id_number . ', Name: ' . $account->name,
        ]);

        return redirect()->back()->with('success', 'Account added successfully!');
    }

    public function createStudent(Request $request)
    {
        $request->validate([
            'id_number' => 'required|min:5|max:255|unique:student_accounts,id_number',
            'name' => ['required', 'string', 'max:255', new ValidFullName],
            'gender' => 'required|string|in:Male,Female',
            'username' => 'required|string|unique:student_accounts,username',
            'password' => 'required|string|min:6|max:255',
            'strand' => 'required',
            'add_to' => 'required',
            'grade' => 'required',
            'parents_email' => 'required',
            'lrn' => 'required|min:12|max:12',
            'birthdate' => 'required',
            'parents_contact_number' => 'required|string|min:11|max:11',
            'email' => 'required|email|unique:student_accounts,email',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|string|min:11|max:11',
            'face_images' => 'required|array|min:3|max:3',
            'face_images.*' => 'required|image|max:10240',
        ]);

        // Create a new student account with request data (excluding 'profile' and 'face_images')
        $account = new StudentAccount($request->except('profile', 'face_images'));
        $grade_handle = TeacherGradeHandle::where('id', $request->add_to)->first();
        $account->section = $grade_handle->section;

        // Handle profile photo upload
        if ($request->hasFile('profile')) {
            $destinationPath = public_path('storage/profiles');
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Check if the directory exists, if not, create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded file to the target directory
            $file->move($destinationPath, $fileName);

            // Save the file path without the 'storage/' prefix in the database
            $account->profile = 'profiles/' . $fileName;
        }



        // Save the student account to the database
        $account->save();

        // Create student handle if grade handle exists
        if ($grade_handle) {
            StudentHandle::create([
                'student_id' => $account->id,
                'teacher_id' => $grade_handle->teacher->id,
                'grade_handle_id' => $request->add_to,
            ]);
        }

        // Handle face images upload
        $faceImagesDirectory = public_path('storage/face_images/' . $account->name);
        if (!file_exists($faceImagesDirectory)) {
            mkdir($faceImagesDirectory, 0777, true);
        }

        if ($request->hasFile('face_images')) {
            foreach ($request->file('face_images') as $index => $file) {
                $fileName = "$index.jpg";
                $file->move($faceImagesDirectory, $fileName);

                StudentImage::create([
                    'student_id' => $account->id,
                    'image_path' => 'face_images/' . $account->name . '/' . $fileName,
                ]);
            }
        }

        // Record history
        $auth_user = Auth::user();
        History::create([
            'user_id' => $auth_user->id,
            'position' => $auth_user->role,
            'history' => "Create student account",
            'description' => 'ID Number: ' . $account->id_number . ', Name: ' . $account->name,
        ]);


        try {
            $account->notify(
                new AccountCreatedNotification($request->password, 'student', $account->username)
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Failed to send notification: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Account added successfully!');
    }


    public function createTeacher(Request $request)
    {
        $request->validate([
            'id_number' => 'required|min:5|max:255|unique:teacher_accounts,id_number',
            'name' => ['required', 'string', 'max:255', new ValidFullName],
            'gender' => 'required|string|in:Male,Female',
            'position' => 'required|string|max:255',
            'username' => 'required|string|unique:teacher_accounts,username',
            'password' => 'required|string|min:6|max:255',
            'email' => 'required|email|unique:teacher_accounts,email',
            'role' => 'nullable|string|max:255',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|string|min:11|max:11'
        ]);

        // Create a new teacher account with request data (excluding 'profile')
        $account = new TeacherAccount($request->except('profile'));

        // Handle profile photo upload
        if ($request->hasFile('profile')) {
            $destinationPath = public_path('storage/profiles');
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Check if the directory exists, if not, create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded file to the target directory
            $file->move($destinationPath, $fileName);

            // Save the file path without the 'storage/' prefix in the database
            $account->profile = 'profiles/' . $fileName;
        }

        // Save the teacher account to the database
        $account->save();

        // Record history
        $auth_user = Auth::user();
        History::create([
            'user_id' => $auth_user->id,
            'position' => $auth_user->role,
            'history' => "Create teacher account",
            'description' => 'ID Number: ' . $account->id_number . ', Name: ' . $account->name,
        ]);

        try {
            $account->notify(
                new AccountCreatedNotification($request->password, 'teacher', $account->username)
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Failed to send notification: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Account added successfully!');
    }

    public function createGuidance(Request $request)
    {
        $request->validate([
            'id_number' => 'required|min:5|max:255|unique:guidance_accounts,id_number',
            'name' => ['required', 'string', 'max:255', new ValidFullName],
            'gender' => 'required|string|in:Male,Female',
            'username' => 'required|string|unique:guidance_accounts,username',
            'password' => 'required|string|min:6|max:255',
            'email' => 'required|email|unique:guidance_accounts,email',
            'role' => 'nullable|string|max:255',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|string|min:11|max:11'
        ]);

        // Create a new guidance account with request data (excluding 'profile')
        $account = new GuidanceAccount($request->except('profile'));

        // Handle profile photo upload
        if ($request->hasFile('profile')) {
            $destinationPath = public_path('storage/profiles');
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Check if the directory exists, if not, create it
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded file to the target directory
            $file->move($destinationPath, $fileName);

            // Save the file path without the 'storage/' prefix in the database
            $account->profile = 'profiles/' . $fileName;
        }

        // Save the guidance account to the database
        $account->save();

        // Record history
        $auth_user = Auth::user();
        History::create([
            'user_id' => $auth_user->id,
            'position' => $auth_user->role,
            'history' => "Create guidance account",
            'description' => 'ID Number: ' . $account->id_number . ', Name: ' . $account->name,
        ]);


        try {
            $account->notify(
                new AccountCreatedNotification($request->password, 'guidance', $account->username)
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Failed to send notification: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Account added successfully!');
    }




    // View creates
    public function viewCreateAdmin()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $id_number = $this->getRandomNumbers();
            return view('admin.create.admin', ['user' => $user, 'id_number' => $id_number]);
        }


        return redirect()->route('admin.login');
    }

    public function viewCreateStudent()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $id_number = $this->getRandomNumbers();
            $grade_handles = TeacherGradeHandle::orderBy('grade', 'asc')->orderBy('section', 'asc')->orderBy('strand', 'asc')->get();
            return view('admin.create.student', ['user' => $user, 'id_number' => $id_number, 'grade_handles' => $grade_handles]);
        }

        return redirect()->route('admin.login');
    }

    public function viewCreateTeacher()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $id_number = $this->getRandomNumbers();
            return view('admin.create.teacher', ['user' => $user, 'id_number' => $id_number]);
        }

        return redirect()->route('admin.login');
    }

    public function viewCreateGuidance()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $id_number = $this->getRandomNumbers();
            return view('admin.create.guidance', ['user' => $user, 'id_number' => $id_number]);
        }

        return redirect()->route('admin.login');
    }

    public function getRandomNumbers($count = 1)
    {
        $randomNumbers = [];
        for ($i = 0; $i < $count; $i++) {
            $randomNumbers[] = rand(1000000000, 9999999999);
        }
        return $randomNumbers[0];
    }
}
