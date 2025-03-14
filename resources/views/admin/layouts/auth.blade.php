<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <!-- <script src="{{ asset('build/assets/app.js') }}" defer></script> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/jquery.min.js') }}" ></script>
    <script src="  {{ asset('js/sweetalert2@11.js') }}"></script>
      
</head>

<body class="bg-gray-100">
    <main class="min-h-screen flex items-center justify-center rounded px-3">
        @yield('content')
        <!-- Modal for Terms and Conditions -->
        <div id="termsModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-lg w-full">
                    <div class="px-6 py-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Terms and Conditions
                        </h3>
                        <hr class="my-3">
                        <div class="mt-2" style="max-height: 400px; overflow-y: auto">
                            <p class="text-sm text-gray-500">
                                Welcome to the WebInn System! We're thrilled to have you join our platform dedicated to revolutionizing education through technology. Before you begin your journey with us, it's essential to understand the terms of use outlined in this agreement. By accessing or using WebInn, you agree to abide by these terms and conditions.
                            </p>
                            <br>
                            <h4 class="text-md font-semibold text-gray-900">Intellectual Property:</h4>
                            <p class="text-sm text-gray-500">
                                All the content, design, code, and materials are exclusively owned by WebInn and protected by copyright and trademark laws. Unauthorized use and only the institution can only use the WebInn system. Any reproduction, or modification is prohibited without written consent. Use of trademarks, logos, or service marks requires prior permission. Unauthorized users are restricted. In the Data Privacy Act of 2012 (Republic Act 10173), the right to privacy and communication is protected while promoting safe information. It ensures the security and protection of personal data in both government and private systems.
                            </p>
                            <br>
                            <h4 class="text-md font-semibold text-gray-900">User Agreement:</h4>
                            <p class="text-sm text-gray-500">
                                As a user of the WebInn System, you must be Admin, Teacher, Student, or Guidance of Philippine Technological Institute of Science Arts and  Trade Inc. and agree to maintain the confidentiality of your account credentials. Your access to and use of our platform is subject to compliance with these terms and all applicable laws and regulations. You acknowledge that any violation of these terms may result in the termination of your account.
                            </p>
                            <br>
                            <h4 class="text-md font-semibold text-gray-900">Terms and Conditions for Logging In:</h4>
                            <p class="text-sm text-gray-500">
                                By logging into this website, you agree to comply with our Terms and Conditions. You are responsible for maintaining the confidentiality of your account and password, and for all activities that occur under your account. Unauthorized use of your account or any security breaches must be reported immediately. We reserve the right to suspend or terminate accounts if there is any breach of these terms.
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="bg-gray-50 px-6 py-4 flex justify-end">
                        <button type="button" class="text-gray-700 bg-gray-300 border border-gray-300 rounded-md px-4 py-2 hover:bg-gray-100" id="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                $('#termsTrigger').on('click', function (event) {
                    event.preventDefault();
                    $('#termsModal').removeClass('hidden');
                });
                $('#closeModal').on('click', function () {
                    $('#termsModal').addClass('hidden');
                });
                $('#agreeTerms').on('change', function () {
                    if ($(this).is(':checked')) {
                        $('#loginButton').removeClass('btn-disabled').addClass('btn-enabled').removeAttr('disabled');
                    } else {
                        $('#loginButton').removeClass('btn-enabled').addClass('btn-disabled').attr('disabled', 'disabled');
                    }
                });

            });
        </script>
    </main>
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