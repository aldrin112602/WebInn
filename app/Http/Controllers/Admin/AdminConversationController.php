<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\{Http\Request, Support\Facades\Auth};
use App\Models\{
    Message,
    Student\StudentAccount,
    Admin\AdminAccount,
    Teacher\TeacherAccount,
    Guidance\GuidanceAccount
};

class AdminConversationController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();

        $teachers = TeacherAccount::all();
        $admins = AdminAccount::all();
        $students = StudentAccount::all();
        $guidances = GuidanceAccount::all();
        $allConversations = $this->getAllConversations();

        $allUsers = collect([...$teachers, ...$admins, ...$students, ...$guidances])
            ->filter(function ($account) use ($user) {
                return !($account->id === $user->id && get_class($account) === get_class($user));
            });
        return view(
            'admin.message.index',
            [
                'user' => $user,
                'allUsers' => $allUsers,
                'allConversations' => $allConversations
            ]
        );
    }


    public function getMessageCounts()
    {
        $allConversations = $this->getAllConversations();
        $counts = count($allConversations);
        return response()->json(['count' => $counts]);
    }


    public function getAllConversations()
    {
        $user = Auth::user();
        $userType = get_class($user);
        $userId = $user->id;

        $conversations = collect();

        $getUserInstance = function ($type, $id) {
            return app($type)::find($id);
        };

        $messages = Message::where(function ($query) use ($userId, $userType) {
            $query->where('sender_id', $userId)
                ->where('sender_type', $userType)
                ->orWhere('receiver_id', $userId)
                ->where('receiver_type', $userType);
        })->orderBy('created_at', 'desc')->get();

        foreach ($messages as $message) {
            if ($message->sender_id == $userId && $message->sender_type == $userType) {
                $otherUser = $getUserInstance($message->receiver_type, $message->receiver_id);
            } else {
                $otherUser = $getUserInstance($message->sender_type, $message->sender_id);
            }

            if ($otherUser && !$conversations->contains(function ($value) use ($otherUser) {
                return $value->id == $otherUser->id && get_class($value) == get_class($otherUser);
            })) {
                $conversations->push($otherUser);
            }
        }

        return $conversations;
    }

    public function loadMessages(Request $request)
    {
        $userId = $request->get('user_id');
        $userType = $request->get('user_type');
        $user = Auth::guard('admin')->user();

        $messages = Message::where(function ($query) use ($userId, $userType, $user) {
            $query->where('sender_id', $user->id)
                ->where('sender_type', get_class($user))
                ->where('receiver_id', $userId)
                ->where('receiver_type', $userType);
        })->orWhere(function ($query) use ($userId, $userType, $user) {
            $query->where('sender_id', $userId)
                ->where('sender_type', $userType)
                ->where('receiver_id', $user->id)
                ->where('receiver_type', get_class($user));
        })->orderBy('created_at', 'asc')->get();

        // Add human-readable time format
        $messages->each(function ($message) {
            $message->time_ago = Carbon::parse($message->created_at)->diffForHumans();
            // get user account of the receiver
            $receiverModel = $message->receiver_type;
            $senderModel = $message->sender_type;
            $message->receiver_account = $receiverModel::find($message->receiver_id);
            $message->sender_account = $senderModel::find($message->sender_id);
        });

        return response()->json($messages);
    }


    public function sendMessage(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $message = new Message();
        $message->sender_id = $user->id;
        $message->id_number = $user->id_number;
        $message->sender_type = get_class($user);
        $message->receiver_id = $request->get('receiver_id');
        $message->receiver_type = str_replace('\\\\', '\\', $request->get('receiver_type'));
        $message->message = $request->get('message');
        $message->save();

        return response()->json([
            'message' => $message,
            'time_ago' => Carbon::parse($message->created_at)->diffForHumans()
        ]);
    }
}
