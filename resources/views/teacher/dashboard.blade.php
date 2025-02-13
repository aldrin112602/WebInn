@extends('teacher.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto p-4 text-slate-700">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white hover:bg-blue-900 hover:text-white shadow p-4 rounded">
            <div class="text-2xl font-bold">{{ $allStudentsCount }}</div>
            <div>Total number of students</div>
        </div>
        <div class="bg-white hover:bg-blue-900 hover:text-white shadow p-4 rounded">
            <div class="text-2xl font-bold">0</div>
            <div>Late Arrival</div>
        </div>
        <div class="bg-white hover:bg-blue-900 hover:text-white shadow p-4 rounded">
            <div class="text-2xl font-bold">0</div>
            <div>Absent</div>
        </div>
        <div class="bg-white hover:bg-blue-900 hover:text-white shadow p-4 rounded">
            <div class="text-2xl font-bold">0</div>
            <div>Present</div>
        </div>
    </div>

    <hr class="my-6">

    <div class="flex align-center justify-between mb-4">
        <h1 class="font-bold">Grade handles</h1>
        <a href="{{ route('teacher.view.add_grade_handle') }}" class="px-3 py-1 text-sm bg-blue-900 text-white rounded-lg"><i class="fas fa-plus"></i> Add</a>
    </div>

    @if($handleSubjects->isEmpty())
    <div class="bg-white p-4 rounded text-center">
        <div class="text-xl font-bold">No Grade Handles Found</div>
        <div>There are no grade handles to display at this time.</div>
    </div>

    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($handleSubjects as $list)
        <div class="bg-white shadow p-4 rounded hover:bg-blue-700 hover:text-white flex items-center justify-between">
            <div class="w-full">
                <div class="font-bold">Grade {{ $list->grade }} - {{ $list->strand }}</div>
                <div class="mt-2">Section {{ $list->section }}</div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('teacher.subject_list', ['id' => $list->id])}}" title="Click to view">
                    <i class="text-sm fas fa-eye"></i>
                </a>


                <a href="{{ route('teacher.edit.grade_handle', $list->id) }}" title="Click to edit">
                    <i class="text-sm fas fa-edit hover:text-green-400"></i>
                </a>
                <button onclick="confirmDelete({{ $list->id }})" title="Click to edit">
                    <i class="text-sm fas fa-trash hover:text-rose-400"></i>
                </button>
                <form id="delete-form-{{ $list->id }}" action="{{ route('teacher.delete.grade_handle') }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $list->id }}">
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection