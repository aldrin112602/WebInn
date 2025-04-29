@extends('admin.layouts.app')

@section('title', 'Subject List')
@section('content')
<div class="p-5 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center py-4">
            <h1 class="text-2xl font-bold text-gray-800">Subject List Management</h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.subject_list') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center justify-center gap-2 hover:bg-blue-600 transition duration-300">
                    <i class="fas fa-list"></i> Subject List
                </a>
            </div>
        </div>
        

        <hr class="my-3">
        
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
        
        @if ($gradeHandle->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $gradeHandle->firstItem() }} - {{ $gradeHandle->lastItem() }} of {{ $gradeHandle->total() }} teacher handles
        </p>

        <div class="overflow-x-auto bg-white rounded-lg shadow" id="tablePreview">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Grade</th>
                        <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Strand</th>
                        <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Section</th>
                        <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Teacher</th>
                        <th class="py-3 px-4 text-center border-b font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gradeHandle as $handle)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ $handle->grade }}</td>
                        <td class="py-3 px-4 border-b">{{ $handle->strand }}</td>
                        <td class="py-3 px-4 border-b">{{ $handle->section }}</td>
                        <td class="py-3 px-4 border-b">{{ $TeacherAccount::where('id', $handle->teacher_id)->first()->name }}</td>
                        <td class="py-3 px-4 border-b text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{route('admin.teacher.subject_list', ['grade_handle_id' => $handle->id, 'teacher_id' => $handle->teacher_id]) }}" 
                                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300 flex items-center">
                                   <i class="fas fa-book mr-1"></i> View Subjects
                                </a>
                               
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Display pagination links -->
        <div class="w-full mt-4">
            {{ $gradeHandle->appends(request()->query())->links() }}
        </div>
        @else
        <div class="bg-gray-50 p-8 text-center rounded-lg border border-gray-200">
            <div class="text-gray-500 text-xl mb-4">
                <i class="fas fa-folder-open text-4xl mb-3"></i>
                <p>No records found.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection