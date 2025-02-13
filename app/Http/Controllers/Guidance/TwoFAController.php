<?php

namespace App\Http\Controllers\Guidance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwoFAController extends Controller
{
    
    public function index(Request $request)
    {
        return view('guidance.auth.2FA-verification');
    }

   
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $otp = Session::get('otp');
        $otpExpiry = Session::get('otp_expiry');
        $pendingUserId = Session::get('pending_user_id');

        if ($otp !== (int)$request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP, please try again.']);
        } elseif (now()->greaterThan($otpExpiry)) {
            return back()->withErrors(['otp' => 'The OTP has expired. Please request a new one.']);
        }

        Session::forget(['otp', 'otp_expiry', 'pending_user_id']);
        Auth::guard('guidance')->loginUsingId($pendingUserId);

        return redirect()->intended('guidance/dashboard')->with('success', 'Login successful!');
    }
}
