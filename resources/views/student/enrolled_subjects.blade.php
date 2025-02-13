@extends('student.layouts.app')

@section('title', 'Enrolled Subjects')

@section('content')
<div class="px-6 py-4 bg-white">
    <!-- Student Info -->
    <div class="bg-gradient-to-r from-blue-400 to-blue-500 text-white p-4 rounded-lg mb-4">
        <div class="text-2xl font-bold">
            {{ $user->name }}
        </div>
        <div>{{ $user->strand }} / Grade {{ $user->grade }} - Section {{ $user->section }}</div>
    </div>
    
    <!-- Search and Actions -->
    <div class="mb-4 md:w-1/4 relative">
    <input oninput="w3.filterHTML('#tbl_list', '.tbl_tr', this.value)" type="text" placeholder="Search..." class="p-2 border border-gray-300 rounded w-full">
    <i class="fa fa-search absolute right-3 top-3 pointer-events-none text-gray-500" aria-hidden="true"></i>
    </div>





    <hr class="my-3">
        @if ($enrolled_subjects->count())
        <p class="text-sm text-slate-500 mb-3">
            Showing {{ $enrolled_subjects->firstItem() }} - {{ $enrolled_subjects->lastItem() }} of {{ $enrolled_subjects->total() }} subjects
        </p>

        <!-- Subjects List Table -->
        <div class="overflow-x-auto" id="tablePreview">
            <script>
                $(() => {
                    $('#tbl_list tbody tr').addClass('tbl_tr');
                })
            </script>
            <table id="tbl_list" class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-2 text-center border">Subject</th>
                        <th class="py-3 px-2 text-center border">Teacher</th>
                        <th class="py-3 px-2 text-center border">Day and Time</th>
                        <th class="py-3 px-2 text-center border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrolled_subjects as $list)
                    <tr>
                        <td class="py-2 text-center border">{{ $list->subject }}</td>
                        <td class="py-2 text-center border">{{ $TeacherModel::where('id', $list->teacher_id)->first()->name }}</td>
                        <td class="py-2 text-center border">
                            {{ $list->day }} | {{ $list->time }}
                        </td>

                        <td class="py-2 text-center border">
                        <a href="{{ route('qr.scan.get', [ 'subject_id' => $list->id, 'teacher_id' => $list->teacher_id ]) }}" style="font-size: 13px;" class="bg-blue-500 hover:bg-blue-700 p-2 py-1 rounded text-white">Scan QR</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Display pagination links -->
        <div class="w-full mb-4 mt-4">
            {{ $enrolled_subjects->appends(request()->query())->links() }}
        </div>
        @else
        <p>No subjects available to display.</p>
        @endif



    
    
    
</div>
@endsection
