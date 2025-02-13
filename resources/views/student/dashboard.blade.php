@extends('student.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="px-6 py-4 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Today's Subject -->
        <div class="p-6 shadow-md rounded-lg bg-gray-50">
            <div class="font-semibold text-xl text-gray-700 mb-3">Today's Subject</div>
            @if ($subjects_today->isEmpty())
            <div class="bg-white p-6 rounded-lg text-center border border-gray-200">
                <div class="text-xl font-bold text-gray-600">No Subjects Found!</div>
                <p class="text-gray-500">You don't have subjects today.</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach ($subjects_today as $subject)
                <div class="p-4 shadow rounded bg-white border border-gray-200">
                    <div class="font-medium text-gray-800">{{ $subject->subject }}</div>
                    <hr class="my-2">
                    <div class="flex items-center justify-between mt-2 text-sm text-gray-500">
                        <div>
                            {{ $TeacherModel::where('id', $subject->teacher_id)->first()->name }} <br>
                            {{ $subject->day }} | {{ $subject->time }}
                        </div>
                        <a href="{{ route('qr.scan.get', [ 'subject_id' => $subject->id, 'teacher_id' => $subject->teacher_id ]) }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded px-3 pt-2 pb-2 flex items-center space-x-2">
                            <i class="fas fa-qrcode"></i> <!-- QR Code Icon -->
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Enrolled Subjects -->
        <div class="col-span-2 p-6 shadow-md rounded-lg bg-gray-50">
            <div class="font-semibold text-xl text-gray-700">Enrolled Subjects</div>
            @if ($enrolled_subjects->isEmpty())
            <div class="bg-white p-6 rounded-lg text-center border border-gray-200">
                <div class="text-xl font-bold text-gray-600">No Subjects Found!</div>
                <p class="text-gray-500">You don't have subjects to display at this time.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                @foreach ($enrolled_subjects as $subject)
                <div class="p-4 shadow rounded bg-white border border-gray-200 text-center hover:bg-gray-100 cursor-pointer">
                    <span class="font-medium text-gray-800">{{ $subject->subject }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection