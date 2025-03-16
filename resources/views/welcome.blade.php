<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('js/scrollreveal.min.js') }}"></script>
    <script>
        ScrollReveal({ reset: true });
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Meta Title -->
    <title>WebInn | Smart Education with Face Recognition & QR Attendance</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- Search Engine Optimization by Aldrin Caballero -->
    <!-- Profile Link (XFN - Social Relationships) -->
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- Meta Description -->
    <meta name="description"
        content="WebInn is revolutionizing education with Face Recognition & QR Code Attendance, Email Notifications, and an Excel-like Grading System for Admins, Teachers, Students, and Guidance Counselors.">

    <!-- Robots Meta Tag -->
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://aquamarine-fish-440283.hostingersite.com/">

    <!-- Meta Keywords (Less Important for SEO, but Helpful) -->
    <meta name="keywords"
        content="WebInn, Education Technology, Face Recognition Attendance, QR Code Attendance, School Management System, Smart Grading, Student Portal, Teacher Portal, Admin Portal">

    <!-- Author -->
    <meta name="author" content="Aldrin Caballero">

    <!-- Open Graph Meta Tags (for Facebook, LinkedIn) -->
    <meta property="og:title" content="WebInn | Smart Education with Face Recognition & QR Attendance">
    <meta property="og:description"
        content="WebInn is revolutionizing education with Face Recognition & QR Code Attendance, Email Notifications, and an Excel-like Grading System.">
    <meta property="og:image" content="{{ asset('images/philtech-logo-transparent.webp') }}">
    <meta property="og:url" content="https://aquamarine-fish-440283.hostingersite.com/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="WebInn">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="WebInn | Smart Education with Face Recognition & QR Attendance">
    <meta name="twitter:description"
        content="WebInn is transforming education with advanced technology like Face Recognition & QR Code Attendance.">
    <meta name="twitter:image" content="{{ asset('images/philtech-logo-transparent.webp') }}">

    <link rel="icon" type="image/png" href="{{ asset('images/philtech-logo-transparent.webp') }}">

    @vite('resources/css/app.css')

    <style>
        .custom-bg {
            background: linear-gradient(27deg, rgba(166, 7, 7, 0.7875525210084033) 1%, rgba(84, 11, 11, 1) 31%, rgba(222, 167, 167, 0.8603816526610644) 100%);
        }

        .bg-active-nav {
            background: rgb(240, 211, 211);
            background: linear-gradient(27deg, rgba(240, 211, 211, 0.7875525210084033) 1%, rgba(84, 11, 11, 1) 42%, rgba(242, 91, 91, 0.8603816526610644) 100%);
            color: white;
            transition: all .8s;
        }
    </style>
</head>

<body class="antialiased text-gray-900 transition-all">
    <nav class="fixed top-0 left-0 w-full bg-red-50 transition-all text-black py-2 shadow-md z-50">
        <section class="flex items-center justify-between px-5">
            <img src="{{ asset('images/philtech-logo-transparent.webp') }}" alt="PhilTech Tanay Logo" width="70px">

            <!-- Hamburger Button -->
            <button id="menu-toggle" class="md:hidden focus:outline-none">
                <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Desktop Navigation -->
            <ul class="hidden md:flex justify-center space-x-6">
                <li><a href="#home" class="hover:bg-red-700 hover:text-white px-4 py-2 rounded">Home</a></li>
                <li><a href="#features" class="hover:bg-red-700 hover:text-white px-4 py-2 rounded">Key Features</a>
                </li>
                <li><a href="#roles" class="hover:bg-red-700 hover:text-white px-4 py-2 rounded">User Roles</a></li>
                <li><a target="_blank" href="{{ route('face.recognition') }}"
                        class="hover:bg-red-700 hover:text-white px-4 py-2 rounded">Face Recognition</a></li>
                <li><a href="#about" class="hover:bg-red-700 hover:text-white px-4 py-2 rounded">About Us</a></li>
            </ul>
        </section>

        <!-- Mobile Navigation -->
        <ul id="mobile-menu" class="hidden flex flex-col items-center bg-red-50 md:hidden py-4 space-y-4 shadow-md">
            <li><a href="#home" class="block px-4 py-2 text-black hover:bg-red-700 hover:text-white">Home</a></li>
            <li><a href="#features" class="block px-4 py-2 text-black hover:bg-red-700 hover:text-white">Key
                    Features</a></li>
            <li><a href="#roles" class="block px-4 py-2 text-black hover:bg-red-700 hover:text-white">User Roles</a>
            </li>
            <li><a target="_blank" href="{{ route('face.recognition') }}"
                    class="block px-4 py-2 text-black hover:bg-red-700 hover:text-white">Face Recognition</a></li>
            <li><a href="#about" class="block px-4 py-2 text-black hover:bg-red-700 hover:text-white">About Us</a></li>
        </ul>
    </nav>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    <header id="home" class="relative text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/admin-auth-bg.webp') }}');">
        <!-- Dark Overlay -->
        <section class="absolute inset-0 bg-active-nav opacity-60"></section>

        <div
            class=" relative z-10 mx-auto flex flex-col items-center justify-center min-h-screen px-4 text-center space-y-6 backdrop-blur w-full">
            <!-- Main Title -->
            <h1 class="text-4xl md:text-6xl font-extrabold mb-2 tracking-wide">Welcome to WebInn</h1>

            <!-- Subheading -->
            <p class="text-xl md:text-2xl max-w-2xl mx-auto font-medium">
                Revolutionizing education with smart solutions for students, teachers, and institutions. <br> Empowering
                success through technology.
            </p>

            <!-- Call to Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-6">
                <a href="#features"
                    class="bg-white text-red-900 px-8 py-4 rounded-full font-semibold hover:bg-gray-200 transition">
                    Discover More

                </a>
                <button id="getStartedBtn"
                    class="bg-transparent border border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-red-900 transition">
                    Get Started
                </button>
            </div>
        </div>


        <!-- Modal -->
        <section id="roleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style="display: none;">
            <section class="bg-white text-red-900 rounded-lg shadow-lg w-11/12 max-w-md p-6 relative">
                <!-- Close Button -->
                <button id="closeModal" class="absolute top-3 right-3 text-red-900 hover:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-2xl font-semibold text-center mb-6">Choose Your Role</h2>
                <section class="space-y-4">
                    <a href="{{ route('student.login') }}"
                        class="block bg-gradient-to-r from-red-700 to-red-500 text-white px-4 py-2 rounded hover:from-red-600 hover:to-red-400 text-center">Login
                        as Student</a>
                    <a href="{{ route('teacher.login') }}"
                        class="block bg-gradient-to-r from-green-700 to-green-500 text-white px-4 py-2 rounded hover:from-green-600 hover:to-green-400 text-center">Login
                        as Teacher</a>
                    {{-- <a href="{{ route('guidance.login') }}"
                        class="block bg-gradient-to-r from-yellow-700 to-yellow-500 text-white px-4 py-2 rounded hover:from-yellow-600 hover:to-yellow-400 text-center">Login
                        as Guidance Counselor</a> --}}
                    <a href="{{ route('admin.login') }}"
                        class="block bg-gradient-to-r from-gray-800 to-gray-600 text-white px-4 py-2 rounded hover:from-gray-700 hover:to-gray-500 text-center">Login
                        as Admin</a>

                </section>
            </section>
        </section>

    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12 text-red-900">Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Admin Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 010 6.844L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14v7m0 0l-3-3m3 3l3-3" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-red-900">Comprehensive User Roles</h3>
                    <p>Manage roles for Admin, Teacher, Student, and Guidance counselors with distinct permissions.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Face Recognition Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405a2.032 2.032 0 00-.595-2.646l-3.54-2.12a2.032 2.032 0 00-2.646.595L8.405 14H3v6h6m6 0v-2a4 4 0 10-8 0v2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Face Recognition Attendance</h3>
                    <p class="text-gray-600">Automate student attendance at the main gate using advanced face
                        recognition technology.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Grading System Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2v-5m-5-4l5-5m0 0l-5 5m5-5V12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Grading System</h3>
                    <p class="text-gray-600">Efficiently grade and track student performance across various subjects
                        with our intuitive grading system.</p>
                </div>
                <!-- Feature 4 -->
                <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- QR Code Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8H3c-4.418 0-8-3.582-8-8S-1.582 4 3 4h10c4.418 0 8 3.582 8 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">QR Code Attendance</h3>
                    <p class="text-gray-600">Enable attendance tracking per subject using QR codes and scanners for
                        streamlined record-keeping.</p>
                </div>
                <!-- Feature 5 -->
                <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Security Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c.45 0 .85.05 1.25.15M12 11a5 5 0 015 5v2a5 5 0 01-5 5 5 5 0 01-5-5v-2a5 5 0 015-5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure & Reliable</h3>
                    <p class="text-gray-600">Ensure data security and reliability with WebInn's robust security
                        measures.</p>
                </div>
                <!-- Feature 6 -->
                <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-center mb-4">
                        <!-- Customizable Dashboard Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Customizable Dashboard</h3>
                    <p class="text-gray-600">Personalize your dashboard to access the tools and information you need
                        quickly and efficiently.</p>
                </div>
            </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12 text-red-900">User Roles</h2>
            <div class="flex flex-wrap -mx-4">
                <!-- Admin -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Admin Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 010 6.844L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14v7m0 0l-3-3m3 3l3-3" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Admin</h3>
                        <p class="text-gray-600">Oversee all operations, manage users, and configure system settings.
                        </p>
                    </div>
                </div>
                <!-- Teacher -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Teacher Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H3" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Teacher</h3>
                        <p class="text-gray-600">Create and manage courses, grade assignments, and track student
                            progress.</p>
                    </div>
                </div>
                <!-- Student -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Student Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20v-2c0-2.21 3.582-4 6-4s6 1.79 6 4v2H6z" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Student</h3>
                        <p class="text-gray-600">Access courses, submit assignments, and monitor personal academic
                            performance.</p>
                    </div>
                </div>
                <!-- Guidance -->
                <div class="w-full md:w-1/4 px-4 mb-8">
                    <div class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition text-center">
                        <!-- Guidance Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14l4-4 4 4m0 0v6m0-6H8" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Guidance</h3>
                        <p class="text-gray-600">Provide academic and career counseling, and support student well-being.
                        </p>
                    </div>
                </div>
            </div>
    </section>

    <!-- Advanced Features Section -->
    <section id="advanced-features" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-12 text-red-900">Advanced Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Face Recognition -->
                <div
                    class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- Face Recognition Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405a2.032 2.032 0 00-.595-2.646l-3.54-2.12a2.032 2.032 0 00-2.646.595L8.405 14H3v6h6m6 0v-2a4 4 0 10-8 0v2" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Face Recognition for Attendance</h3>
                    <p class="text-gray-600">Utilize cutting-edge face recognition technology to automate and secure
                        student attendance at entry points.</p>
                </div>
                <!-- QR Code Attendance -->
                <div
                    class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- QR Code Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16h8M8 12h8M8 8h8M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">QR Code-Based Attendance</h3>
                    <p class="text-gray-600">Implement subject-specific QR codes and scanners to efficiently track
                        attendance and participation.</p>
                </div>
                <!-- Additional Feature 1 -->
                <div
                    class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- Analytics Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Comprehensive Analytics</h3>
                    <p class="text-gray-600">Gain insights into student performance and system usage with detailed
                        analytics and reporting tools.</p>
                </div>
                <!-- Additional Feature 2 -->
                <div
                    class="bg-white p-6 text-red-900 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center text-center">
                    <!-- Mobile-Friendly Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-900 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 4h2a2 2 0 012 2v12a2 2 0 01-2 2h-2m-8-8h.01M12 16h.01" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Mobile-Friendly Interface</h3>
                    <p class="text-gray-600">Access WebInn on any device with our responsive and mobile-optimized
                        design.</p>
                </div>
            </div>
    </section>



    <!-- Call to Action Section -->
    <section class="py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-semibold mb-4 text-red-900">Join WebInn Today!</h2>
            <p class="text-lg mb-8">Experience a smarter way to manage education. Whether you're an admin, teacher,
                student, or guidance counselor, WebInn has the tools you need.</p>
            <a href="#" id="getStartedBtnFooter"
                class="bg-red-900 text-white px-6 py-3 rounded-full font-semibold hover:bg-red-700 hover:text-white transition">Get
                Started Now</a>
        </div>
    </section>

    <!-- Footer Section -->
    <!-- Footer Section -->
    <footer class="custom-bg text-white text-center py-6 mt-10" id="about">
        <!-- About Us Section -->
        <div class="max-w-4xl mx-auto">
            <h2 class="text-lg font-bold">About Us</h2>
            <p class="text-sm mt-2">
                We aim to provide a seamless and user-friendly experience for students, teachers,
                guidance counselors, and administrators. Our goal is to enhance education and communication through web
                technology.
            </p>
        </div>

        <div class="mt-4">
            <a href="https://web.facebook.com/aldrinDev02" target="_blank" class="text-white mx-2">
                <i class="fa-brands fa-facebook"></i>
            </a>
            <a href="https://github.com/aldrin112602" target="_blank" class="text-white mx-2">
                <i class="fa-brands fa-github"></i>
            </a>
            <a href="https://www.linkedin.com/in/aldrin02" target="_blank" class="text-white mx-2">
                <i class="fa-brands fa-linkedin"></i>
            </a>
        </div>
        <div class="mt-4 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} WebInn. All rights reserved.</p>
            {{-- <p>Developed by <strong>Aldrin Caballero</strong></p> --}}
        </div>
    </footer>



    <!-- jQuery CDN -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Custom jQuery Script for Modal -->
    <script>
        $(document).ready(function () {
            function o() { $("#roleModal").fadeOut(300) }
            $("#getStartedBtn, #getStartedBtnFooter").on("click", function (o) { o.preventDefault(), $("#roleModal").fadeIn(300) }), $("#closeModal").on("click", function () { o() }), $("#roleModal").on("click", function (n) { $(n.target).is("#roleModal") && o() }), $(document).on("keydown", function (n) { "Escape" === n.key && o() }), $(this).scroll(function () {
                this.querySelector("nav").classList.toggle("bg-active-nav", window.scrollY > 30)
            })
        });

        ScrollReveal().reveal('div', { delay: 300 });
    </script>
</body>

</html>