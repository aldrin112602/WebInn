@extends('student.layouts.app')

@section('title', 'Grades')

@section('content')

<style>
    @media print {
        #tbl {
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            height: 100vh;
            background-color: white;
        }
    }
</style>
<div class="max-w-7xl mx-auto p-6 bg-white shadow-md">

    <!-- Search and Actions -->
    <div class="flex justify-between items-center mb-4">
        <div class="relative">
            <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search" class="form-input pl-4 pr-10 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute pointer-events-none right-5 top-3 text-slate-500"></i>
        </div>
        <div>
            <a class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-md mr-2" onclick="window.print()">PRINT</a>
            <a href="{{ route('student.download_grade', $student->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">DOWNLOAD GRADE</a>
        </div>
    </div>

    @if ($grades->isEmpty())
    <div class="text-center p-10 bg-white">
        <p>
            No grades found, nothing to display at the moment.
        </p>
    </div>
    @else
    <!-- Grades Table -->
    <h1 class="text-lg my-3 font-semibold">{{ $student->name }} / {{ $student->grade }} / {{ $student->strand }} / {{ $student->section }}</h1>
    <div class="overflow-x-auto" id="tbl">
        <table class="min-w-full bg-white border border-gray-300" id="tbl_list">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 border-b border-gray-300">Subject</th>
                    <th class="text-left px-6 py-3 border-b border-gray-300">Semester</th>
                    <th class="text-left px-6 py-3 border-b border-gray-300">Quarter</th>
                    <th class="text-left px-6 py-3 border-b border-gray-300">Quarterly Grade</th>
                    <th class="text-left px-6 py-3 border-b border-gray-300">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grades as $grade)
                <tr class="tbl_tr">
                    <td class="px-6 py-4 border-b border-gray-300">{{ $grade->subject }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ $grade->semester }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ $grade->quarter }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ $grade->quarterly_grade }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ (int)$grade->quarterly_grade < 75 ? 'Failed' : 'Passed' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection