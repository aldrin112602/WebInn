@extends('teacher.layouts.app')

@section('title', 'Class Attendance')
@section('content')
<style>
    @media print {
        #printable {
            display: block;
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: white;

            button {
                display: none !important;
            }
        }
    }
</style>
<div class="p-5">
    <div class="bg-white rounded-lg shadow-lg p-6" id="printable">
        <!-- Header Information -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold mb-4">Class Attendance</h2>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-500">Print</button>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-gray-600">Teacher: <span class="font-semibold">{{ $teacher->name }}</span></p>
                    <p class="text-gray-600">Subject: <span class="font-semibold">{{ $subject->subject }}</span></p>
                </div>
                <div>
                    <p class="text-gray-600">Subject-Time: <span class="font-semibold">{{ $subject->time }}</span></p>
                    <p class="text-gray-600">Date: <span class="font-semibold">{{ \Carbon\Carbon::parse($selected_date)->format('F d, Y') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border">Student Number</th>
                        <th class="py-2 px-4 border">Student Name</th>
                        <th class="py-2 px-4 border">Attendance Status</th>
                        <th class="py-2 px-4 border">Time In</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @php
                            $attendanceRecord = $attendance->where('student_id', $student->student_id)->first();
                        @endphp
                        <tr>
                            <td class="text-center py-2 px-4 border">{{ $student->id_number }}</td>
                            <td class="text-center py-2 px-4 border">{{ $student->name }}</td>
                            <td class="text-center py-2 px-4 border text-center">
                                @if($attendanceRecord)
                                    <span class="text-green-600">Present</span>
                                @else
                                    <span class="text-red-600">Absent</span>
                                @endif
                            </td>
                            <td class="text-center py-2 px-4 border text-center">
                                {{ $attendanceRecord ? \Carbon\Carbon::parse($attendanceRecord->created_at)->format('h:i A') : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Stats -->
        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-3">Today's Summary</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-600">Total Students</p>
                    <p class="text-2xl font-bold">{{ $students->count() }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-600">Present</p>
                    <p class="text-2xl font-bold">{{ $attendance->count() }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-600">Attendance Rate</p>
                    <p class="text-2xl font-bold">
                        @php
                            $attendanceRate = $students->count() > 0 ? 
                                round(($attendance->count() / $students->count()) * 100, 1) : 0;
                        @endphp
                        {{ $attendanceRate }}%
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection