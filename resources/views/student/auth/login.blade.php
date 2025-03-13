@extends('student.layouts.auth')

@section('title', 'Student Login')
@section('content')

    <form action="{{ route('student.handleLogin') }}" method="post"
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

        <h2 class="text-2xl mt-5 font-bold text-center mb-6 text-red-900">Student Login</h2>
        <div class="mb-4">
            <label for="username" class="block text-red-900">Username</label>
            <input type="text" id="username" name="username"
                class="form-input focus:border-red-400 outline-none w-full rounded border-gray-300 @error('username') border-red-500 @enderror"
                value="{{ old('username') }}">
            @error('username')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-red-900">Password</label>
            <div class="relative w-full">
                <input type="password" id="password" name="password"
                    class="form-input focus:border-red-400 outline-none w-full rounded border-gray-300 @error('password') border-red-500 @enderror"
                    value="{{ old('password') }}">
                <span toggle="#password"
                    class="fa fa-fw fa-eye field-icon toggle-password absolute top-1/2 right-2 transform-translate-y-1/2 cursor-pointer text-gray-600 text-sm mr-2"
                    style="transform: translateY(-47%);"></span>
            </div>

            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember"
                    class="form-checkbox rounded focus:border-red-400 outline-none">
                <label for="remember" class="ml-2 text-red-900 text-sm">Remember Me</label>
            </div>
            <a href="{{ route('student.password.request') }}"
                class="text-sm text-red-700 hover:underline font-semibold">Forgot Password?</a>
        </div>


        <!-- Terms and Conditions checkbox and trigger -->
        <div class="mb-4">
            <input type="checkbox" id="agreeTerms" name="agreeTerms"
                class="form-checkbox rounded focus:border-red-400 outline-none">
            <label for="agreeTerms" class="ml-2 text-red-900 text-sm">
                I agree with the <a href="#" class="text-red-700 hover:underline" id="termsTrigger">terms and
                    conditions</a>.
            </label>
        </div>

        <div>
            <button type="submit" id="loginButton" class="w-full py-2 rounded bg-rose-50" disabled>Log In</button>
        </div>
    </form>

@endsection