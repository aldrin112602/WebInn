@extends('admin.layouts.app')

@section('title', 'Subject List')
@section('content')
<div class="p-5 bg-white">
    <div class="flex justify-end py-4">
        <a href="{{ route('admin.subject_list') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center justify-center gap-3"><i class="fas fa-list"></i> Subject List</a>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white shadow rounded-lg p-4 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl mt-2 font-bold">0 Present</p>
                    <p class="text-sm text-gray-500">Total Number of Present Students</p>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl mt-2 font-bold">0 Absent</p>
                    <p class="text-sm text-gray-500">Total Number of Absent Students</p>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 flex items-center">
                <div class="flex-grow">
                    <p class="text-2xl mt-2 font-bold">0 Late Arrival</p>
                    <p class="text-sm text-gray-500">Total Number of Late Students</p>
                </div>
                <div class="text-blue-500 text-3xl">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>


        <hr class="my-3">
        @if ($gradeHandle->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $gradeHandle->firstItem() }} - {{ $gradeHandle->lastItem() }} of {{ $gradeHandle->total() }} teacher handles
        </p>


        <div class="overflow-x-auto" id="tablePreview">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-2 text-center border">Grade</th>
                        <th class="py-3 px-2 text-center border">Strand</th>
                        <th class="py-3 px-2 text-center border">Section</th>
                        <th class="py-3 px-2 text-center border">Teacher</th>
                        <th class="py-3 px-2 text-center border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gradeHandle as $handle)
                    <tr>
                        <td class="py-2 text-center border">{{ $handle->grade }}</td>
                        <td class="py-2 text-center border">{{ $handle->strand }}</td>
                        <td class="py-2 text-center border">{{ $handle->section }}</td>
                        <td class="py-2 text-center border">{{ $TeacherAccount::where('id', $handle->teacher_id)->first()->name }}</td>
                        <td class="py-2 text-center border">
                            <a href="{{route('admin.teacher.subject_list', ['grade_handle_id' => $handle->id, 'teacher_id' => $handle->teacher_id]) }}" class="px-2 py-1 bg-blue-900 text-white rounded-md">View Subjects</a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Display pagination links -->
        <div class="w-full mb-4 mt-4">
            {{ $gradeHandle->appends(request()->query())->links() }}
        </div>
        @else
        <p>No records found.</p>
        @endif
    </div>
</div>
@endsection
