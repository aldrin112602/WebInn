@extends('teacher.layouts.app')

@section('title', 'View Subjects')
@section('content')
<div class="text-slate-100 p-2 bg-blue-400">Student Subjects</div>
<div class="min-w-full p-6 bg-white" style="min-height: 560px">
    <hr class="my-2">
    <h2 class="text-xl font-bold mb-4 text-slate-600">Add Subject</h2>
    <form id="add-subject-form" method="POST" action="{{ route('teacher.add.subject') }}?id={{request()->query('id')}}" class="block md:flex items-center justify-between gap-2">
        @csrf
        <div>
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            <select required name="subject" id="subject" class="text-sm form-select rounded-lg w-full md:w-60">
                <option value="" selected disabled class="hidden">-- Select subject --</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->subject }} / Teacher: {{ $subject->teacherAccount->name ?? 'N/A' }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-sm hover:bg-blue-700 text-white py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline "><i class="fas fa-plus"></i> &nbsp;Subject</button>
        </div>
        <a href="{{ route('teacher.create.subject', ['id' => request()->query('id'), 'student_id' => $student->id ]) }}" class="bg-purple-900 text-sm hover:bg-purple-500 text-white py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline "><i class="fas fa-plus"></i> &nbsp;Create new subject</a>
    </form>

    <hr class="my-4">

    <h2 class="text-xl mb-2 text-slate-700 font-semibold mt-6">Subject List of {{ $student->name }}</h2>

    @if ($student->subjects->count())
    <table class="min-w-full bg-white rounded-lg">
        <thead>
            <tr>
                <th class="text-left p-3 border-b border-gray-200">Strand</th>
                <th class="text-left p-3 border-b border-gray-200">Section</th>
                <th class="text-left p-3 border-b border-gray-200">Teacher</th>
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