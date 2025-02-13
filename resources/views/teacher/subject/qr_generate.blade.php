@extends('teacher.layouts.app')
@section('title', 'QR Code Generated | Ready to Scan')
@section('content')
<div class="w-full mb-6">
    <!-- Main container with two columns -->
    <div class="flex flex-wrap justify-between w-full">
        <!-- First column: QR Code and Details -->
        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <div class="flex flex-col items-center justify-center">
                <div id="qr_generate" class="border-dashed border-2 border-gray-300 p-4 rounded-lg mb-6 pointer-events-none"></div>
                <button id="generateNewQrCode" class="mb-6 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded">
                    Generate new QR code
                </button>
                <div class="w-full">
                    <h2 class="border-b-2 border-yellow-600 py-2">
                        {{ $subject->subject }} - {{ $subject->time }}
                    </h2>
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-2 py-1"></th>
                                <th class="px-2 py-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border">Total Students:</td>
                                <td class="px-2 py-1 border">{{ $allStudentsCount }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border">Total Present:</td>
                                <td class="px-2 py-1 border" id="present">{{ $presentCount }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border">Total Absent:</td>
                                <td class="px-2 py-1 border" id="absent">{{ $absentCount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Second column: Table of Students -->
        <div class="bg-white shadow-md rounded-lg p-6 w-full mt-6 lg:mt-0">
            <h2 class="border-b-2 border-yellow-600 py-2">List of Students</h2>
            <table class="w-full mt-4">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border">ID NO.</th>
                        <th class="px-4 py-2 text-left border">STUDENT NAME</th>
                        <th class="px-4 py-2 text-left border">TIME IN</th>
                        <th class="px-4 py-2 text-left border">STATUS</th>
                        <th class="px-4 py-2 text-left border">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td class="px-4 py-2 border">{{ $student->id_number }}</td>
                        <td class="px-4 py-2 border">{{ $student->name }}</td>
                        <td class="px-4 py-2 border">
                            @if($student->status == 'Present')
                            {{ \Carbon\Carbon::parse($student->time_in)->format('h:i A') }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="px-4 py-2 border">
                            @if($student->status == 'Present')
                            <span class="text-green-600 font-semibold">Present</span>
                            @else
                            <span class="text-red-600 font-semibold">Absent</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border">
                            @if($student->status == 'Absent')
                            <button
                                class="px-4 py-2 bg-blue-500 text-white rounded mark-present-btn"
                                data-student-id="{{ $student->id }}"
                                data-subject-id="{{ $subject->id }}">
                                Set present
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/qrcode.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
    // Function to add logo to QR code with proper error handling
    function generateQRWithLogo(qrContainer, data, logoUrl) {
        // Clear previous content
        $(qrContainer).empty();
        
        // Generate initial QR code but hide it
        const qrWrapper = document.createElement('div');
        qrWrapper.style.display = 'none';
        qrContainer.appendChild(qrWrapper);
        
        const qr = new QRCode(qrWrapper, {
            text: window.btoa(data),
            width: 400,
            height: 400,
            colorDark: "#000",
            colorLight: "#fff",
            correctLevel: QRCode.CorrectLevel.H,
            quietZone: 15
        });

        // Add logo after QR code is generated
        setTimeout(() => {
            const qrCanvas = qrWrapper.querySelector('canvas');
            if (!qrCanvas) return;

            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Set canvas size to match QR code
            canvas.width = qrCanvas.width;
            canvas.height = qrCanvas.height;
            
            // Draw existing QR code onto new canvas
            ctx.drawImage(qrCanvas, 0, 0);

            // Load and draw logo
            const logo = new Image();
            logo.crossOrigin = "Anonymous";
            
            logo.onload = function() {
                // Calculate logo size (20% of QR code size)
                const logoSize = canvas.width * 0.2;
                const logoX = (canvas.width - logoSize) / 2;
                const logoY = (canvas.height - logoSize) / 2;
                
                // Create white background for logo
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(logoX - 5, logoY - 5, logoSize + 10, logoSize + 10);
                
                // Draw logo
                ctx.drawImage(logo, logoX, logoY, logoSize, logoSize);
                
                // Remove the hidden wrapper with original QR
                qrWrapper.remove();
                
                // Add the new canvas to container
                canvas.classList.add('qr-canvas');
                qrContainer.appendChild(canvas);
            };

            logo.onerror = function() {
                console.error('Failed to load logo image');
                // If logo fails to load, show original QR code
                qrWrapper.style.display = 'block';
            };

            logo.src = logoUrl;
        }, 100);
    }

    let qrData = localStorage.getItem('qrData');
    const qrContainer = document.getElementById('qr_generate');
    const logoUrl = "{{ asset('images/philtech_logo.png') }}";

    const createNewQr = () => {
        qrData = @json($data);
        localStorage.setItem('qrData', qrData);
        
        generateQRWithLogo(qrContainer, qrData, logoUrl);

        Swal.fire({
            title: 'Success',
            text: 'QR Code generated successfully!',
            icon: 'success',
        }).then(() => {
            location.reload();
        });
    };

    const qrcodeConfirmation = () => {
        Swal.fire({
            title: 'Generate new QR Code',
            text: 'Are you sure to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, continue'
        }).then((result) => {
            if (result.isConfirmed) createNewQr();
        });
    };

    $('#generateNewQrCode').click(() => {
        qrcodeConfirmation();
    });

    if (!qrData) {
        createNewQr();
    } else {
        console.log('QR data loaded from localStorage');
        
        const parsedData = JSON.parse(qrData);
        const {
            subject_id,
            teacher_id,
            grade_handle_id
        } = parsedData;
        const expirationTime = parsedData.expiration;

        // Generate QR code with logo
        generateQRWithLogo(qrContainer, qrData, logoUrl);

        // Update present and absent count
        setInterval(function() {
            $.ajax({
                url: '{{ route("getPresentCount") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    subject_id,
                    teacher_id,
                    grade_handle_id
                }),
                success: function(data) {
                    $('#present').text(data.count);
                },
                error: function(err) {
                    console.error(err);
                },
            });

            $.ajax({
                url: '{{ route("getAbsentCount") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    teacher_id,
                    grade_handle_id
                }),
                success: function(data) {
                    $('#absent').text(data.count);
                },
                error: function(err) {
                    console.error(err);
                },
            });
        }, 5000);

        // Countdown Timer
        const countdownElement = $('<div>', {
            class: 'text-green-600 p-2 text-center'
        }).appendTo('#qr_generate');

        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const timeLeft = expirationTime - now;

            if (timeLeft <= 0) {
                countdownElement.text('QR Code has expired!')
                    .removeClass('text-green-600')
                    .addClass('text-rose-600');
                Swal.fire({
                    title: 'Expired',
                    text: 'The QR code has expired.',
                    icon: 'error',
                }).then(() => {
                    qrcodeConfirmation();
                });
                clearInterval(interval);
                localStorage.removeItem('qrData');
                return;
            }

            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownElement.text(`Expires in: ${minutes} minute(s) and ${seconds < 10 ? '0' : ''}${seconds} second(s)`);
        }

        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);
    }

    // Mark Present button action
    $('.mark-present-btn').on('click', function() {
        const studentId = $(this).data('student-id');
        const subjectId = $(this).data('subject-id');

        Swal.fire({
            title: 'Set as Present?',
            text: 'Are you sure you want to mark this student as present?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, set as present!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("markAttendanceManually") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    data: JSON.stringify({
                        student_id: studentId,
                        subject_id: subjectId
                    }),
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success').then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message || 'There was an issue marking attendance.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'There was an issue marking attendance.', 'error');
                    },
                });
            }
        });
    });
});
</script>
@endsection