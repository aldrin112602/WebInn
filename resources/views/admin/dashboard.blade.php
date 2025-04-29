@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="bg-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <div class="text-blue-500 text-3xl mr-4">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome to the Admin Dashboard</h1>
            </div>
            <p class="text-gray-600">Hello <b>{{ Auth::user()->name }}</b>! <br>welcome to your administration panel. Here you can manage users, view statistics, and access all system features.</p>
            <div class="mt-4 text-sm">
                <span class="text-gray-500">Last login: {{ Auth::user()->last_login ?? 'First time login' }}</span>
            </div>
        </div>

        <!-- Quick Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow rounded-lg p-5 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl font-bold text-slate-700">{{ $adminsCount + $teachersCount + $studentsCount }}</p>
                    <p class="text-sm text-gray-500 mt-2">Total Users</p>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-5 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl font-bold text-slate-700">{{ $studentsCount }}</p>
                    <p class="text-sm text-gray-500 mt-2">Students</p>
                </div>
                <div class="text-green-500 text-3xl">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-5 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl font-bold text-slate-700">{{ $teachersCount }}</p>
                    <p class="text-sm text-gray-500 mt-2">Teachers</p>
                </div>
                <div class="text-yellow-500 text-3xl">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-5 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl font-bold text-slate-700">{{ $adminsCount }}</p>
                    <p class="text-sm text-gray-500 mt-2">Admins</p>
                </div>
                <div class="text-purple-500 text-3xl">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.create.admin') }}" class="bg-blue-100 hover:bg-blue-200 p-4 rounded-lg text-center transition duration-300">
                    <div class="text-blue-500 text-2xl mb-2">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <p class="text-gray-700">Add Admin</p>
                </a>
                <a href="{{ route('admin.create.teacher') }}" class="bg-yellow-100 hover:bg-yellow-200 p-4 rounded-lg text-center transition duration-300">
                    <div class="text-yellow-500 text-2xl mb-2">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <p class="text-gray-700">Add Teacher</p>
                </a>
                <a href="{{ route('admin.create.student') }}" class="bg-green-100 hover:bg-green-200 p-4 rounded-lg text-center transition duration-300">
                    <div class="text-green-500 text-2xl mb-2">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <p class="text-gray-700">Add Student</p>
                </a>
                <a href="{{ route('admin.profile') }}" class="bg-purple-100 hover:bg-purple-200 p-4 rounded-lg text-center transition duration-300">
                    <div class="text-purple-500 text-2xl mb-2">
                        <i class="fas fa-cog"></i>
                    </div>
                    <p class="text-gray-700">Settings</p>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection