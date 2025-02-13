@extends('teacher.layouts.app')

@section('title', 'Absents List')
@section('content')
<div>
    <div class="container mx-auto p-4 bg-white">
        <!-- Search and Filters -->
        <hr class="my-3">
        <div class="block md:flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <form id="filterForm" method="GET" action="{{ route('teacher.student_list') }}" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="md:w-3/4 relative">
                        <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8">
                        <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 10px; transform: translateY(-50%)"></i>
                    </div>
                    <input type="hidden" name="id" value="{{request()->query('id')}}">
                    <select name="gender" class="py-2 border rounded-md" onchange="document.getElementById('filterForm').submit();">
                        <option value="All" {{ request()->get('gender') == 'All' ? 'selected' : '' }}>All</option>
                        <option value="Male" {{ request()->get('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request()->get('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </form>

            </div>
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('teacher.attendance.presents', ['id' => $id]) }}" class="px-4 py-2 bg-purple-800 text-white rounded-md flex items-center justify-center gap-3">
                    <i class="fa-solid fa-check"></i>
                    Present
                </a>

            </div>
        </div>

        <hr class="my-3">

        <div class="block md:flex items-center justify-between">
            <h1 class="font-semibold text-slate-600">GRADE {{ $grade_handle->grade }} - {{ $grade_handle->strand }} / SECTION {{ $grade_handle->section }} / ABSENT LIST</h1>
            <div class="flex gap-2">
                <button id="deleteSelected" class="px-4 py-2 bg-rose-700 text-white rounded-md flex items-center justify-center gap-3">
                    <i class="fa-solid fa-trash"></i>
                    Delete</button>
                <button onclick="window.print()" class="px-4 py-2 bg-slate-500 text-white rounded-md flex items-center justify-center gap-3">
                    <i class="fa-solid fa-print"></i>
                    Print</button>
                <a href="{{ route('admin.export.student') }}" class="px-4 py-2 bg-slate-500 text-white rounded-md flex items-center justify-center gap-3">
                    <i class="fa-solid fa-file-export"></i>
                    Export</a>
            </div>
        </div>

        <hr class="my-3">
        @if ($account_list->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $account_list->firstItem() }} - {{ $account_list->lastItem() }} of {{ $account_list->total() }} students
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
                        <th class="py-2 px-1 text-center border">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th class="py-3 px-2 text-center border">ID No.</th>
                        <th class="py-3 px-2 text-center border">Username</th>
                        <th class="py-3 px-2 text-center border">Name</th>
                        <th class="py-3 px-2 text-center border">Gender</th>
                        <th class="py-3 px-2 text-center border">Grade</th>
                        <th class="py-3 px-2 text-center border">Strand</th>
                        <th class="py-3 px-2 text-center border">Subjects</th>
                        <th class="py-3 px-2 text-center border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($account_list as $list)
                    <tr>
                        <td class="py-2 text-center border">
                            <input type="checkbox" class="selectRow highlight-checkbox" data-id="{{ $list->id }}">
                        </td>
                        <td class="py-2 text-center border">{{ $list->id_number }}</td>
                        <td class="py-2 text-center border">{{ $list->username }}</td>
                        <td class="py-2 text-center border">{{ $list->name }}</td>
                        <td class="py-2 text-center border">{{ $list->gender }}</td>
                        <td class="py-2 text-center border">{{ $list->grade }}</td>
                        <td class="py-2 text-center border">{{ $list->strand }}</td>
                        <td class="py-2 text-center border">
                            <a href="{{ route('admin.view.subjects', $list->id) }}" class="px-2 py-1 bg-indigo-600 text-white rounded-md">View</a>
                        </td>
                        <td class="py-2 text-center border">
                            <a href="{{ route('admin.edit.student', $list->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded-md">Edit</a>
                            <button onclick="confirmDelete({{ $list->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md">Delete</button>
                            <form id="delete-form-{{ $list->id }}" action="{{ route('teacher.delete.student', ['id' => $id]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{$list->id}}">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Display pagination links -->
        <div class="w-full mb-4 mt-4">
            {{ $account_list->appends(request()->query())->links() }}
        </div>
        @else
        <div class="bg-white p-4 rounded text-center">
            <div class="text-xl font-bold">No Students Found!</div>
            <div>There are no students to display at this time.</div>
        </div>
        @endif
    </div>
    <form id="deleteSelectedForm" action="{{ route('teacher.delete.selected.students', ['id' => $id]) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_ids" id="selected_ids">
    </form>
</div>

@endsection