@extends('teacher.layouts.app')

@section('title', 'Edit Announcement')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        <i class="fas fa-edit"></i> Edit Announcement
    </h1>

    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded-lg shadow mb-6">
        <i class="fas fa-exclamation-circle"></i> Please fix the errors below:
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('teacher.update_announcement', $announcement->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <!-- Announcement Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Announcement Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Announcement Content -->
        <div class="mb-4">
            <label for="announcement" class="block text-gray-700 font-medium mb-2">Announcement Content:</label>
            <textarea name="announcement" id="announcement" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ old('announcement', $announcement->announcement) }}</textarea>
        </div>

        <!-- Current Attachment (if exists) -->
        @if($announcement->file_path)
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Current Attachment:</label>
            <a href="{{ asset('storage/' . $announcement->file_path) }}" class="text-blue-600 hover:text-blue-800 font-medium" download>
                <i class="fas fa-download"></i> Download Current File
            </a>
        </div>
        @endif

        <!-- File Upload (Optional) -->
        <div class="mb-4">
            <label for="file" class="block text-gray-700 font-medium mb-2">Upload New Attachment (optional):</label>
            <input type="file" name="file" id="file" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none">
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fas fa-save"></i> Update Announcement
            </button>
            <a href="{{ route('teacher.announcements') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded ml-4">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
