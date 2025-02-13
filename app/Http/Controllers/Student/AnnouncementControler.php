<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use App\Models\SeenAnnouncement;

class AnnouncementControler extends Controller
{
    public function announcements()
    {
        $announcements = Announcement::with('teacher')->latest()->get();
        $user = Auth::user();
        return view('student.announcement', compact('announcements', 'user'));
    }


    public function getUnseenAnnouncements()
    {
        $userId = Auth::id();

        // Get all announcements that the student has not seen
        $unseenAnnouncements = Announcement::whereDoesntHave('seenAnnouncements', function ($query) use ($userId) {
            $query->where('student_id', $userId)
                ->where('is_seen', true);
        })->with('teacher')->latest()->get();

        return response()->json($unseenAnnouncements);
    }
}
