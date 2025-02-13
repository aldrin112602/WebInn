<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\PHPMailerService;
use Carbon\Carbon;
use App\Models\Student\{StudentOtpAccount, StudentAccount};
use Illuminate\{Http\Request, Support\Facades\Session};


class StudentOtpController extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = StudentAccount::where('email', $request->email)->first();
        if ($user) {
            $otp = $this->getRandomNumbers();
            $expiresAt = Carbon::now()->addMinutes(10);

            $sent = $this->mailerService->sendOtp($request->email, $otp);

            if ($sent) {
                StudentOtpAccount::create([
                    'email' => $request->email,
                    'otp' => $otp,
                    'expires_at' => $expiresAt,
                ]);

                // Store email in session
                Session::put('otp_email', $request->email);
                Session::put('otp', $otp);

                return redirect()->route('student.verify-form.otp')->with('success', 'OTP sent successfully!');
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


        $otpEntry = StudentOtpAccount::where('email', $email)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpEntry) {
            return back()->withErrors(['otp' => 'The OTP has been expired']);
        }

        if (!StudentOtpAccount::where('email', $email)->where('otp', $request->otp)->first()) {
            return back()->withErrors(['otp' => 'Invalid OTP, please try again']);
        }

        return redirect()->route('student.password.reset')
            ->with('success', 'OTP verified successfully!');
    }

    public function request()
    {
        // Clear session
        Session::forget('otp_email');
        Session::forget('otp');

        return view('student.auth.email');
    }

    public function verifyFormOtp()
    {
        $email = Session::get('otp_email');
        if (!$email) {
            return back()->withErrors(['otp' => 'Email not found in session']);
        }

        return view('student.auth.verify-otp');
    }

    public function reset()
    {
        return view('student.auth.reset');
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

        $user = StudentAccount::where('email', $email)->first();
        if ($user) {
            $user->password = $request->password;
            $user->save();

            // Delete OTP entry
            StudentOtpAccount::where('email', $email)->delete();

            // Clear session
            Session::forget('otp_email');
            Session::forget('otp');

            return redirect()->route('student.login')
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
