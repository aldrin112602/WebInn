@extends('teacher.layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        <i class="fas fa-bullhorn"></i> Manage Announcements
    </h1>

    @if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg shadow mb-6">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if($announcements->isEmpty())
    <p class="text-gray-600 italic">No announcements available at the moment.</p>
    @else
    @foreach($announcements as $announcement)
    <div class="bg-white border border-gray-300 p-6 rounded-lg shadow-lg mb-6">
        <div class="flex items-center mb-4">
            <div class="bg-blue-500 text-white rounded-full p-2 mr-4 px-3">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800">{{ $announcement->title }}</h2>
        </div>

        <p class="text-gray-700 mb-4">{{ $announcement->announcement }}</p>

        @if($announcement->file_path)
        <a href="{{ asset('storage/' . $announcement->file_path) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium my-3" download>
            <i class="fas fa-download mr-2"></i> Download Attachment
        </a>
        @endif

        <hr>

        <p class="text-gray-500 text-sm mt-4 flex justify-between">
            <span>
                <i class="far fa-calendar-alt"></i> Posted on {{ $announcement->created_at->format('M d, Y') }} at {{ $announcement->created_at->format('h:i A') }}
            </span>
        </p>

        <!-- Edit and Delete Buttons -->
        <div class="flex space-x-4 mt-4">
            <a href="{{ route('teacher.edit_announcement', $announcement->id) }}" class="bg-yellow-400 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded shadow">
                <i class="fas fa-edit"></i> Edit
            </a>

            <!-- Delete button trigger -->
            <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded shadow delete-btn" data-id="{{ $announcement->id }}">
                <i class="fas fa-trash-alt"></i> Delete
            </button>

            <!-- Form to handle delete submission, hidden by default -->
            <form id="delete-form-{{ $announcement->id }}" action="{{ route('teacher.delete_announcement', $announcement->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection

@section('scripts')
<!-- Include SweetAlert2 via CDN -->
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>

<script>
    document.querySelectorAll(".delete-btn").forEach(t=>{t.addEventListener("click",function(){let t=this.getAttribute("data-id"),e=document.getElementById(`delete-form-${t}`);Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(t=>{t.isConfirmed&&e.submit()})})});
</script>
@endsection
