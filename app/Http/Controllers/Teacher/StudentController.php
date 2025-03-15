<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\ValidFullName;
use Illuminate\Support\Facades\{Auth, Storage};
use App\Models\{TeacherGradeHandle, Student\StudentAccount, StudentImage, History};
use App\Services\PHPMailerService;

class StudentController extends Controller
{

    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }
    // return the list of all students
    public function index(Request $request)
    {
        $user = Auth::user();
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        $id = $request->query('id');
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




        return view('teacher.students.index', [
            'user' => $user,
            'id' => $id,
            'handleSubjects' => $handleSubjects,
            'account_list' => $account_list,
            'grade_handle' => $grade_handle
        ]);
    }



    public function editStudent($id)
    {
        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();
            $student = StudentAccount::findOrFail($id);
            $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();

            return view('teacher.students.edit_student', ['user' => $user, 'student' => $student, 'handleSubjects' => $handleSubjects]);
        }

        return redirect()->route('teacher.login');
    }


    public function updateStudent(Request $request, $id)
    {
        if (Auth::guard('teacher')->check()) {
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
                'lrn' => $request->lrn,
                'birthdate' => $request->birthdate,
                'parents_contact_number' => $request->parents_contact_number,
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
                'description' => 'ID Number: ' . $user->id_number . ', Name: ' . $user->name
            ]);


            if (isset($request->new_password)) {
                $sent = $this->mailerService->sendUpdatedPassword($user->email, $request->new_password, $user->username, $user->name, 'student');

                if (!$sent) {
                    return redirect()->back()->with('error', 'Failed to send account credentials via email.');
                }
            }

            // Redirect with success message
            $id = request()->query('id');
            return redirect()->route('teacher.student_list', ['id' => $id])->with('success', 'Student updated successfully');
        }

        return redirect()->route('teacher.login');
    }


    public function deleteStudent($id)
    {
        if (Auth::guard('teacher')->check()) {
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



            $user = Auth::user();
            History::create(
                [
                    'user_id' => $user->id,
                    'position' => $user->role ?? 'Teacher',
                    'history' => "Deleted student account",
                    'description' => 'ID Number: ' . $student->id_number . ', Name: ' . $student->name
                ]
            );

            $student->delete();

            return redirect()->back()->with('success', 'Student deleted successfully');
        }

        return redirect()->route('teacher.login');
    }



    /////////////////// END /////////////////////
}
