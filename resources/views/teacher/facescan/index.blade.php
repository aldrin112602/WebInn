@extends('teacher.layouts.app')

@section('title', 'Face Attendance')
@section('content')

<style>
    @media print {
        #tablePreview2 {
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            z-index: 100;
            width: 100vw;
            height: 100vh;

            h1 {
                display: block !important;
                margin-top: 5rem;
            }
        }
    }
</style>
<div>
    <div class="container mx-auto p-4 bg-white">

        <!-- Search and Filters -->
        <hr class="my-3">
        <div class="block md:flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <form id="filterForm" method="GET" action="#!" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="md:w-3/4 relative">
                        <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search..." class="form-input rounded w-full pl-8">
                        <i class="fas fa-search absolute text-sm text-slate-400" style="top: 50%; left: 10px; transform: translateY(-50%)"></i>

                    </div>
                </form>
            </div>

        </div>

        <hr class="my-3">

        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-slate-600">FACE SCAN ATTENDANCE</h1>
            <div class="flex gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-slate-500 text-white rounded-md flex items-center justify-center gap-3">
                    <i class="fa-solid fa-print"></i>
                    Print</button>
                <a href="#!" class="px-4 py-2 bg-slate-500 text-white rounded-md flex items-center justify-center gap-3">
                    <i class="fa-solid fa-file-export"></i>
                    Export</a>
            </div>
        </div>

        <hr class="my-3">
        @if ($faceScans->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $faceScans->firstItem() }} - {{ $faceScans->lastItem() }} of {{ $faceScans->total() }} students
        </p>

        <!-- Student List Table -->
        <div class="overflow-x-auto" id="tablePreview2">
            <h1 class="font-semibold text-slate-600 hidden">FACE SCAN ATTENDANCE</h1>
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-2 text-center border">ID No.</th>
                        <th class="py-3 px-2 text-center border">Username</th>
                        <th class="py-3 px-2 text-center border">Name</th>
                        <th class="py-3 px-2 text-center border">Gender</th>
                        <th class="py-3 px-2 text-center border">Grade</th>
                        <th class="py-3 px-2 text-center border">Strand</th>
                        <th class="py-3 px-2 text-center border">Date</th>
                        <th class="py-3 px-2 text-center border">Time-In</th>
                        <th class="py-3 px-2 text-center border">Time-Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faceScans as $list)
                    <tr>

                        <td class="py-2 text-center border">{{ $StudentAccount::where('id', $list->student_id)->first()->id_number }}</td>
                        <td class="py-2 text-center border">{{ $StudentAccount::where('id', $list->student_id)->first()->username }}</td>
                        <td class="py-2 text-center border">{{ $StudentAccount::where('id', $list->student_id)->first()->name }}</td>
                        <td class="py-2 text-center border">{{ $StudentAccount::where('id', $list->student_id)->first()->gender }}</td>
                        <td class="py-2 text-center border">{{ $StudentAccount::where('id', $list->student_id)->first()->grade }}</td>
                        <td class="py-2 text-center border">{{ $StudentAccount::where('id', $list->student_id)->first()->strand }}</td>
                        <td class="py-2 text-center border">{{ $Carbon::parse($list->created_at)->format('Y/m/d') }}</td>
                        <td class="py-2 text-center border">{{ $Carbon::parse($list->time)->format('h:i A') }}</td>
                        <td class="py-2 text-center border">{{ $Carbon::parse($list->time_out)->format('h:i A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Display pagination links -->
        <div class="w-full mb-4 mt-4">
            {{ $faceScans->appends(request()->query())->links() }}
        </div>
        @else
        <p>No records found.</p>
        @endif

    </div>

</div>
@endsection