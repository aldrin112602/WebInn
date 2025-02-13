@extends('admin.layouts.app')

@section('title', 'View Subjects')
@section('content')
<div class="text-slate-100 p-2 bg-blue-400">Create Subject</div>
<div class="min-w-full p-6" style="min-height: 560px">
    <h2 class="text-2xl font-bold mb-4 text-slate-600">Add Subject</h2>
    <form id="add-subject-form" method="POST" action="{{ route('admin.add.subject') }}" class="block md:flex items-center justify-start gap-2">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="teacher_id" id="teacher_id">
        <input type="hidden" name="grade_handle_id" id="grade_handle_id">
        <div>
            <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
            <select name="subject" id="subject" class="form-select rounded-lg w-full md:w-60">
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" data-teacher-id="{{ $subject->teacher_id }}" data-grade-handle-id="{{ $subject->grade_handle_id }}">{{ $subject->teacherAccount->name ?? 'N/A' }} / {{ $TeacherGradeHandle::where('id', $subject->grade_handle_id)->first()->grade ?? 'N/A'}} - {{ $TeacherGradeHandle::where('id', $subject->grade_handle_id)->first()->strand ?? 'N/A'}} ({{ $TeacherGradeHandle::where('id', $subject->grade_handle_id)->first()->section ?? 'N/A'}})</option>
                @endforeach
            </select>

            <script>
                $('#subject').on('change', function(e) {
                    $('#teacher_id').val($(this).find('option:selected').data('teacher-id'));
                    $('#grade_handle_id').val($(this).find('option:selected').data('grade-handle-id'));
                    
                })
            </script>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline mt-2 md:mt-7"><i class="fas fa-plus"></i> &nbsp;Subject</button>
    </form>

    <h2 class="text-xl mb-2 text-slate-700 font-semibold mt-6">Subject List of {{ $student->name }}</h2>

    @if ($student->subjects->count())
    <table class="min-w-full bg-white rounded-lg">
        <thead>
            <tr>
                <th class="text-left p-3 border-b border-gray-200">Strand</th>
                <th class="text-left p-3 border-b border-gray-200">Section</th>
                <th class="text-left p-3 border-b border-gray-200">Teacher</th>
                <th class="text-left p-3 border-b border-gray-200">Grade Handle</th>
                <th class="text-left p-3 border-b border-gray-200">Subject</th>
                <th class="text-left p-3 border-b border-gray-200">Time</th>
                <th class="text-left p-3 border-b border-gray-200">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->subjects as $subject)
            <tr>
                <td class="text-left p-3 border-b border-gray-200">{{ $student->strand ?? 'N/A' }}</td>
                <td class="text-left p-3 border-b border-gray-200">{{ $student->section ?? 'N/A' }}</td>
                <td class="text-left p-3 border-b border-gray-200">{{ $subject->teacherAccount->name ?? 'N/A' }}</td>
                <td class="text-left p-3 border-b border-gray-200">
                {{ $TeacherGradeHandle::where('id', $subject->grade_handle_id)->first()->grade ?? 'N/A'}} - {{ $TeacherGradeHandle::where('id', $subject->grade_handle_id)->first()->strand ?? 'N/A'}} ({{ $TeacherGradeHandle::where('id', $subject->grade_handle_id)->first()->section ?? 'N/A'}})
                </td>
                <td class="text-left p-3 border-b border-gray-200">{{ $subject->subject }}</td>
                <td class="text-left p-3 border-b border-gray-200">{{ $subject->time }}</td>
                <td class="text-left p-3 border-b border-gray-200">
                    <button onclick="confirmDeleteSubject({{ $subject->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md">Delete</button>
                    <form id="delete-form-{{ $subject->id }}" action="{{ route('admin.delete.studentSubject', [$student->id, $subject->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display pagination links -->
    <div class="w-full mb-4 mt-4">
        {{ $subjects->links() }}
    </div>
    @else
    <p>No records found.</p>
    @endif
</div>

<script>
    function confirmDeleteSubject(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
