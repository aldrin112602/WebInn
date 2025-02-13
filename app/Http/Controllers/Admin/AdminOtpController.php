<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PHPMailerService;
use App\Models\Admin\{AdminOtpAccount, AdminAccount};
use Illuminate\{Http\Request, Support\Facades\Session};
use App\Models\History;

use Carbon\Carbon;

class AdminOtpController extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = AdminAccount::where('email', $request->email)->first();
        if ($user) {
            $otp = $this->getRandomNumbers();
            $expiresAt = Carbon::now()->addMinutes(10);

            $sent = $this->mailerService->sendOtp($request->email, $otp);

            if ($sent) {
                AdminOtpAccount::create([
                    'email' => $request->email,
                    'otp' => $otp,
                    'expires_at' => $expiresAt,
                ]);

                // Store email in session
                Session::put('otp_email', $request->email);
                Session::put('otp', $otp);

                return redirect()->route('admin.verify-form.otp')->with('success', 'OTP sent successfully!');
            }

            return back()->withErrors(['email' => 'Failed to send OTP, please try again']);
        } else {
            return back()->withErrors(['email' => 'User not found, please try again']);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        // Retrieve email from session
        $email = Session::get('otp_email');
        if (!$email) {
            return back()->withErrors(['otp' => 'Email not found in session']);
        }


        $otpEntry = AdminOtpAccount::where('email', $email)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpEntry) {
            return back()->withErrors(['otp' => 'The OTP has been expired']);
        }

        if (!AdminOtpAccount::where('email', $email)->where('otp', $request->otp)->first()) {
            return back()->withErrors(['otp' => 'Invalid OTP, please try again']);
        }

        return redirect()->route('admin.password.reset')
            ->with('success', 'OTP verified successfully!');
    }

    public function request()
    {
        // Clear session
        Session::forget('otp_email');
        Session::forget('otp');

        return view('admin.auth.email');
    }

    public function verifyFormOtp()
    {
        $email = Session::get('otp_email');
        if (!$email) {
            return back()->withErrors(['otp' => 'Email not found in session']);
        }

        return view('admin.auth.verify-otp');
    }

    public function reset()
    {
        return view('admin.auth.reset');
    }

    public function update(Request $request)
    {
        $email = Session::get('otp_email');
        if (!$email) {
            return back()->withErrors(['error' => 'Email not found in session']);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        $user = AdminAccount::where('email', $email)->first();
        if ($user) {
            $user->password = $request->password;
            $user->save();

            // Delete OTP entry
            AdminOtpAccount::where('email', $email)->delete();

            // Clear session
            Session::forget('otp_email');
            Session::forget('otp');

            History::create(
                [
                    'user_id' => $user->id,
                    'position' => $user->role,
                    'history' => "Reset his/her password",
                    'description' => 'ID Number: ' . $user->id_number . ', Name: ' . $user->name
                ]
            );

            return redirect()->route('admin.login')
                ->with('success', 'Password reset successfully!');
        } else {
            return back()->withErrors(['error' => 'Email not found in session']);
        }
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
