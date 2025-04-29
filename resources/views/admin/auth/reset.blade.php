@extends('admin.layouts.auth')

@section('title', 'Admin Reset Password')

@section('content')
<form action="{{ route('admin.password.update') }}" method="post" class="w-full max-w-md bg-white  rounded-lg p-8 relative shadow" style="overflow: hidden;">

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

    <h2 class="text-2xl font-bold mb-6 mt-5 text-rose-900">New Password</h2>
    <p class="text-sm text-gray-400 mb-4">Set the new password for your account so you can login and access all features</p>
    <div class="mb-4">
        <label for="password" class="block text-gray-700">Enter New Password</label>
        <input value="{{ old('password') }}" type="password" id="password" name="password" class="form-input w-full rounded border-gray-300 @error('password') border-red-500 @enderror">
        @error('password')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-4">
        <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
        <input value="{{ old('password_confirmation') }}" type="password" id="password_confirmation" name="password_confirmation" class="form-input w-full rounded border-gray-300 @error('password_confirmation') border-red-500 @enderror">
        @error('password_confirmation')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <button type="submit" class="w-full bg-rose-900 text-white py-2 rounded hover:bg-rose-700">Update Password</button>

        <p class="text-center mt-3 text-slate-500"><a href="{{ route('admin.login') }}" class="text-slate-400 hover:underline text-sm font-semibold">Back to login</a></p>
    </div>
</form>
@endsection
