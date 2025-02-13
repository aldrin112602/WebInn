@extends('student.layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📢 Announcements</h1>

    @if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg shadow mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 inline-block mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($announcements->isEmpty())
    <p class="text-gray-600 italic">No announcements available at the moment.</p>
    @else
    @foreach($announcements as $announcement)
    <div class="bg-white border border-gray-300 p-6 rounded-lg shadow-lg mb-6 transition-transform transform hover:scale-105">
        <div class="flex items-center mb-4">
            <div class="bg-blue-500 text-white rounded-full p-2 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 8.25l-6 6m0 0l6 6m-6-6h16.5" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800">{{ $announcement->title }}</h2>
        </div>

        <p class="text-gray-700 mb-4">{{ $announcement->announcement }}</p>



        @if($announcement->file_path)
        <a href="{{ asset('storage/' . $announcement->file_path) }}"
            class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium my-3"
            download>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5 7.5m0 0l7.5-7.5m-7.5 7.5V3" />
            </svg>
            Download Attachment
        </a>
        @endif

        <hr>


        <p class="text-gray-500 text-sm mt-4 flex align-items-center justify-between">
            <span>
            📅 Posted on {{ $announcement->created_at->format('M d, Y') }} at {{ $announcement->created_at->format('h:i A') }}

            </span>

            <span class="text-gray-500 italic text-sm">
                Posted by: {{ $announcement->teacher->name ?? 'Unknown' }}
            </span>
        </p>
    </div>
    @endforeach
    @endif
</div>
@endsection