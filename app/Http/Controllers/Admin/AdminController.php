<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, Auth, Storage, Session};
use Illuminate\Http\Request;
use App\Rules\ValidFullName;

use App\Models\{
    Admin\AdminAccount,
    Guidance\GuidanceAccount,
    Student\StudentAccount,
    Teacher\TeacherAccount,
    History
};
use Illuminate\Support\Facades\Http;
use App\Services\PHPMailerService;

class AdminController extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }
    
    public function history(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $allUsers = collect([...AdminAccount::all(), ...TeacherAccount::all(), ...GuidanceAccount::all(), ...StudentAccount::all()]);

            $query = History::orderBy('created_at', 'desc');

            if ($request->has('filter') && $request->filter != '') {
                $query->where('user_id', $request->filter);
            }

            $histories = $query->paginate(10);

            return view('admin.history', [
                'user' => $user,
                'allUsers' => $allUsers,
                'histories' => $histories,
                'selectedFilter' => $request->filter
            ]);
        }
        return redirect()->route('admin.login');
    }


    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->intended('admin/dashboard');
        }
        // Clear session
        Session::forget('otp_email');
        Session::forget('otp');

        return view('admin.auth.login');
    }


    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            return redirect()
                ->route('admin.login')
                ->with('success', 'Logout successfully!');
        }
    }


    public function resendOTP()
    {
        $userId = Session::get('pending_user_id');
        $user = AdminAccount::find($userId);

        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Session expired. Please login again.');
        }

        // Generate new OTP
        $otp = random_int(100000, 999999);
        $email = $user->email;

        $isSuccess = $this->mailerService->send2FA($email, $otp);

        if ($isSuccess) {
            // Update session with new OTP and expiry
            Session::put('otp', $otp);
            Session::put('otp_expiry', now()->addMinutes(10));

            return redirect()->route('admin.2fa.index')->with('success', 'New OTP has been sent to your email.');
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
    $user = Auth::guard('admin')->getProvider()->retrieveByCredentials($request->only('username'));

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
            return redirect()->route('admin.2fa.index');
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
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $teachersCount = count(TeacherAccount::all());
            $adminsCount = count(AdminAccount::all());
            $guidancesCount = count(GuidanceAccount::all());
            $studentsCount = count(StudentAccount::all());
            return view(
                'admin.dashboard',
                [
                    'user' => $user,
                    'teachersCount' => $teachersCount,
                    'adminsCount' => $adminsCount,
                    'guidancesCount' => $guidancesCount,
                    'studentsCount' => $studentsCount
                ]
            );
        }

        return redirect()->route('admin.login');
    }





    public function profile()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            return view('admin.profile.profile', ['user' => $user]);
        }

        return redirect()->route('admin.login');
    }



    public function updateAccount(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            // Validate the input
            $request->validate([
                'id_number' => 'required|min:5|max:255|unique:admin_accounts,id_number,' . $user->id,
                'name' => ['required', 'string', 'max:255', new ValidFullName],
                'email' => 'required|email|max:255|unique:admin_accounts,email,' . $user->id,
                'gender' => 'required|string|in:Male,Female',
                'address' => 'required|string|max:255',
                'extension_name' => 'nullable|string|max:255',
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
            Auth::guard('admin')->login($user);

            $auth_user = Auth::user();
            History::create(
                [
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Update his/her account information",
                    'description' => 'ID Number: ' . $auth_user->id_number . ', Name: ' . $auth_user->name
                ]
            );

            return redirect()
                ->back()
                ->with('success', 'Profile updated successfully!');
        }

        return redirect()->route('admin.login');
    }



    public function updatePassword(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
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
            Auth::guard('admin')->login($user);

            $auth_user = Auth::user();
            History::create(
                [
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Update his/her password",
                    'description' => 'ID Number: ' . $auth_user->id_number . ', Name: ' . $auth_user->name
                ]
            );

            return redirect()->back()->with('success', 'Password updated successfully!');
        }

        return redirect()->route('admin.login');
    }


    public function updateProfilePhoto(Request $request)
{
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();

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


            $auth_user = Auth::user();
            History::create(
                [
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Update his/her profile photo",
                    'description' => 'ID Number: ' . $auth_user->id_number . ', Name: ' . $auth_user->name
                ]
            );

            return redirect()->back()->with('success', 'Profile photo updated successfully!');
        }
    }

    return redirect()->back()->withErrors(['error' => 'Failed to update profile photo.']);
}



    public function deleteProfilePhoto()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }
            $user->profile = null;
            $user->save();

            $auth_user = Auth::user();
            History::create(
                [
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Deleted his/her profile photo",
                    'description' => 'ID Number: ' . $auth_user->id_number . ', Name: ' . $auth_user->name
                ]
            );

            return redirect()->back()->with('success', 'Profile photo deleted successfully!');
        }

        return redirect()->back()->withErrors(['error' => 'Failed to delete profile photo. Please try again.']);
    }
}
