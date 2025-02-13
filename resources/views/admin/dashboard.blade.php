@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="bg-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Top Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white shadow rounded-lg p-5 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl font-bold text-slate-700">0 Present</p>
                    <p class="text-sm text-gray-500 mt-2">Total Number of Present Students</p>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-5 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl font-bold text-slate-700">0 Absent</p>
                    <p class="text-sm text-gray-500 mt-2">Total Number of Absent Students</p>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-5 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl font-bold text-slate-700">0 Late Arrival</p>
                    <p class="text-sm text-gray-500 mt-2">Total Number of Late Students</p>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <!-- Category Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-100 shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-slate-600">Admins</p>
                    <p class="text-2xl mt-2 font-semibold text-slate-700">{{ $adminsCount }}</p>
                </div>
                <a href="{{ route('admin.create.admin') }}" class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="bg-blue-100 shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-slate-600">Teachers</p>
                    <p class="text-2xl mt-2 font-semibold text-slate-700">{{ $teachersCount }}</p>
                </div>
                <a href="{{ route('admin.create.teacher') }}" class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="bg-blue-100 shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-slate-600">Students</p>
                    <p class="text-2xl mt-2 font-semibold text-slate-700">{{ $studentsCount }}</p>
                </div>
                <a href="{{ route('admin.create.student') }}" class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="bg-blue-100 shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-slate-600">Guidance</p>
                    <p class="text-2xl mt-2 font-semibold text-slate-700">{{ $guidancesCount }}</p>
                </div>
                <a href="{{ route('admin.create.guidance') }}" class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
