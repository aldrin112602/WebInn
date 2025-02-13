@extends('admin.layouts.app')

@section('title', 'Grade handle')
@section('content')
<div>
    <div class="container mx-auto p-4 bg-white">
        <!-- Search and Filters -->
        <hr class="my-3">
        <div class="block md:flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="relative">
                        <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8">
                        <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 10px; transform: translateY(-50%)"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.view.add_grade_handle', $id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center justify-center gap-3"><i class="fas fa-plus"></i> Add grade handle</a>
        </div>

        <hr class="my-3">

        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-slate-600">GRADE HANDLE</h1>
        </div>

        <hr class="my-3">
        @if ($records->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $records->firstItem() }} - {{ $records->lastItem() }} of {{ $records->total() }} handles
        </p>

        <!-- Student List Table -->
        <div class="overflow-x-auto" id="tablePreview">
            <script>
                $(() => {
                    $('#tbl_list tbody tr').addClass('tbl_tr');
                })
            </script>
            <table id="tbl_list" class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-1 text-center border">Grade</th>
                        <th class="py-2 px-1 text-center border">Strand</th>
                        <th class="py-2 px-1 text-center border">Section</th>
                        <th class="py-2 px-1 text-center border">Created at</th>
                        <th class="py-2 px-1 text-center border">Subjects</th>
                        <th class="py-2 px-1 text-center border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $list)
                    <tr>
                        <td class="py-2 text-center border">{{ $list->grade }}</td>
                        <td class="py-2 text-center border">{{ $list->strand }}</td>
                        <td class="py-2 text-center border">{{ $list->section }}</td>
                        <td class="py-2 text-center border">{{ $list->time_ago }}</td>
                        <td class="py-2 text-center border">
                            <a href="{{ route('admin.teacher.subject_list') }}?grade_handle_id={{$list->id}}" class="px-2 py-1 bg-blue-800 text-white rounded-md">View</a>
                        </td>
                        <td class="py-2 text-center border">
                            <a href="{{ route('admin.edit.grade_handle', $list->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded-md">Edit</a>
                            <button onclick="confirmDelete({{ $list->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md">Delete</button>
                            <form id="delete-form-{{ $list->id }}" action="{{ route('admin.delete.grade_handle') }}" method="POST" style="display: none;">
                                <input type="hidden" name="id" value="{{ $list->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Display pagination links -->
        <div class="w-full mb-4 mt-4">
            {{ $records->appends(request()->query())->links() }}
        </div>
        @else
        <p class="p-5 text-rose-700">No grade handle's found.</p>
        @endif
    </div>
    <form id="deleteSelectedForm" action="{{ route('admin.delete.selected.teachers') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_ids" id="selected_ids">
    </form>

</div>
@endsection