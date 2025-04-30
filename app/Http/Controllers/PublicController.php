<?php

namespace App\Http\Controllers;

use Illuminate\{Http\Request, Support\Carbon};
use App\Models\{Admin\AdminAccount, FaceScan};
use App\Rules\ValidFullName;
use App\Notifications\TimeInOutNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Student\StudentAccount;

class PublicController extends Controller
{
    public function faceScanAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student_accounts,id',
            'is_time_in' => 'required|string',
        ]);


        $student = StudentAccount::find($request->student_id)->first();
        $parents_email = $student->parents_email;

        // send notif to parents for time in and time out with time and date then if time in or time out

        $today = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');

        // Check if attendance record exists for today
        $attendance = FaceScan::where('student_id', $request->student_id)
            ->whereDate('created_at', $today)
            ->first();

        if ($request->is_time_in === 'true') {
            // Handle time-in
            if ($attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Time-in already recorded for today',
                ]);
            }

            FaceScan::create([
                'student_id' => $request->student_id,
                'time' => $currentTime,
                'is_time_in' => true,
            ]);
            
            Notification::route('mail', $parents_email)->notify(
                new TimeInOutNotification(
                    $student->name,
                    'Time-In',
                    $currentTime,
                    $today->toFormattedDateString()
                )
            );
            

            return response()->json([
                'success' => true,
                'message' => 'Time-in recorded successfully',
                'student_id' => $request->student_id,
            ]);
        } else {
            // Handle time-out
            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Time-in record not found for today',
                ]);
            }

            if ($attendance->time_out) {
                return response()->json([
                    'success' => false,
                    'message' => 'Time-out already recorded for today',
                ]);
            }

            // Update the time-out for the existing record
            $attendance->update(['time_out' => $currentTime]);


            Notification::route('mail', $parents_email)->notify(
                new TimeInOutNotification(
                    $student->name,
                    'Time-Out',
                    $currentTime,
                    $today->toFormattedDateString()
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Time-out recorded successfully',
                'student_id' => $request->student_id,
            ]);
        }
    }





    public function faceRecognition()
    {
        return view('face-recognition');
    }





    // for testing dev only

    public function login()
    {
        return redirect()->intended('/');
    }


    public function createAdmin(Request $request)
    {
        $request->validate([
            'id_number' => 'required|min:5|max:255|unique:admin_accounts,id_number',
            'name' => ['required', 'string', 'max:255', new ValidFullName],
            'gender' => 'required|string|in:Male,Female',
            'username' => 'required|string|unique:admin_accounts,username',
            'password' => 'required|string|min:6|max:255',
            'email' => 'nullable|email|unique:admin_accounts,email',
            'position' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif',
            'phone_number' => 'nullable|string|min:11|max:11'
        ]);

        $account = new AdminAccount($request->all());

        $profilePath = $request->file('profile')->store('profiles', 'public');
        $account->profile = $profilePath;

        $account->save();

        return redirect()
            ->back()
            ->with('success', 'Account added successfully!');
    }
}
