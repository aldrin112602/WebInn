<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}" defer></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>WebInn - Revolutionizing Education</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    
     <!-- Meta Description -->
    <meta name="description" content="WebInn is transforming education with innovative features like face recognition attendance, QR code-based attendance, email notifications, and an Excel-like grading sheet. Tailored for 4 user levels: Admin, Guidance, Student, and Teacher.">

    <!-- Meta Keywords -->
    <meta name="keywords" content="WebInn, myWebInn, MyWebInn, Education Technology, Face Recognition Attendance, QR Code Attendance, Email Notifications, Grading Sheet, Admin Portal, Guidance Portal, Teacher Portal, Student Portal, Revolutionizing Education">

    <!-- Author -->
    <meta name="author" content="Aldrin Caballero">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://myWebInn.com">

    @vite('resources/css/app.css')

    <!-- <link rel="manifest" href="{{ asset('manifest.json') }}"> -->
</head>

<body class="antialiased text-gray-900">

    <header class="relative bg-blue-500 text-white bg-cover bg-center" style="background-image: url('{{ asset('images/admin_auth_bg.jpg') }}');">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-slate-900 opacity-90"></div>

        <div class="container relative z-10 mx-auto flex flex-col items-center justify-center min-h-screen px-4 text-center space-y-6">
            <!-- Main Title -->
            <h1 class="text-4xl md:text-6xl font-extrabold mb-2 tracking-wide">Welcome to WebInn</h1>

            <!-- Subheading -->
            <p class="text-xl md:text-2xl max-w-2xl mx-auto font-medium">
                Revolutionizing education with smart solutions for students, teachers, and institutions. <br> Empowering success through technology.
            </p>

            <!-- Call to Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-6">
                <a href="#features" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-200 transition">
                    Discover More
                </a>
                <!-- Update Get Started button to trigger jQuery modal -->
                <button id="getStartedBtn" class="bg-transparent border border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition">
                    Get Started
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div id="roleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6 relative">
                <!-- Close Button -->
                <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-2xl font-semibold text-slate-900 mb-6 text-center">Choose Your Role</h2>
                <div class="space-y-4">
                    <a href="{{ route('student.login') }}" class="block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-center">Login as Student</a>
                    <a href="{{ route('teacher.login') }}" class="block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-center">Login as Teacher</a>
                    <a href="{{ route('guidance.login') }}" class="block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-center">Login as Guidance Counselor</a>
                    <a href="{{ route('admin.login') }}" class="block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-center">Login as Admin</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12">Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Admin Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 010 6.844L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7m0 0l-3-3m3 3l3-3" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Comprehensive User Roles</h3>
                    <p class="text-gray-600">Manage roles for Admin, Teacher, Student, and Guidance counselors with distinct permissions.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Face Recognition Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405a2.032 2.032 0 00-.595-2.646l-3.54-2.12a2.032 2.032 0 00-2.646.595L8.405 14H3v6h6m6 0v-2a4 4 0 10-8 0v2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Face Recognition Attendance</h3>
                    <p class="text-gray-600">Automate student attendance at the main gate using advanced face recognition technology.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Grading System Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2v-5m-5-4l5-5m0 0l-5 5m5-5V12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Grading System</h3>
                    <p class="text-gray-600">Efficiently grade and track student performance across various subjects with our intuitive grading system.</p>
                </div>
                <!-- Feature 4 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- QR Code Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8H3c-4.418 0-8-3.582-8-8S-1.582 4 3 4h10c4.418 0 8 3.582 8 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">QR Code Attendance</h3>
                    <p class="text-gray-600">Enable attendance tracking per subject using QR codes and scanners for streamlined record-keeping.</p>
                </div>
                <!-- Feature 5 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Security Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.45 0 .85.05 1.25.15M12 11a5 5 0 015 5v2a5 5 0 01-5 5 5 5 0 01-5-5v-2a5 5 0 015-5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure & Reliable</h3>
                    <p class="text-gray-600">Ensure data security and reliability with WebInn's robust security measures.</p>
                </div>
                <!-- Feature 6 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Customizable Dashboard Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Customizable Dashboard</h3>
                    <p class="text-gray-600">Personalize your dashboard to access the tools and information you need quickly and efficiently.</p>
                </div>
            </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12">User Roles</h2>
            <div class="flex flex-wrap -mx-4">
                <!-- Admin -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Admin Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 010 6.844L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7m0 0l-3-3m3 3l3-3" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Admin</h3>
                        <p class="text-gray-600">Oversee all operations, manage users, and configure system settings.</p>
                    </div>
                </div>
                <!-- Teacher -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Teacher Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Teacher</h3>
                        <p class="text-gray-600">Create and manage courses, grade assignments, and track student progress.</p>
                    </div>
                </div>
                <!-- Student -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Student Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20v-2c0-2.21 3.582-4 6-4s6 1.79 6 4v2H6z" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Student</h3>
                        <p class="text-gray-600">Access courses, submit assignments, and monitor personal academic performance.</p>
                    </div>
                </div>
                <!-- Guidance -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Guidance Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14l4-4 4 4m0 0v6m0-6H8" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Guidance</h3>
                        <p class="text-gray-600">Provide academic and career counseling, and support student well-being.</p>
                    </div>
                </div>
            </div>
    </section>

    <!-- Advanced Features Section -->
    <section id="advanced-features" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12">Advanced Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Face Recognition -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- Face Recognition Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405a2.032 2.032 0 00-.595-2.646l-3.54-2.12a2.032 2.032 0 00-2.646.595L8.405 14H3v6h6m6 0v-2a4 4 0 10-8 0v2" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Face Recognition for Attendance</h3>
                    <p class="text-gray-600">Utilize cutting-edge face recognition technology to automate and secure student attendance at entry points.</p>
                </div>
                <!-- QR Code Attendance -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- QR Code Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8M8 8h8M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">QR Code-Based Attendance</h3>
                    <p class="text-gray-600">Implement subject-specific QR codes and scanners to efficiently track attendance and participation.</p>
                </div>
                <!-- Additional Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- Analytics Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Comprehensive Analytics</h3>
                    <p class="text-gray-600">Gain insights into student performance and system usage with detailed analytics and reporting tools.</p>
                </div>
                <!-- Additional Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- Mobile-Friendly Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4h2a2 2 0 012 2v12a2 2 0 01-2 2h-2m-8-8h.01M12 16h.01" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Mobile-Friendly Interface</h3>
                    <p class="text-gray-600">Access WebInn on any device with our responsive and mobile-optimized design.</p>
                </div>
            </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-semibold mb-4">Join WebInn Today!</h2>
            <p class="text-lg mb-8">Experience a smarter way to manage education. Whether you're an admin, teacher, student, or guidance counselor, WebInn has the tools you need.</p>
            <a href="#" id="getStartedBtnFooter" class="bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition">Get Started Now</a>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} WebInn. All rights reserved.</p>
            <div class="mt-4">
                <a href="#" class="text-gray-400 hover:text-white mx-2">
                    <!-- Facebook Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.675 0h-21.35C.597 0 0 .597 0 1.325v21.351C0 23.403.597 24 1.325 24h11.495v-9.294H9.691v-3.622h3.129V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.466.099 2.797.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.31h3.587l-.467 3.622h-3.12V24h6.116C23.403 24 24 23.403 24 22.675V1.325C24 .597 23.403 0 22.675 0z" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white mx-2">
                    <!-- Twitter Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 4.557a9.93 9.93 0 01-2.828.775A4.932 4.932 0 0023.337 3.1a9.864 9.864 0 01-3.127 1.195 4.916 4.916 0 00-8.384 4.482A13.94 13.94 0 011.671 3.149a4.916 4.916 0 001.523 6.574A4.897 4.897 0 01.964 9.1v.062a4.916 4.916 0 003.946 4.817 4.902 4.902 0 01-2.212.084 4.918 4.918 0 004.588 3.417A9.867 9.867 0 010 19.54a13.94 13.94 0 007.548 2.212c9.057 0 14.01-7.514 14.01-14.009 0-.213-.005-.425-.014-.636A10.012 10.012 0 0024 4.557z" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white mx-2">
                    <!-- LinkedIn Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.75-.784-1.75-1.75s.784-1.75 1.75-1.75 1.75.784 1.75 1.75-.784 1.75-1.75 1.75zm13.5 11.268h-3v-5.604c0-1.337-.026-3.063-1.872-3.063-1.874 0-2.16 1.46-2.16 2.96v5.7h-3v-10h2.88v1.367h.041c.401-.76 1.38-1.56 2.84-1.56 3.04 0 3.6 2.0 3.6 4.6v5.6z" />
                    </svg>
                </a>
                <!-- Add more social icons as needed -->
            </div>
        </div>
    </footer>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom jQuery Script for Modal -->
    <script>
        $(document).ready(function () {
            // Function to open modal
            function openModal() {
                $('#roleModal').fadeIn(300);
            }

            // Function to close modal
            function closeModal() {
                $('#roleModal').fadeOut(300);
            }

            // Open modal when "Get Started" button is clicked
            $('#getStartedBtn, #getStartedBtnFooter').on('click', function (e) {
                e.preventDefault();
                openModal();
            });

            // Close modal when close button is clicked
            $('#closeModal').on('click', function () {
                closeModal();
            });

            // Close modal when clicking outside the modal content
            $('#roleModal').on('click', function (e) {
                if ($(e.target).is('#roleModal')) {
                    closeModal();
                }
            });

            // Optional: Close modal with Esc key
            $(document).on('keydown', function (e) {
                if (e.key === "Escape") {
                    closeModal();
                }
            });
        });
    </script>
    <script>
        // if ('serviceWorker' in navigator) {
        //     navigator.serviceWorker.register('{{ asset("service-worker.js") }}').then(function(registration) {
        //         console.log('Service Worker registered with scope:', registration.scope);
        //     }).catch(function(error) {
        //         console.log('Service Worker registration failed:', error);
        //     });
        // }
    </script>
</body>

</html>
