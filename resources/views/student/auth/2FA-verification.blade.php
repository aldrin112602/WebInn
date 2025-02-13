@extends('student.layouts.auth')
@section('title', 'Verify OTP')

@section('content')
<form action="{{ route('student.2fa.verify') }}" method="post" class="w-full max-w-md bg-white rounded-lg p-8 mx-auto mt-10 shadow-lg" style="box-shadow: 0 0 0 100vw rgba(0, 0, 0, 0.6);">
    @csrf
    <h2 class="text-2xl font-bold mb-6 text-gray-600">Verify Your OTP Code</h2>
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
            <input autofocus type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 @error('otp') border-red-500 @enderror">
            <input type="text" maxlength="1" class="otp-box form-input w-12 h-12 text-center rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 @error('otp') border-red-500 @enderror">
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

                // Function to update the hidden input with the joined OTP
                const updateHiddenOtpValue = () => {
                    const otpValue = Array.from(otpInputs)
                        .map(input => input.value)
                        .join(""); // Join all values into a single string
                    hiddenOtpInput.value = otpValue;
                };

                otpInputs.forEach((input, index) => {
                    input.addEventListener("input", (e) => {
                        const current = e.target;
                        const next = otpInputs[index + 1];
                        const prev = otpInputs[index - 1];

                        if (current.value.length === 1 && next) {
                            next.focus(); // Focus the next box if filled
                        } else if (e.inputType === "deleteContentBackward" && prev) {
                            prev.focus(); // Focus the previous box if deleted
                        }

                        updateHiddenOtpValue(); // Update the hidden input on each change
                    });

                    input.addEventListener("keydown", (e) => {
                        if (e.key === "Backspace" && input.value === "") {
                            const prev = otpInputs[index - 1];
                            if (prev) {
                                prev.focus(); // Focus the previous box on backspace
                            }
                        }
                    });
                });
            });
        </script>
    </div>

    <div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">Verify OTP</button>
        <p class="text-center mt-4 text-sm text-gray-500">Didn't receive the code? <a href="{{ route('student.2fa.resend') }}" id="resendLink" class="text-blue-600 hover:underline" style="pointer-events: none; opacity: 0.5;">Resend Code</a></p>
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
                expiredMessage.classList.remove('hidden'); // Show the expired message
                clearInterval(interval); // Stop the countdown
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