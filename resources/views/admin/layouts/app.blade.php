<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <!-- <script src="{{ asset('build/assets/app.js') }}" defer></script> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Create Account')</title>
    <!-- Search Engine Optimization by Aldrin Caballero -->
    <!-- Profile Link (XFN - Social Relationships) -->
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- Meta Description -->
    <meta name="description"
        content="WebInn is revolutionizing education with Face Recognition & QR Code Attendance, Email Notifications, and Grading System for Admins, Teachers, Students, and Guidance Counselors.">

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
        content="WebInn is revolutionizing education with Face Recognition & QR Code Attendance, Email Notifications, and Grading System.">
    <meta property="og:image" content="{{ asset('images/philtech-logo-transparent.webp') }}">
    <meta property="og:url" content="https://aquamarine-fish-440283.hostingersite.com/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="WebInn">
    <meta property="og:locale" content="en_US">

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "WebInn",
          "url": "https://aquamarine-fish-440283.hostingersite.com/",
          "logo": "{{ asset('images/philtech-logo-transparent.webp') }}",
          "description": "WebInn is revolutionizing education with Face Recognition & QR Code Attendance, Email Notifications, and Grading System.",
          "sameAs": [
            "https://web.facebook.com/aldrinDev02",
            "https://github.com/aldrin112602",
            "https://www.linkedin.com/in/aldrin02"
          ]
        }
        </script>

    <link rel="icon" type="image/png" href="{{ asset('images/philtech-logo-transparent.webp') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery.min.js') }}" ></script>
    <script src="  {{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/w3.min.js') }}"></script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
      


     
    <style>
        html::-webkit-scrollbar {
            display: none;
        }

        * {
            scroll-behavior: smooth;
        }

        @media print {
            #tablePreview {
                position: fixed;
                top: 0;
                left: 0;
                background: white;
                z-index: 100;
                width: 100vw;
                height: 100vh;
            }

            #tablePreview ._header {
                display: block !important;
            }

            #tablePreview h2 {
                display: block !important;
            }

            #tablePreview table tr td:first-child,
            #tablePreview table tr th:first-child,
            #tablePreview table tr td:last-child,
            #tablePreview table tr th:last-child {
                display: none !important;
            }

            #tablePreview table tr input[type="checkbox"]:not(:checked)+.ellipsis-text {
                display: none !important;
            }

        }
    </style>
</head>

<body class="bg-gray-100">
    <main class="min-h-screen">
        <div class="w-full flex items-center justify-between bg-white px-8 py-3 shadow border-b">
            <h2 class="text-blue-900 font-semibold"><script>
                    $(() => {
                        $('#toggleBtn').click(() => {
                            $('#sideBar').toggle(100);
                        });
                    });
                </script>
                <button id="toggleBtn" style="height: 30px; width: 30px" class="bg-slate-100 rounded hover:bg-slate-50 hover:border">
                    <i class="fa-solid fa-bars-staggered text-gray-600 text-sm"></i>
                </button> WebInn</h2>
            <ul class="flex items-center justify-end gap-5">
                <li>
                    <a class="hover:text-blue-500" href="{{ route('admin.history') }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </a>
                </li>

                <li>
                    <a class="hover:text-blue-500" href="{{ route('admin.notification') }}">
                        <i class="fa-regular fa-bell"></i>
                    </a>
                </li>
                <li>
                    <a class="hover:text-blue-500" href="{{ route('admin.chats.index') }}">
                        <i class="fa-regular fa-message"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="block md:flex h-screen items-start justify-start">
            <!-- sidebar -->
            <div id="sideBar" class="hidden md:block  p-4 bg-white shadow border-r" style="min-height: 100vh; min-width: 280px">
                <div class="p-3 flex items-center justify-start gap-3">
                    
                    <div class="flex items-center justify-start gap-1">
                        <span class="font-semibold text-gray-600">WebInn</span>
                        <img src="{{ asset('images/philtech-logo.webp') }}" alt="" style="height: 30px; width: 30px" />
                    </div>
                </div>
                <div class="p-3 {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm flex items-center justify-start gap-3"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
                </div>
                <div class="p-3 {{ (request()->is('admin/create/admin') || request()->is('admin/create/teacher') || request()->is('admin/create/guidance') || request()->is('admin/create/student') || request()->is('admin/account_management/admin_list') || request()->is('admin/account_management/student_list') || request()->is('admin/account_management/guidance_list') || request()->is('admin/account_management/teacher_list')) ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <div class="relative inline-block text-left w-full">
                        <div class="w-full">
                            <button type="button" class="text-sm flex items-center justify-start gap-3 w-full" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                <i class="fa-solid fa-user-group"></i>
                                Account Management
                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div role="none">
                                <a href="{{ route('admin.admin_list') }}" class="{{ request()->is('admin/account_management/admin_list') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} block px-4 py-2 text-sm flex items-center justify-start gap-3" role="menuitem" tabindex="-1" id="menu-item-0"><i class="fa-solid fa-list"></i> Admin List</a>
                                <a href="{{ route('admin.guidance_list') }}" class="{{ request()->is('admin/account_management/guidance_list') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} block px-4 py-2 text-sm flex items-center justify-start gap-3" role="menuitem" tabindex="-1" id="menu-item-1"><i class="fa-solid fa-list"></i> Guidance List</a>
                                <a href="{{ route('admin.teacher_list') }}" class="{{ request()->is('admin/account_management/teacher_list') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} block px-4 py-2 text-sm flex items-center justify-start gap-3" role="menuitem" tabindex="-1" id="menu-item-2"><i class="fa-solid fa-list"></i> Teacher List</a>
                                <a href="{{ route('admin.student_list') }}" class="{{ request()->is('admin/account_management/student_list') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} block px-4 py-2 text-sm flex items-center justify-start gap-3" role="menuitem" tabindex="-1" id="menu-item-2"><i class="fa-solid fa-list"></i> Student List</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 {{ (request()->is('admin/subject/list') || request()->is('admin/teacher/subject_list') || request()->is('admin/subject') || request()->is('admin/subject/create') || request()->is('admin/subject/{id}/edit')) ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <a href="{{ route('admin.subject') }}" class="text-sm flex items-center justify-start gap-3"><i class="fa-solid fa-bullhorn"></i></i>Subjects</a>
                </div>


                <div class="p-3 {{ ((request()->is('admin/attendance/report') || request()->is('admin/attendance/absent') || request()->is('admin/attendance/present'))  || request()->is('admin/facescan')) ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <div class="relative inline-block text-left w-full">
                        <div class="w-full">
                            <button type="button" class="text-sm flex items-center justify-start gap-3 w-full" id="menu-button-2" aria-expanded="true" aria-haspopup="true">
                                <i class="fa-solid fa-graduation-cap"></i> Attendance List
                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="dropdown-menu-2" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-2" tabindex="-1">
                            <div role="none">
                                <a href="{{ route('admin.attendance.report') }}" class="{{
                                           (request()->is('admin/attendance/report') || request()->is('admin/attendance/absent') || request()->is('admin/attendance/present')) ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} block px-4 py-2 text-sm flex items-center justify-start gap-3" role="menuitem" tabindex="-1" id="menu-item-0"><i class="fa-solid fa-list-ul"></i>
                                    Attendance Report
                                </a>

                                <a href="{{ route('admin.facescan') }}" class="{{
                                           request()->is('admin/facescan') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} block px-4 py-2 text-sm flex items-center justify-start gap-3" role="menuitem" tabindex="-1" id="menu-item-0"><i class="fa-solid fa-list-ul"></i>
                                    Face Scan
                                </a>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 {{ request()->is('admin/set_pattern_auth') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <a href="{{ route('face.recognition.set') }}" class="text-sm flex items-center justify-start gap-3"><i class="fa-solid fa-cog"></i>Face Recognition</a>
                </div>
                <div class="p-3 {{ request()->is('admin/student/grade/student_list') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <a href="{{ route('admin.grade.student_list') }}" class="text-sm flex items-center justify-start gap-3"><i class="fa-solid fa-graduation-cap"></i>Students Grade</a>
                </div>
                <div class="py-2">
                    <hr>
                </div>

                <div class="p-3 {{ request()->is('admin/chats') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <a href="{{ route('admin.chats.index') }}" class="text-sm flex items-center justify-start gap-3"><i class="fa-regular fa-message"></i>Messages <span class="text-rose-600 font-semibold" id="messageCounts">0</span></a>
                </div>
                <script>
                    $(() => {
                        $.ajax({
                            url: `{{ route('admin.get_message_count') }}`,
                            method: 'GET',
                            success: (response) => {
                                $('#messageCounts').text(response.count);
                            }
                        });
                    })
                </script>

                <div class="p-3 {{ request()->is('admin/notifications') ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <a href="{{ route('admin.notification') }}" class="text-sm flex items-center justify-start gap-3"><i class="fa-solid fa-bell"></i>Notifications</a>
                </div>
                <div class="p-3 {{ (request()->is('admin/settings') || request()->is('admin/profile')) ? 'bg-blue-50 text-blue-500' : 'hover:bg-blue-50 hover:text-blue-500 text-gray-700' }} rounded">
                    <a href="{{ route('admin.profile') }}" class="text-sm flex items-center justify-start gap-3"><i class="fa-solid fa-gear"></i>Settings</a>
                </div>
                <div class="p-3 hover:bg-blue-50 hover:text-blue-500 text-gray-700 rounded">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="button" class="text-sm flex items-center justify-start gap-3" id="logout-btn">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </div>
                <hr>
                <div class="p-3 text-gray-700">
                    <div class="flex justify-start items-center gap-2">
                        <img src="{{ isset($user->profile) ? asset('storage/' . $user->profile) : 'https://static.vecteezy.com/system/resources/previews/019/896/008/original/male-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png' }}" alt="User profile" class="rounded-full border object-cover" style="height: 45px; width: 45px;">
                        <div class="flex flex-col justify-start items-start flex-wrap">
                            <span class="text-gray-600 text-xs font-semibold">{{ $user->name }}</span>
                            <span class="text-gray-500 text-xs">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sidebar -->
            <!-- main content -->
            <div class="h-screen w-full" style="overflow-y: auto;">
                @yield('content')
            </div>
            <!-- main content -->
        </div>
    </main>

    <script>
        try {
            $(document).ready(() => {
                $('.toggle-password').on('click', function() {
                    const passwordInput = $($(this).attr('toggle'));
                    const isPassword = passwordInput.attr('type') === 'password';
                    passwordInput.attr('type', isPassword ? 'text' : 'password');
                    $(this).toggleClass('fa-eye fa-eye-slash');
                });
            });
        } catch (err) {

        }
    </script>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });

        });
    </script>
    @endif

    @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });

        });
    </script>
    @endif

    <script>
        try {
            $(document).ready(function() {
                $('#logout-btn').click(function() {
                    Swal.fire({
                        title: 'Logout',
                        text: 'Are you sure you want to logout?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, logout'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#logout-form').submit();
                        }
                    });
                });
            });
        } catch (err) {

        }
    </script>

    <script>
        $(document).ready(function() {
            $('#menu-button').on('click', function() {
                const expanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !expanded);
                $('#dropdown-menu').toggleClass('hidden');
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#menu-button, #dropdown-menu').length) {
                    $('#dropdown-menu').addClass('hidden');
                    $('#menu-button').attr('aria-expanded', 'false');
                }
            });



            $('#menu-button-2').on('click', function() {
                const expanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !expanded);
                $('#dropdown-menu-2').toggleClass('hidden');
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#menu-button-2, #dropdown-menu-2').length) {
                    $('#dropdown-menu-2').addClass('hidden');
                    $('#menu-button-2').attr('aria-expanded', 'false');
                }
            });
        });
    </script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

    <script>
        let selectAll = document.getElementById('selectAll')
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('.selectRow');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            // Individual checkbox change event
            $('.highlight-checkbox').change(function() {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').addClass('bg-blue-50 text-blue-700');
                } else {
                    $(this).closest('tr').removeClass('bg-blue-50 text-blue-700');
                }
            });

            // Select all checkbox change event
            $('#selectAll').change(function() {
                if ($(this).is(':checked')) {
                    $('.highlight-checkbox').each(function() {
                        $(this).prop('checked', true);
                        $(this).closest('tr').addClass('bg-blue-50 text-blue-700');
                    });
                } else {
                    $('.highlight-checkbox').each(function() {
                        $(this).prop('checked', false);
                        $(this).closest('tr').removeClass('bg-blue-50 text-blue-700');
                    });
                }
            });

            // Uncheck #selectAll if any individual checkbox is unchecked
            $('.highlight-checkbox').change(function() {
                if (!$(this).is(':checked')) {
                    $('#selectAll').prop('checked', false);
                } else if ($('.highlight-checkbox:checked').length === $('.highlight-checkbox').length) {
                    $('#selectAll').prop('checked', true);
                }
            });

            // Delete selected rows
            $('#deleteSelected').click(function() {
                const selectedIds = $('.highlight-checkbox:checked').map(function() {
                    return $(this).data('id');
                }).get();

                if (selectedIds.length > 0) {

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#selected_ids').val(selectedIds);
                            $('#deleteSelectedForm').submit();
                        }
                    })
                } else {
                    // alert('No rows selected.');
                    Swal.fire({
                        title: 'No Rows Selected',
                        text: "Please select at least one row to delete.",
                        icon: 'info',
                    });

                }
            });
        });
    </script>
</body>

</html>