@extends('guidance.layouts.auth')
@section('title', 'Verify OTP')
@section('content')
<form action="{{ route('guidance.verify.otp') }}" method="post" class="w-full max-w-md bg-white rounded-lg p-8 mx-auto mt-10">
    @csrf
    <h2 class="text-2xl font-bold mb-6 text-gray-500">Verification</h2>
    <div class="mb-4">
        <label for="otp" class="block text-gray-700">Enter your 6 digits code on your email.</label>
        <input type="text" id="otp" name="otp" class="form-input w-full rounded border-gray-300 @error('otp') border-red-500 @enderror">
        @error('otp')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Verify OTP</button>
        <p class="text-center mt-2 text-slate-500">Didn't received code? <a href="{{ route('guidance.password.request') }}" class="text-blue-700 hover:underline">Resend</a></p>
    </div>
</form>
@endsection
