<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <!-- <script src="{{ asset('build/assets/app.js') }}" defer></script> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Face Recognition</title>
    <script src="{{ asset('face_api/face-api.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery.min.js') }}"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="  {{ asset('js/sweetalert2@11.js') }}"></script>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/face-scan.min.css') }}">
</head>

<body class="flex items-center justify-center h-screen">
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p class="mt-2">Initializing face recognition system...</p>
        </div>
    </div>

    <div class="w-full lg:w-3/4 xl:w-2/3 flex flex-col lg:flex-row items-center space-y-8 lg:space-y-0 lg:space-x-8 bg-white p-6 shadow-lg rounded-lg">
        <div class="text-center flex flex-col items-center">
            <p class="font-bold text-lg mb-2">FACE VERIFICATION</p>
            <div class="relative w-full max-w-md">
                <div id="instruction" class="instruction">Please look at the camera</div>
                <video id="video" class="w-full h-auto bg-blue-100" autoplay muted></video>
                <canvas id="overlay" class="absolute top-0 left-0 w-full h-full"></canvas>
            </div>
            <div class="progress-container">
                <div class="progress-bar" id="progress-bar"></div>
            </div>

            <!-- Time In/Out Toggle Switch -->
            <div class="mt-4 flex items-center justify-center space-x-2">
                <span class="text-sm font-medium">Time Out</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="timeToggle" checked>
                    <span class="toggle-slider"></span>
                </label>
                <span class="text-sm font-medium">Time In</span>
            </div>

            <button id="resetButton" class="mt-4 bg-black text-white py-2 px-6 rounded cursor-pointer">Reset</button>
        </div>
        <div class="w-full lg:w-1/2 p-4 border rounded-lg bg-gray-100 flex flex-col space-y-2 h-full mb-60">
            <div class="flex justify-between items-center">
                <span class="font-bold">Student's Name:</span>
                <span id="student-name" class="ml-2">N/A</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Strand:</span>
                <span id="student-strand" class="ml-2">N/A</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Gender:</span>
                <span id="student-gender"  class="ml-2">N/A</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">ID No.:</span>
                <span id="student-id" class="ml-2">N/A</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Time <span id="time-type">In</span>:</span>
                <span id="time-in" class="ml-2">N/A</span>
            </div>
        </div>
    </div>
    <!-- face recognition js -->
    <script src="{{ asset('js/face-recognition.min.js') }}"></script>
</body>

</html>