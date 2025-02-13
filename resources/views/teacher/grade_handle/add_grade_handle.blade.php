@extends('teacher.layouts.app')

@section('title', 'Add Grade Handle')
@section('content')
<div class="text-slate-100 p-2 bg-blue-400">Add Grade Handle</div>
<div class="min-w-full flex items-center justify-center p-6" style="min-height: 560px">
    <form action="{{ route('teacher.submit.add_grade_handle') }}" method="post" class="w-full max-w-3xl bg-white rounded-lg p-8 shadow">
        @csrf
        <div class="block md:flex align-center justify-between my-2 gap-5">
            <div class="md:w-1/2 w-full">
                <label for="grade" class="block text-gray-700 text-sm mb-1">Grade</label>
                <select name="grade" id="grade" class="form-select w-full rounded border-gray-300 @error('grade') border-red-500 @enderror">
                    <option value="" selected disabled class="hidden">-- Select one --</option>
                    <option value="11" {{ old('grade') == '11' ? 'selected' : null }}>Grade 11</option>
                    <option value="12" {{ old('grade') == '12' ? 'selected' : null }}>Grade 12</option>
                </select>
                @error('grade')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="md:w-1/2 w-full">
                <label for="strand" class="block text-gray-700 text-sm mb-1">strand</label>
                <select name="strand" id="strand" class="form-select w-full rounded border-gray-300 @error('strand') border-red-500 @enderror">
                    <option value="" selected disabled class="hidden">-- Select one --</option>
                    <option value="ABM" {{ old('strand') == 'ABM' ? 'selected' : null }}>ABM</option>
                    <option value="ICT" {{ old('strand') == 'ICT' ? 'selected' : null }}>ICT</option>
                    <option value="HE" {{ old('strand') == 'HE' ? 'selected' : null }}>HE</option>
                    <option value="HUMSS" {{ old('strand') == 'HUMSS' ? 'selected' : null }}>HUMSS</option>
                </select>
                @error('strand')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

        </div>


        <div class="w-full">
            <label for="section" class="block text-gray-700 text-sm mb-1">section</label>
            <select name="section" id="section" class="form-select w-full rounded border-gray-300 @error('section') border-red-500 @enderror">
                <option value="" selected disabled class="hidden">-- Select one --</option>
                <option value="A" {{ old('section') == 'A' ? 'selected' : null }}>A</option>
                <option value="B" {{ old('section') == 'B' ? 'selected' : null }}>B</option>
                <option value="C" {{ old('section') == 'C' ? 'selected' : null }}>C</option>
                <option value="D" {{ old('section') == 'D' ? 'selected' : null }}>D</option>
                <option value="E" {{ old('section') == 'E' ? 'selected' : null }}>E</option>
            </select>
            @error('section')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full md:w-40 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Submit</button>
        </div>
    </form>
</div>
@endsection