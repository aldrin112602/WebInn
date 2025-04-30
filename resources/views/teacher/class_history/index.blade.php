@extends('teacher.layouts.app')

@section('title', 'Class Histories')
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
            }

            #tablePreview2 table tr td:last-child,
            #tablePreview2 table tr th:last-child {
                display: none !important;
            }

        }
</style>
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <div>
            <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg mr-2">PRINT</button>
            <a href="{{ route('teacher.export_class_history') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">EXCEL</a>
        </div>
        <div class="relative">
            <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" 
                   placeholder="Search..." 
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <i class="fas fa-search w-5 h-5 text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2"></i>
        </div>
    </div>

    <div class="overflow-x-auto" id="tablePreview2">
        <table id="tbl_list" class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Day</th>
                    <th class="py-3 px-6 text-left">Subject</th>
                    <th class="py-3 px-6 text-left">Teacher</th>
                    <th class="py-3 px-6 text-left">Class time</th>
                    {{-- <th class="py-3 px-6 text-center">Action</th> --}}
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($qrHistory as $history)
                <tr class="border-b tbl_tr border-gray-300 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $history->created_at->format('Y-m-d') }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $history->subjectDetails->day ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $history->subjectDetails->subject ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $user->name ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $history->subjectDetails->time ?? 'N/A' }}
                    </td>
                    {{-- <td class="py-3 px-6 text-center">
                        <a href="{{ route('teacher.view_class_history', $history->subjectDetails->id ?? 1) }}" class="bg-blue-500 text-white py-1 px-3 rounded-full text-xs">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection