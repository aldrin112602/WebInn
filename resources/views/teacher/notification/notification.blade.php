@extends('teacher.layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="text-slate-100 p-2 bg-blue-400 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <i class="fas fa-bell"></i>
            Notifications
        </div>

        <!-- Mark All as Read Button -->
        <form action="{{ route('teacher.notifications.markAllAsRead') }}" method="POST">
            @csrf
            <button @if ($notifications->isEmpty()) disabled @endif type="submit"
                class="bg-gray-900 hover:bg-gray-700 text-white py-1 px-4 rounded">
                Mark All as Read
            </button>
        </form>
    </div>

    <div class="p-4">
        @if ($notifications->isEmpty())
            <p class="text-gray-500">No notifications available.</p>
        @else
            <!-- Form to delete selected notifications -->
            <form id="delete-selected-form" action="{{ route('teacher.deleteSelected.notifications') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end mb-4">
                    <button type="button" id="delete-selected-btn"
                        class="bg-red-500 hover:bg-red-700 text-white py-1 px-4 rounded">
                        Delete Selected
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach ($notifications as $notification)
                        <div
                            class="p-4 {{ $notification->is_seen ? 'bg-white' : 'bg-blue-100' }} rounded shadow-md flex items-start justify-between">
                            <div class="flex items-start gap-3">
                                <!-- Checkbox for deleting selected notifications -->
                                <input type="checkbox" name="selected_notifications[]" value="{{ $notification->id }}"
                                    class="mt-1 notification-checkbox">

                                <!-- Notification Icon -->
                                @if ($notification->icon)
                                    <i class="fas fa-{{ $notification->icon }} text-xl"></i>
                                @else
                                    <i class="fas fa-info-circle text-xl"></i>
                                @endif

                                <!-- Notification Content -->
                                <div>
                                    <h3 class="font-semibold text-lg">{{ $notification->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <!-- Optional URL for the notification -->
                            @if ($notification->url)
                                {{-- <a href="{{ $notification->url }}" class="text-blue-500 hover:text-blue-700">View</a> --}}
                            @endif

                            <!-- Delete Button for individual notification -->
                            <form id="delete_form_{{ $notification->id }}"
                                action="{{ route('teacher.notifications.delete', $notification->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteNotif({{ $notification->id }})"
                                    class="delete-notification-btn bg-red-500 hover:bg-red-700 text-white py-1 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </form>
        @endif
    </div>


    <script>
        const deleteNotif = (id) => {
            if (!id) return;

            let form = $(`#delete_form_${id}`);

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    // console.log(form)
                }
            });
        }


        $(document).ready(function() {

            // SweetAlert for deleting selected notifications
            $('#delete-selected-btn').on('click', function(event) {
                event.preventDefault();

                // Check if any checkboxes are selected
                let selectedCheckboxes = $('.notification-checkbox:checked');

                if (selectedCheckboxes.length === 0) {
                    Swal.fire({
                        title: 'No notifications selected',
                        text: 'Please select at least one notification to delete.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Selected notifications will be deleted!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete them!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#delete-selected-form').submit();
                            // console.log($('#delete-selected-form'))
                        }
                    });
                }
            });
        });
    </script>
@endsection
