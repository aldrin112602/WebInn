<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student\StudentNotification;

class StudentNotificationController extends Controller
{
    public function index()
    {
        $user = Auth::guard('student')->user();
        return view('student.notification.notification', [
            'user' => $user,
            'notifications' => StudentNotification::where('user_id', $user->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function createNotification(Request $request)
    {
        $userId = Auth::id();

        $validatedData = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'url' => 'nullable|url',
            'icon' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        StudentNotification::create([
            'type' => $validatedData['type'],
            'user_id' => $userId,
            'title' => $validatedData['title'],
            'message' => $validatedData['message'],
            'url' => $validatedData['url'] ?? null,
            'icon' => $validatedData['icon'] ?? null,
            'priority' => $validatedData['priority'] ?? 'low',
        ]);

        return response()->json(['message' => 'Notification created successfully.']);
    }

    public function markAsSeen($notificationId)
    {
        $notification = StudentNotification::findOrFail($notificationId);
        $notification->markAsSeen();
        return response()->json(['message' => 'Notification marked as seen.']);
    }

    public function getUnseenNotifications()
    {
        $userId = Auth::id();
        $notifications = StudentNotification::where('user_id', $userId)
            ->unseen()
            ->get();
        return response()->json($notifications);
    }

    public function getHighPriorityNotifications(Request $request)
    {
        $userId = Auth::id();
        $notifications = StudentNotification::where('user_id', $userId)
            ->where('priority', $request->priority)
            ->get();

        return response()->json($notifications);
    }

    public function markAllAsRead()
    {
        $user = Auth::guard('student')->user();
        StudentNotification::where('user_id', $user->id)
            ->update(['is_seen' => true]);

        return redirect()->route('student.notification')
            ->with('success', 'All notifications marked as read.');
    }

    // Delete individual notification
    public function delete($id)
    {
        $notification = StudentNotification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }

    // Delete selected notifications
    public function deleteSelected(Request $request)
    {
        $selectedNotifications = $request->input('selected_notifications', []);
        if (!empty($selectedNotifications)) {
            StudentNotification::whereIn('id', $selectedNotifications)->delete();

            return redirect()->back()->with('success', 'Selected notifications deleted successfully.');
        }

        return redirect()->back()->with('error', 'No notifications selected for deletion.');
    }
}
