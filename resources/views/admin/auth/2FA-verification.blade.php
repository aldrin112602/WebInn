@extends('admin.layouts.auth')
@section('title', 'Verify OTP')

@section('content')
<form action="{{ route('admin.2fa.verify') }}" method="post" class="w-full max-w-md bg-white  rounded-lg p-8 relative shadow" style="overflow: hidden;">

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
    <h2 class="text-2xl font-bold mb-6 text-red-900 mt-5">Verify Your OTP Code</h2>
    <p class="mb-4 text-gray-500 text-sm">Please enter the 6-digit code sent to your email to complete the verification.</p>

    <!-- Add countdown timer display -->
    <div class="mb-4 text-center">
        <p class="text-sm text-gray-600">Time remaining:</p>
        <p id="countdown" class="text-lg font-semibold text-blue-600">10:00</p>
    </div>

    <div class="mb-6">
        <label for="otp" class="block text-gray-700 font-medium">OTP Code</label>
        <div id="otp-container" class="flex justify-between">
            <!-- Six input fields for the OTP -->
            <input autofocus type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg focus:ring-2 focus:ring-rose-900 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg focus:ring-2 focus:ring-rose-900 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg focus:ring-2 focus:ring-rose-900 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg focus:ring-2 focus:ring-rose-900 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg focus:ring-2 focus:ring-rose-900 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg focus:ring-2 focus:ring-rose-900 @error('otp') border-red-500 @enderror">
        </div>

        @error('otp')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <input type="hidden" id="otp" name="otp">
        <span id="expiredMessage" class="text-red-500 text-sm hidden">The OTP has expired. Please request a new one.</span>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const otpInputs = document.querySelectorAll(".otp-box");
                const hiddenOtpInput = document.getElementById("otp");

            
                const updateHiddenOtpValue = () => {
                    const otpValue = Array.from(otpInputs)
                        .map(input => input.value)
                        .join(""); 
                    hiddenOtpInput.value = otpValue;
                };

                otpInputs.forEach((input, index) => {
                    input.addEventListener("input", (e) => {
                        const current = e.target;
                        const next = otpInputs[index + 1];
                        const prev = otpInputs[index - 1];

                        if (current.value.length === 1 && next) {
                            next.focus();
                        } else if (e.inputType === "deleteContentBackward" && prev) {
                            prev.focus(); 
                        }

                        updateHiddenOtpValue(); 
                    });

                    input.addEventListener("keydown", (e) => {
                        if (e.key === "Backspace" && input.value === "") {
                            const prev = otpInputs[index - 1];
                            if (prev) {
                                prev.focus(); 
                            }
                        }
                    });
                });
            });
        </script>
    </div>

    <div>
        <button type="submit" class="w-full bg-rose-900 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition duration-200">Verify OTP</button>
        <p class="text-center mt-4 text-sm text-gray-500">Didn't receive the code? <a href="{{ route('admin.2fa.resend') }}" id="resendLink" class="text-blue-600 hover:underline" style="pointer-events: none; opacity: 0.5;">Resend Code</a></p>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expiryTime = new Date("{{ Session::get('otp_expiry') }}").getTime();

        if (isNaN(expiryTime)) {
            console.error('Invalid expiry time format');
            document.getElementById('countdown').textContent = 'Error';
            return;
        }

        const countdownElement = document.getElementById('countdown');
        const resendLink = document.getElementById('resendLink');
        const expiredMessage = document.getElementById('expiredMessage');

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = expiryTime - now;

            if (timeLeft <= 0) {
                countdownElement.textContent = '00:00';
                countdownElement.classList.remove('text-blue-600');
                countdownElement.classList.add('text-red-600');
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.opacity = '1';
                expiredMessage.classList.remove('hidden');
                clearInterval(interval);
                return;
            }

            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        const interval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call to display immediately
    });
</script>
@endsection