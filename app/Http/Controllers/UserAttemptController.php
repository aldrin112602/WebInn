<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAttempt;

class UserAttemptController extends Controller
{
    function handleAttempt(Request $request) {
        $record = UserAttempt::where('user_agent', $request->userAgent)->first();
    
        if (!$record) {
            $record = UserAttempt::create([
                'user_agent' => $request->userAgent,
                'attempts' => 1,
                'last_attempt_at' => now()
            ]);
            return response()->json(['restricted' => false]);
        }
    
        if ($record->is_restricted) {
            return response()->json(['restricted' => true, 'reason' => 'Manually restricted by admin']);
        }
    
        if ($record->attempts >= 5) {
            return response()->json(['restricted' => true, 'reason' => 'Max attempts reached']);
        }
    
        $record->increment('attempts');
        $record->last_attempt_at = now();
        $record->save();
    
        return response()->json(['restricted' => false]);
    }

    function getAttempts(Request $request) {
        $record = UserAttempt::where('user_agent', $request->userAgent)->first();
    
        if (!$record) {
            $record = UserAttempt::create([
                'user_agent' => $request->userAgent,
                'attempts' => 1,
                'last_attempt_at' => now()
            ]);
            return response()->json(['restricted' => false]);
        }
    
        if ($record->is_restricted) {
            return response()->json(['restricted' => true, 'reason' => 'Manually restricted by admin']);
        }
    
        if ($record->attempts >= 5) {
            return response()->json(['restricted' => true, 'reason' => 'Max attempts reached']);
        }
    
        return response()->json(['restricted' => false]);
    }
    
}
