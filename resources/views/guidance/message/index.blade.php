@extends('guidance.layouts.app')

@section('title', 'Chats')
@section('content')

<style>


.msg {
        display: flex;
        align-items: end;
        justify-content: start;
        gap: 6px;

}

.msg div {
        border-radius: 10px  10px 10px 0px;
        background-color: #ccc;
        padding: 10px;
        color: #222;
    }

    .msg_id_{{$user->id_number}} {
        display: flex;
        align-items: center;
        justify-content: end;
        gap: 0;
    }

    .msg_id_{{$user->id_number}}  img {
        display: none;
    }
    .msg_id_{{$user->id_number}} div {
        border-radius: 10px  10px 0px 10px;
        background-color: dodgerblue;
        padding: 10px;
        color: white;
    }


</style>
<div class="grid grid-cols-3 h-full max-h-screen">
    <!-- Left Column: List of Users -->
    <div class="border-r">
        <div class="p-2 relative bg-white">
            <input oninput="w3.filterHTML('#user_list', '.user', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8 border border-slate-200">
            <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 20px; transform: translateY(-50%)"></i>
        </div>
        <h2 class="text-lg font-bold p-2 pt-0 bg-white border-b text-slate-700">All users</h2>
        <div class="overflow-y-auto" id="user_list" style="height: 100vh">
            @foreach($allUsers as $_user)
            <div class="py-2 px-4 bg-white border-b shadow hover:bg-gray-200 cursor-pointer flex items-center user" onclick="loadChat({{ $_user->id }}, '{{ addslashes(get_class($_user)) }}', true)">
                <img src="{{ isset($_user->profile) ? asset('storage/' . $_user->profile) : 'https://static.vecteezy.com/system/resources/previews/019/896/008/original/male-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png' }}" alt="" class="rounded-full h-10 w-10" />
                <div class="ml-3">
                    <span class="block text-sm font-semibold">{{ $_user->name }}</span>
                    <span class="block text-xs text-gray-500">{{ $_user->role }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Center Column: Display Conversations -->

    <div class=" bg-white border-r relative" id="chat-window">
    <div class="p-2 relative bg-white">
            <input oninput="w3.filterHTML('#conversations', '.user', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8 border border-slate-200">
            <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 20px; transform: translateY(-50%)"></i>
        </div>
        <h2 class="text-lg font-bold p-2 pt-0 bg-white border-b text-slate-700">Chats</h2>
        <div id="conversations" class=" bg-slate-50 overflow-y-auto" style="height: 100vh">
            @if ($allConversations->isEmpty())
                <div class="h-full w-full flex items-center justify-center text-sm text-slate-600">
                    <span>No conversations yet.</span>
                </div>
            @else
                @foreach ($allConversations as $conversation)
                <div class="py-2 px-4 bg-white border-b hover:bg-gray-200 cursor-pointer flex items-center user" onclick="loadChat({{ $conversation->id }}, '{{ addslashes(get_class($conversation)) }}', true)">
                    <img src="{{ isset($conversation->profile) ? asset('storage/' . $conversation->profile) : 'https://static.vecteezy.com/system/resources/previews/019/896/008/original/male-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png' }}" alt="" class="rounded-full h-10 w-10" />
                    <div class="ml-3">
                        <span class="block text-sm font-semibold">{{ $conversation->name }}</span>
                        <span class="block text-xs text-gray-500">{{ $conversation->role }}</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- chats messages -->
    <div class=" bg-white p-4 relative" id="chat-window">
        <h2 class="text-lg font-bold mb-4">Conversation</h2>
        <div id="messages" class=" space-y-4 bg-slate-50 overflow-y-auto p-4 rounded-lg border border-slate-200" style="height: 100vh">
            <!-- Messages will be loaded here dynamically -->
             <div class="h-full w-full flex items-center justify-center text-sm text-slate-600">
             Select a user to start a conversation!
             </div>
        </div>
        <form action="javascript:void(0)" method="POST" class="w-full  p-2 flex items-center gap-2 bg-white border-t border-slate-200">
            @csrf
            <input name="message" id="message-input" class="form-input rounded w-full border border-slate-200 p-2" placeholder="Type a message...">
            <button onclick="sendMessage()" class="bg-blue-500 text-white rounded p-2"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>

<script>
    let selectedUserId;
    let selectedUserType;
    let onLoadMessage = false;

    function loadChat(userId, userType, scroll = false) {
        selectedUserId = userId;
        selectedUserType = userType;

        $.getJSON(`/guidance/chats/messages/?user_id=${selectedUserId}&user_type=${selectedUserType}`, function(data) {
            const messagesDiv = $('#messages');
            messagesDiv.empty();

            if (data.length > 0) {
                $.each(data, function(index, message) {
                    const profile = message.receiver_account?.profile;
                    const profileUrl = profile ? `/storage/${profile}` : 'https://static.vecteezy.com/system/resources/previews/019/896/008/original/male-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png';

                    const messageElement = $('<div>').addClass('msg msg_id_' + message.id_number).html(`
                        <img src="${profileUrl}" style="width: 30px; height: 30px; object-fit: cover;">
                        <div title="${message.time_ago}">${message.message}
                        <hr class="my-2">
                        <p style="font-size: 10px">Sent ✓ ${message.time_ago}</p>
                        </div>
                    `);
                    messagesDiv.append(messageElement);
                });
            } else {
                messagesDiv.html('<div class="h-full flex items-center justify-center"><span>No messages yet.</span></div>');
            }
            // Auto-scroll to the bottom
            if(!onLoadMessage) {
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
                onLoadMessage = true;
            }

            if(scroll) {
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            }
        });
    }

    function sendMessage() {
        const messageInput = $('#message-input');
        const message = messageInput.val();

        $.ajax({
            url: '/guidance/chats/send',
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                message: message,
                receiver_id: selectedUserId,
                receiver_type: selectedUserType.replace(/\\\\/g, '\\')
            }),
            success: function(data) {
                loadChat(selectedUserId, selectedUserType);
                $('#message-input').val(null);
                // Auto-scroll to the bottom after sending a message
                const messagesDiv = $('#messages');
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    setInterval(() => {
        if(selectedUserId && selectedUserType) {
            loadChat(selectedUserId, selectedUserType);
        }
    }, 2000);
</script>
@endsection
