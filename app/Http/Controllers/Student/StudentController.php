<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student\StudentAccount;
use App\Models\Teacher\TeacherAccount;
use Illuminate\Http\Request;
use App\Rules\ValidFullName;
use Illuminate\Support\Facades\{Hash, Auth, Storage, Session};
use Illuminate\Support\Facades\Http;
use App\Services\PHPMailerService;


class StudentController extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function attendanceHistory()
    {
        $user = Auth::user();
        $attendace_histories = $user->attendaceHistories()->paginate(10);
        return view('student.attendance_history', [
            'user' => $user,
            'attendace_histories' => $attendace_histories,
        ]);
    }

    public function enrolledSubjects()
    {
        $user = Auth::user();
        if (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();
            $enrolled_subjects = $user->subjects()->paginate(8);

            return view('student.enrolled_subjects', [
                'user' => $user,
                'enrolled_subjects' => $enrolled_subjects,
                'TeacherModel' => TeacherAccount::class
            ]);
        }



        return redirect()->route('student.login');
    }

    public function login()
    {
        if (Auth::guard('student')->check()) {
            return redirect()->intended('student/dashboard');
        }
        // Clear session
        Session::forget('otp_email');
        Session::forget('otp');

        return view('student.auth.login');
    }


    public function logout()
    {
        if (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
            return redirect()
                ->route('student.login')
                ->with('success', 'Logout successfully!');
        }
    }



    public function resendOTP()
    {
        $userId = Session::get('pending_user_id');
        $user = StudentAccount::find($userId);

        if (!$user) {
            return redirect()->route('student.login')->with('error', 'Session expired. Please login again.');
        }

        // Generate new OTP
        $otp = random_int(100000, 999999);
        $email = $user->email;

        $isSuccess = $this->mailerService->send2FA($email, $otp);

        if ($isSuccess) {
            // Update session with new OTP and expiry
            Session::put('otp', $otp);
            Session::put('otp_expiry', now()->addMinutes(10));

            return redirect()->route('student.2fa.index')->with('success', 'New OTP has been sent to your email.');
        }

        return redirect()->back()->with('error', 'Failed to send new OTP. Please try again.');
    }

    
public function handleLogin(Request $request)
{
    // Validate the input
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // Retrieve the user by username
    $user = Auth::guard('student')->getProvider()->retrieveByCredentials($request->only('username'));

    // Check if the user exists and if the password is correct
    if ($user && Hash::check($request->password, $user->password)) {
        // Generate OTP
        $otp = random_int(100000, 999999);
        $email = $user->email;

        $isSuccess = $this->mailerService->send2FA($email, $otp);

        if ($isSuccess) {
            // Store user and OTP data in session
            Session::put('otp', $otp);
            Session::put('otp_expiry', now()->addMinutes(10));
            Session::put('pending_user_id', $user->id);

            // Redirect to OTP verification page
            return redirect()->route('student.2fa.index');
        }

        // Handle case if OTP sending fails
        return redirect()->back()->with(
            'error',
            'Failed to send OTP. Please try again.',
        );
    }

    // Authentication failed
    return redirect()->back()->withErrors([
        'password' => 'Invalid username or password.',
    ])->withInput($request->except('password'));
}


    public function dashboard()
    {
        if (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();
            $enrolled_subjects = $user->subjects()->paginate(6);
            $subjects_today = $user->subjects()->where('day', date('l'))->get();

            return view('student.dashboard', [
                'user' => $user,
                'enrolled_subjects' => $enrolled_subjects,
                'subjects_today' => $subjects_today,
                'TeacherModel' => TeacherAccount::class
            ]);
        }

        return redirect()->route('student.login');
    }


    public function profile()
    {
        if (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();
            return view('student.profile.profile', ['user' => $user]);
        }

        return redirect()->route('student.login');
    }



    public function updateAccount(Request $request)
    {
        if (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();

            // Validate the input
            $request->validate([
                'id_number' => 'required|min:5|max:255|unique:admin_accounts,id_number,' . $user->id,
                'name' => ['required', 'string', 'max:255', new ValidFullName],
                'email' => 'required|email|max:255|unique:admin_accounts,email,' . $user->id,
                'gender' => 'required|string|in:Male,Female',
                'address' => 'required|string|max:255',
                'extension_name' => 'required|string|max:255',
                'phone_number' => 'required|string|min:11|max:11',
            ]);


            $user->update([
                'name' => $request->name,
                'id_number' => $request->id_number,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'extension_name' => $request->extension_name,
                'gender' => $request->gender,
            ]);

            // Re-authenticate the user with the new password
            Auth::guard('student')->login($user);

            return redirect()
                ->back()
                ->with('success', 'Profile updated successfully!');
        }

        return redirect()->route('student.login');
    }



    public function updatePassword(Request $request)
    {
        if (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();
            // Validate the input
            $request->validate([
                'password' => 'required|string',
                'new_password' => 'required|string|min:6|max:255',
            ]);
            // Check if the current password matches
            if (!Hash::check($request->password, $user->password)) {
                return redirect()
                    ->back()
                    ->withErrors(['password' => 'The current password is incorrect.'])
                    ->withInput();
            }

            // Update the password
            $user->password = $request->new_password;
            $user->save();

            // Re-authenticate the user with the new password
            Auth::guard('student')->login($user);
            return redirect()->back()->with('success', 'Password updated successfully!');
        }

        return redirect()->route('student.login');
    }





    public function updateProfilePhoto(Request $request)
    {
        if (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();



            $request->validate([
                'profile_photo' => 'required|image|max:2048',
            ]);
    
            if ($request->hasFile('profile_photo')) {
                // Define the target directory in the public path
                $destinationPath = public_path('storage/profiles');
                $file = $request->file('profile_photo');
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
                $user->save();
    
                return redirect()->back()->with('success', 'Profile photo updated successfully!');
            }

            
        }

        return redirect()->back()->withErrors(['error' => 'Failed to update profile photo.']);
    }


    public function deleteProfilePhoto()
    {
        if (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();

            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }
            $user->profile = null;
            $user->save();

            return redirect()->back()->with('success', 'Profile photo deleted successfully!');
        }

        return redirect()->back()->withErrors(['error' => 'Failed to delete profile photo. Please try again.']);
    }
}
