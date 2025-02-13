@extends('teacher.layouts.app')

@section('title', 'My Subjects')

@section('content')
<div class="container mx-auto p-4 text-slate-700">
    <div class="bg-blue-500 text-white p-4 rounded-md my-4 flex items-center justify-between">
        Grade {{$user->grade_handle}}

        <a href="{{ route('teacher.subject_list') }}" class="border px-3 py-1 rounded-lg bg-slate-50 text-slate-900">
            <i class="fas fa-list"></i>
            Subject List
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($allSubjects as $subject)
        <div class="bg-white shadow p-4 rounded">
            <div class="font-bold">{{ $subject->subject }}</div>
            <div>{{ $subject->time }} {{ strtoupper($subject->day) }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection