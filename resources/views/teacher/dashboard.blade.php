@extends('teacher.layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="container mx-auto p-4 text-slate-700">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}</h1>
                <p class="mt-2 opacity-90">{{ now()->format('l, F j, Y') }}</p>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-sm opacity-90">Last login: {{ Auth::user()->last_login ? Auth::user()->last_login->format('M d, Y h:i A') : 'First time login' }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white hover:bg-blue-900 hover:text-white shadow-md p-4 rounded-lg transition duration-300 ease-in-out">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold">{{ $allStudentsCount }}</div>
                    <div class="text-sm">Total Students</div>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white hover:bg-blue-900 hover:text-white shadow-md p-4 rounded-lg transition duration-300 ease-in-out">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold">{{ $handleSubjects->count() }}</div>
                    <div class="text-sm">Grade Handles</div>
                </div>
                <div class="text-yellow-500 text-3xl">
                    <i class="fas fa-chalkboard"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white hover:bg-blue-900 hover:text-white shadow-md p-4 rounded-lg transition duration-300 ease-in-out">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold">{{ $handleSubjects->sum('subjects_count') ?? 0 }}</div>
                    <div class="text-sm">Total Subjects</div>
                </div>
                <div class="text-green-500 text-3xl">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Grade Handles Section -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="border-b px-6 py-3 flex justify-between items-center">
            <h2 class="font-semibold text-lg">My Grade Handles</h2>
            <a href="{{ route('teacher.view.add_grade_handle') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 flex items-center gap-2">
                <i class="fas fa-plus text-sm"></i> Add New Handle
            </a>
        </div>

        <div class="p-6">
            <!-- Status messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if($handleSubjects->isEmpty())
                <div class="bg-gray-50 p-8 rounded text-center">
                    <div class="text-gray-400 mb-3">
                        <i class="fas fa-chalkboard text-5xl"></i>
                    </div>
                    <div class="text-xl font-semibold mb-2">No Grade Handles Yet</div>
                    <p class="text-gray-500 mb-4">You haven't been assigned any grade handles. Click the button below to add your first one.</p>
                    <a href="{{ route('teacher.view.add_grade_handle') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg inline-block hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-plus mr-2"></i> Add Grade Handle
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($handleSubjects as $list)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <div class="p-4 border-b bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div class="font-bold text-lg">Grade {{ $list->grade }} - {{ $list->strand }}</div>
                                <div class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    Section {{ $list->section }}
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex gap-2 justify-end mt-3">
                                <a href="{{ route('teacher.subject_list', ['id' => $list->id])}}" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300 text-sm">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('teacher.edit.grade_handle', $list->id) }}" class="px-3 py-1.5 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition duration-300 text-sm">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <button onclick="confirmDelete({{ $list->id }})" class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300 text-sm">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                                <form id="delete-form-{{ $list->id }}" action="{{ route('teacher.delete.grade_handle') }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $list->id }}">
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination if needed -->
                @if(method_exists($handleSubjects, 'links'))
                <div class="mt-6">
                    {{ $handleSubjects->links() }}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
        <div class="text-center">
            <div class="mb-4 text-red-500 text-5xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-xl font-bold mb-4">Confirm Deletion</h3>
            <p class="mb-6">Are you sure you want to delete this grade handle? This action cannot be undone.</p>
            <div class="flex justify-center space-x-4">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition duration-300">
                    Cancel
                </button>
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Store dashboard preferences in localStorage
document.addEventListener('DOMContentLoaded', function() {
    // Remember last visited section
    localStorage.setItem('lastTeacherDashboardVisit', new Date().toISOString());
    
    // Example of tracking which cards were expanded/collapsed
    document.querySelectorAll('.collapsible-card').forEach(card => {
        card.addEventListener('click', function() {
            const cardId = this.getAttribute('data-card-id');
            const isExpanded = this.classList.contains('expanded');
            
            // Store state in localStorage
            localStorage.setItem(`card_${cardId}_expanded`, !isExpanded);
        });
        
        // Restore state
        const cardId = card.getAttribute('data-card-id');
        const wasExpanded = localStorage.getItem(`card_${cardId}_expanded`) === 'true';
        if (wasExpanded) {
            card.classList.add('expanded');
        }
    });
});

// Delete confirmation modal
function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    confirmBtn.addEventListener('click', function() {
        document.getElementById(`delete-form-${id}`).submit();
    });
    
    const cancelBtn = document.getElementById('cancelDelete');
    cancelBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
}

// Apply highlighting to recently modified items, if any
document.addEventListener('DOMContentLoaded', function() {
    // Check if we have any items that were recently modified
    const recentlyModified = localStorage.getItem('recentlyModifiedHandle');
    if (recentlyModified) {
        // Find and highlight that item
        const element = document.querySelector(`[data-id="${recentlyModified}"]`);
        if (element) {
            element.classList.add('bg-yellow-50', 'border-yellow-300');
            setTimeout(() => {
                element.classList.remove('bg-yellow-50', 'border-yellow-300');
            }, 3000);
        }
        
        // Clear the flag
        localStorage.removeItem('recentlyModifiedHandle');
    }
});
</script>
@endsection