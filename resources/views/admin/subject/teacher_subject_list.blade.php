@extends('admin.layouts.app')

@section('title', 'Teacher Subject List')
@section('content')
<div>
    <div class="container mx-auto p-4 bg-white">
        <!-- Search and Filters -->
        <hr class="my-3">
        <div class="block md:flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <form id="filterForm" method="GET" action="{{ route('admin.teacher.subject_list') }}" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="relative">
                        <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8">
                        <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 10px; transform: translateY(-50%)"></i>
                    </div>
                </form>
            </div>
            <div class="flex gap-2">
            
            <a href="{{ route('admin.teacher.create.subject', ['teacher_id' => $grade_handle->teacher_id, 'grade_handle_id' => $grade_handle->id]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center justify-center gap-3"><i class="fas fa-plus"></i> Add Subject</a>
            </div>
        </div>

        <hr class="my-3">

        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-slate-600">
                Grade {{ $grade_handle->grade ?? '' }} / {{ $grade_handle->strand }} / Section {{ $grade_handle->section }}
            </h1>
            <div class="flex gap-2">
                <button id="deleteSelected" class="px-4 py-2 bg-rose-700 text-white rounded-md flex items-center justify-center gap-3">
                    <i class="fa-solid fa-trash"></i>
                    Delete</button>
                <button onclick="window.print()" class="px-4 py-2 bg-slate-500 text-white rounded-md flex items-center justify-center gap-3"><i class="fa-solid fa-print"></i> Print</button>
                <a href="{{ route('admin.teacher.export.subject') }}?teacher_id={{ $grade_handle->teacher_id }}&grade_handle_id={{ $grade_handle->id }}" class="px-4 py-2 bg-slate-500 text-white rounded-md flex items-center justify-center gap-3"><i class="fa-solid fa-file-export"></i> Export</a>
            </div>
        </div>

        <hr class="my-3">
        @if ($subject_list->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $subject_list->firstItem() }} - {{ $subject_list->lastItem() }} of {{ $subject_list->total() }} subjects
        </p>

        <!--  List Table -->
        <div class="overflow-x-auto" id="tablePreview">
            <script>
                $(() => {
                    $('#tbl_list tbody tr').addClass('tbl_tr');
                })
            </script>
            <table id="tbl_list" class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-1 text-center border"><input type="checkbox" id="selectAll"></th>
                        <th class="py-3 px-2 text-center border">Subject</th>
                        <th class="py-3 px-2 text-center border">Teacher</th>
                        <th class="py-3 px-2 text-center border">Subject Track</th>
                        <th class="py-3 px-2 text-center border">Time</th>
                        <th class="py-3 px-2 text-center border">Day</th>
                        <th class="py-3 px-2 text-center border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subject_list as $list)
                    <tr>
                        <td class="py-2 text-center border"><input type="checkbox" class="selectRow highlight-checkbox" data-id="{{ $list->id }}"></td>
                        <td class="py-2 text-center border">{{ $list->subject }}</td>
                        <td class="py-2 text-center border">{{ $list->teacherAccount->name ?? 'N/A' }}</td>
                        <td class="py-2 text-center border">{{ $list->subject_track ?? 'N/A' }}</td>
                        
                        <td class="py-2 text-center border">{{ $list->time }}</td>
                        <td class="py-2 text-center border">{{ $list->day }}</td>

                        <td class="py-2 text-center border">
                            <a href="{{ route('admin.teacher.edit.subject', $list->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded-md">Edit</a>
                            <button onclick="confirmDelete({{ $list->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md">Delete</button>
                            <form id="delete-form-{{ $list->id }}" action="{{ route('admin.teacher.delete.subject', $list->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input name="id" type="hidden" value="{{ $id }}">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Display pagination links -->
        <div class="w-full mb-4 mt-4">
            {{ $subject_list->appends(request()->query())->links() }}
        </div>
        @else
        <div class="bg-white p-4 rounded text-center">
            <div class="text-xl font-bold">No Subjects Found</div>
            <div>There are no subjects to display at this time.</div>
        </div>

        @endif
    </div>
    <form id="deleteSelectedForm" action="{{ route('delete.selected.subjects') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_ids" id="selected_ids">
        <input name="id" type="hidden" value="{{ $id }}">
    </form>
</div>
@endsection
