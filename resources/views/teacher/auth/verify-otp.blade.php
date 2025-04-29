@extends('teacher.layouts.auth')
@section('title', 'Verify OTP')
@section('content')
    <form action="{{ route('teacher.verify.otp') }}" method="post"
        class="w-full max-w-md bg-white  rounded-lg p-8 relative shadow" style="overflow: hidden;">

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
        <h2 class="text-2xl font-bold mb-6 text-gray-500">Verification</h2>
        <div class="mb-4">
            <label for="otp" class="block text-gray-700">Enter your 6 digits code on your email.</label>
            <input type="text" id="otp" name="otp"
                class="form-input w-full rounded border-gray-300 @error('otp') border-red-500 @enderror">
            @error('otp')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <button type="submit" class="w-full bg-rose-900 text-white py-2 rounded hover:bg-rose-700">Verify OTP</button>
            <p class="text-center mt-2 text-slate-500">Didn't received code? <a
                    href="{{ route('teacher.password.request') }}" class="text-blue-700 hover:underline">Resend</a></p>
        </div>
    </form>
@endsection
