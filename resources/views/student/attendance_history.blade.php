@extends('student.layouts.app')

@section('title', 'Attendance History')

@section('content')
<style>
    @media print {
        #tablePreview {
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            z-index: 100;
            width: 100vw;
            height: 100vh;
        }

    }
</style>

<div class="px-6 py-4">
    <!-- Search and Actions -->
    <div class="flex justify-between items-center mb-4">
        <input type="text" placeholder="Search..." class="p-2 border border-gray-300 rounded">
        <div>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2" onclick="window.print()">Print</button>
            <a href="{{ route('student.download_attendance_history', $user->id) }}" class="bg-gray-800 text-white px-4 py-2 rounded">Export</a>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="overflow-x-auto" id="tablePreview">
        @if ($attendace_histories->isEmpty())
        <div class="text-center p-10 bg-white">
            <p>
                No history found, nothing to display at the moment.
            </p>
        </div>
        @else
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Day</th>
                    <th class="py-3 px-6 text-left">Subject</th>
                    <th class="py-3 px-6 text-left">Teacher</th>
                    <th class="py-3 px-6 text-left">Time in</th>
                    <th class="py-3 px-6 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">

                @foreach ($attendace_histories as $history)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $history->date }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $history->subject->day }}
                    </td>
                    <td class="py-3 px-6 text-left flex items-center gap-2">
                        <i class="fa-regular fa-note-sticky"></i>
                        {{ $history->subject->subject }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $history->teacher->name }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $history->subject->time }}
                    </td>
                    <td class="py-3 px-6 text-left">{{ $history->status }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection