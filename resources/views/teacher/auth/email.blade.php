@extends('teacher.layouts.auth')

@section('title', 'Teacher Reset Password')

@section('content')
<form action="{{ route('teacher.password.otp') }}" method="post" class="w-full max-w-md bg-white rounded-lg p-8">
    @csrf
    <h2 class="text-2xl font-bold mb-6">Forgot Password</h2>
    <p class="text-sm text-gray-400 mb-4">Enter your email for the verification proccess, we will send 4 digits code to your email</p>
    <div class="mb-4">
        <label for="email" class="block text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" class="form-input w-full rounded border-gray-300 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
        @error('email')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Continue</button>

        <p class="text-center mt-3 text-slate-500"><a href="{{ route('teacher.login') }}" class="text-slate-400 hover:underline text-sm font-semibold">Back to login</a></p>
    </div>
</form>
@endsection
