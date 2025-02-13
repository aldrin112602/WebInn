@extends('admin.layouts.app')

@section('title', 'Attendace Absent')
@section('content')
<div>
    <div class="container mx-auto p-4 bg-white">

        <div class="flex items-center justify-start gap-2">
            <a href="{{ route('admin.attendance.report') }}" class="px-4 py-2 {{ request()->is('admin/attendance/report') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded-md flex items-center justify-center gap-3">Report</a>
            <a href="{{ route('admin.attendance.present') }}?status=present" class="px-4 py-2 {{ request()->is('admin/attendance/present') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded-md flex items-center justify-center gap-3">Present</a>
            <a href="{{ route('admin.attendance.absent') }}?status=absent" class="px-4 py-2 {{ request()->is('admin/attendance/absent') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded-md flex items-center justify-center gap-3">Absent</a>
        </div>
        <!-- Search and Filters -->
        <hr class="my-3">
        <div class="block md:flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <form id="filterForm" method="GET" action="#!" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="md:w-3/4 relative">
                        <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8">
                        <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 10px; transform: translateY(-50%)"></i>

                    </div>
                    <select name="gender" class="py-2 border rounded-md" onchange="document.getElementById('filterForm').submit();">
                        <option value="" disabled selected hidden>Gender</option>
                        <option value="Male" {{ request()->get('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request()->get('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="All" {{ request()->get('gender') == "All" ? "selected" : "" }}>All</option>
                    </select>
                    <select name="strand" class="py-2 border rounded-md" onchange="document.getElementById('filterForm').submit();">
                        <option value="" disabled selected hidden>Strand</option>
                        <option value="ABM" {{ request()->get('strand') == 'ABM' ? 'selected' : '' }}>ABM</option>
                        <option value="ICT" {{ request()->get('strand') == 'ICT' ? 'selected' : '' }}>ICT</option>
                        <option value="HUMSS" {{ request()->get('strand') == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                        <option value="HE" {{ request()->get('strand') == 'HE' ? 'selected' : '' }}>HE</option>
                        <option value="All" {{ request()->get('strand') == "All" ? "selected" : "" }}>All</option>
                    </select>
                    <select name="grade" class="py-2 border rounded-md" onchange="document.getElementById('filterForm').submit();">
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
            <h1 class="font-semibold text-slate-600">ABSENT STUDENT LIST</h1>

        </div>

        <hr class="my-3">

        @if ($studentsWithoutFaceScan->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $studentsWithoutFaceScan->firstItem() }} - {{ $studentsWithoutFaceScan->lastItem() }} of {{ $studentsWithoutFaceScan->total() }} students
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
                        <!-- <th class="py-2 px-1 text-center border">
                            <input type="checkbox" id="selectAll">
                        </th> -->
                        <th class="py-3 px-2 text-center border">ID No.</th>
                        <th class="py-3 px-2 text-center border">First Name</th>
                        <th class="py-3 px-2 text-center border">Last Name</th>
                        <th class="py-3 px-2 text-center border">Gender</th>
                        <th class="py-3 px-2 text-center border">Strand</th>
                        <th class="py-3 px-2 text-center border">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($studentsWithoutFaceScan as $account)
                    <tr>

                        <td class="py-2 text-center border">{{ $account->id_number }}</td>
                        <td class="py-2 text-center border">
                            {{explode(" ", $account->name)[0]}}
                        </td>
                        <td class="py-2 text-center border">
                            {{explode(" ", $account->name)[count(explode(" ", $account->name)) - 1]}}
                        </td>
                        <td class="py-2 text-center border">{{
                            $account->gender
                        }}</td>
                        <td class="py-2 text-center border">{{ $account->strand }}</td>
                        <td class="py-2 text-center border">
                            <a href="{{route('admin.view_attendance_history', $account->id) }}?status=absent" class="px-2 py-1 bg-blue-500 text-white rounded-md">View</a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Display pagination links -->
            <div class="w-full mb-4 mt-4">
                {{ $studentsWithoutFaceScan->appends(request()->query())->links() }}
            </div>
            @else
            <p>No records found.</p>
            @endif

        </div>

    </div>
    <form id="deleteSelectedForm" action="#!" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_ids" id="selected_ids">
    </form>

</div>
@endsection