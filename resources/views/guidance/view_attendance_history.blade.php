@extends('guidance.layouts.app')

@section('title', 'Attendance History')
@section('custom_css')
<style>
    @media print {
        #tablePreview {
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            z-index: 100;
            width: 100vw;
            height: 100vh;
        }

    }
</style>
@endsection
@section('content')
<div class="p-4 bg-white">

    <div class="flex justify-between items-center mb-4">

        <div>
            <button onclick="window.print()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-400">Print</button>
            <a href="{{ route('guidance.export_attendance_history', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Excel</a>
        </div>
        <div class="relative">
            <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search" class="w-full p-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute top-3 right-3 text-slate-500"></i>
        </div>
    </div>




    <hr class="my-3">


    <!-- Attendance Table -->
    <div class="overflow-x-auto" id="tablePreview">
        <h2 class="text-2xl font-bold text-gray-700 my-4">
            {{ $student->name }} Attendance History
        </h2>
        
        @if ($attendace_histories->isEmpty())
        <div class="text-center p-10 bg-white">
            <p>
                No history found, nothing to display at the moment.
            </p>
        </div>
        @else
        <table id="tbl_list" class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-600 text-white uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Day</th>
                    <th class="py-3 px-6 text-left">Subject</th>
                    <th class="py-3 px-6 text-left">Teacher</th>
                    <th class="py-3 px-6 text-left">Time</th>
                    <th class="py-3 px-6 text-left">Time-In</th>
                    <th class="py-3 px-6 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm font-light">

                @foreach ($attendace_histories as $history)
                <tr class="border-b border-gray-200 hover:bg-gray-100 tbl_tr">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $history->date }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $SubjectModel::where('id', $history->subject_model_id)->first()->day }}
                    </td>
                    <td class="py-3 px-6 text-left flex items-center gap-2">
                        <i class="fa-regular fa-note-sticky"></i>
                        {{ $SubjectModel::where('id', $history->subject_model_id)->first()->subject }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $TeacherAccount::where('id', $history->teacher_id)->first()->name }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $SubjectModel::where('id', $history->subject_model_id)->first()->time }}
                    </td>

                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $history->time_in }}
                    </td>


                    <td class="py-3 px-6 text-left {{ (trim($history->status) == 'Present') ? 'text-green-700 bg-green-50': ((trim($history->status) == 'Absent') ? 'text-rose-700 bg-rose-50' : 'text-gray-800 bg-gray-50') }}">{{ trim($history->status) }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection