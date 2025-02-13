@extends('admin.layouts.app')

@section('title', 'Create Subject')
@section('content')
<div class="text-slate-100 p-2 bg-blue-400">Create Subject</div>
<div class="min-w-full flex items-center justify-center p-6" style="min-height: 560px">
    <form action="{{ route('admin.handleCreate.subject', ['teacher_id' => request()->query('teacher_id'), 'grade_handle_id' => request()->query('grade_handle_id')]) }}" method="post" class="w-full max-w-3xl bg-white rounded-lg p-8 shadow">
        @csrf

        <div class="w-full">
            <label for="subject" class="block text-gray-700 mt-2 text-sm mb-1">Subject</label>
            <input type="text" id="subject" name="subject" class="form-input w-full rounded border-gray-300 @error('subject') border-red-500 @enderror" value="{{ old('subject') }}">
            @error('subject')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <div class="w-full">
            <label for="day" class="block text-gray-700 mt-2 text-sm mb-1">Day</label>
            <select name="day" id="day" class="form-select w-full rounded border-gray-300 @error('day') border-red-500 @enderror" value="{{ old('day') }}">
                <option value="" disabled class="hidden" selected> -- Select Day --</option>
                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
            @error('day')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
                <!-- New added field -->
         <div class="w-full">
            <label for="day" class="block text-gray-700 mt-2 text-sm mb-1">Subject Academic Track</label>
            <select name="subject_track" id="subject_track" class="form-select w-full rounded border-gray-300 @error('subject_track') border-red-500 @enderror" value="{{ old('subject_track') }}">
                <option value="" disabled class="hidden" selected> -- Select Type --</option>
                @foreach (['Applied Subject', 'Core Subject', 'Specialized Subject'] as $track)
                    <option value="{{ $track }}">{{ $track }}</option>
                @endforeach
            </select>
            @error('subject_track')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        

        <div class="w-full">
            <label for="time_start" class="block text-gray-700 mt-2 text-sm mb-1">From time:</label>
            <input type="time" id="time_start" name="time_start" class="form-input w-full rounded border-gray-300 @error('time_start') border-red-500 @enderror" value="{{ old('time_start') }}">
            @error('time_start')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <label for="time_end" class="block text-gray-700 mt-2 text-sm mb-1">To time:</label>
            <input type="time" id="time_end" name="time_end" class="form-input w-full rounded border-gray-300 @error('time_end') border-red-500 @enderror" value="{{ old('time_end') }}">
            @error('time_end')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full md:w-40 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Add subject</button>
        </div>
    </form>
</div>
@endsection
