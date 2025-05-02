@extends('admin.layouts.app')

@section('title', 'Student List')
@section('content')

<div>
    <div class="container mx-auto p-4 bg-white">
        <!-- Search and Filters -->
        <hr class="my-3">
        <div class="block md:flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <form id="filterForm" method="GET" action="{{ route('admin.grade.student_list') }}" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="md:w-3/4 relative">
                        <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8">
                        <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 10px; transform: translateY(-50%)"></i>

                    </div>
                    <select name="gender" class="py-2 border rounded-md px-10" onchange="document.getElementById('filterForm').submit();">
                        <option value="" disabled selected hidden>Gender</option>
                        <option value="Male" {{ request()->get('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request()->get('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="All" {{ request()->get('gender') == "All" ? "selected" : "" }}>All</option>
                    </select>
                    <select name="strand" class="py-2 border rounded-md px-10" onchange="document.getElementById('filterForm').submit();">
                        <option value="" disabled selected hidden>Strand</option>
                        <option value="ABM" {{ request()->get('strand') == 'ABM' ? 'selected' : '' }}>ABM</option>
                        <option value="ICT" {{ request()->get('strand') == 'ICT' ? 'selected' : '' }}>ICT</option>
                        <option value="HUMSS" {{ request()->get('strand') == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                        <option value="HE" {{ request()->get('strand') == 'HE' ? 'selected' : '' }}>HE</option>
                        <option value="All" {{ request()->get('strand') == "All" ? "selected" : "" }}>All</option>
                    </select>
                    <select name="grade" class="py-2 border rounded-md px-10" onchange="document.getElementById('filterForm').submit();">
                        <option value="" disabled selected hidden>Grade</option>
                        <option value="11" {{ request()->get('grade') == '11' ? 'selected' : '' }}>Grade 11</option>
                        <option value="12" {{ request()->get('grade') == '12' ? 'selected' : '' }}>Grade 12</option>
                        <option value="All" {{ request()->get('grade') == "All" ? "selected" : "" }}>All</option>
                    </select>
                </form>
            </div>
        </div>

        <hr class="my-3">

        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-slate-600">STUDENT LIST</h1>
        </div>

        <hr class="my-3">
        @if ($account_list->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $account_list->firstItem() }} - {{ $account_list->lastItem() }} of {{ $account_list->total() }} students
        </p>

        <!-- Student List Table -->
        <div class="overflow-x-auto" id="tablePreview">
            <table id="tbl_list" class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-2 text-center border">ID No.</th>
                        <th class="py-3 px-2 text-center border">Username</th>
                        <th class="py-3 px-2 text-center border">Name</th>
                        <th class="py-3 px-2 text-center border">Gender</th>
                        <th class="py-3 px-2 text-center border">Grade</th>
                        <th class="py-3 px-2 text-center border">Strand</th>
                        <th class="py-3 px-2 text-center border">Grades</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($account_list as $list)
                    <tr class="tbl_tr">
                        <td class="py-2 text-center border">{{ $list->id_number }}</td>
                        <td class="py-2 text-center border">{{ $list->username }}</td>
                        <td class="py-2 text-center border">{{ $list->name }}</td>
                        <td class="py-2 text-center border">{{ $list->gender }}</td>
                        <td class="py-2 text-center border">{{ $list->grade }}</td>
                        <td class="py-2 text-center border">{{ $list->strand }}</td>
                        <td class="py-2 text-center border">
                            <a href="{{ route('admin.student.grades', $list->id) }}" class="px-3 py-1 bg-purple-600 rounded-lg text-white">View Grade</a>
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
        <p>No records found.</p>
        @endif
    </div>
    

</div>
@endsection