@extends('guidance.layouts.app')

@section('title', 'Attendance History')

@section('content')
<div class="p-4 bg-white">
    <div class="flex justify-between items-center mb-4">
    <h1 class="">STUDENT LIST</h1>
        <div class="relative">
            <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search" class="w-full p-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute top-3 right-3 text-slate-500"></i>
        </div>
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
                        <th class="py-3 px-2 text-center border">Action</th>
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
                            <a href="{{ route('guidance.view_attendance_history', $list->id) }}" class="py-1 rounded px-3 bg-blue-900 text-white">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            Attendance history
                            </a>
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
