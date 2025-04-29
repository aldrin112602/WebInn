@extends('admin.layouts.auth')

@section('title', 'Admin Reset Password')

@section('content')
<form action="{{ route('admin.password.otp') }}" method="post" class="w-full max-w-md bg-white  rounded-lg p-8 relative shadow" style="overflow: hidden;">

    <div class="py-1 w-full absolute bg-gradient-to-r from-red-900 via-rose-800 to-red-400" style="top: 0; left: 0;">
    </div>
    <div class="flex items-center justify-between gap-2">
        <img class="w-20" src="{{ asset('images/philtech-logo-transparent.webp') }}" alt="Logo">
        <div class="text-center">
            <h1 class="text-red-900 font-bold">PhilTech Tanay, Inc.</h1>
            <h3 class="text-red-900 font-bold text-sm">Department of Education</h3>
        </div>
        <img class="w-20" src="{{ asset('images/deped-logo.webp') }}" alt="Logo">

    </div>
    @csrf
    <h2 class="text-2xl font-bold mb-6 mt-5 text-rose-900">Forgot Password</h2>
    <p class="text-sm text-gray-400 mb-4">Enter your email for the verification proccess, we will send 4 digits code to your email</p>
    <div class="mb-4">
        <label for="email" class="block text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" class="form-input w-full rounded border-gray-300 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
        @error('email')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <button type="submit" class="w-full bg-rose-900 text-white py-2 rounded hover:bg-rose-700">Continue</button>

        <p class="text-center mt-3 text-slate-500"><a href="{{ route('admin.login') }}" class="text-slate-400 hover:underline text-sm font-semibold">Back to login</a></p>
    </div>
</form>
@endsection
