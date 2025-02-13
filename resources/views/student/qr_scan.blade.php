@extends('student.layouts.app')

@section('title', 'Scan QR')

@section('content')
<div class="p-5 bg-white">
    <h1 class="text-xl">Scan QR</h1>
    <div id="reader"></div>
</div>

<script>
    const client_teacher_id = @json(request()->query('teacher_id'));
    const client_subject_id = @json(request()->query('subject_id'));

    let lastScannedCode = null;
    let lastScanTime = 0;
    const scanDelay = 3000; // Adjust delay (e.g., 3 seconds) between requests to avoid excessive API calls

    function onScanSuccess(qrCodeMessage) {
        const currentTime = Date.now();
        const parsedCode = JSON.stringify({
            ...JSON.parse(window.atob(qrCodeMessage)),
            client_teacher_id,
            client_subject_id
        });

        // Check if the same code has been scanned within the delay interval
        if (parsedCode === lastScannedCode && currentTime - lastScanTime < scanDelay) {
            console.log('Duplicate scan ignored');
            return;
        }

        lastScannedCode = parsedCode;
        lastScanTime = currentTime;

        fetch("{{route('qr.scan')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: parsedCode
            })
            .then(response => response.json())
            .then(data => {
                if (data?.error) {
                    Swal.fire({
                        title: "Error",
                        text: data.error,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Success",
                        text: data.success,
                        icon: "success"
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function onScanFailure(error) {
        console.warn(`QR code scan failed: ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: 300
        }
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection

@section('scripts')
<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
@endsection