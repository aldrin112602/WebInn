<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="google-site-verification" content="tU_6Yfck8dwvd94C-xcOivOWlkmvLrw3SELDsWyvA_g">

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

    <link rel="icon" type="image/png" href="{{ asset('images/philtech-logo-transparent.webp') }}">

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
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/face-scan.css') }}">
</head>

<body class="flex items-center justify-center h-screen">
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p class="mt-2">Initializing face recognition system...</p>
        </div>
    </div>

    <div
        class="w-full lg:w-3/4 xl:w-2/3 flex flex-col lg:flex-row items-center space-y-8 lg:space-y-0 lg:space-x-8 bg-white p-6 shadow-lg rounded-lg">
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
                <span id="student-gender" class="ml-2">N/A</span>
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
    <script>
            $(document).ready(function () {
                let hasSubmitted = false;
                let currentStepIndex = 0;
                let faceMatcher = null;
                let isSystemReady = false;
                let isTimeIn = true;
                let objectDetector = null;
                let forbiddenObjects = ['cell phone', 'laptop', 'book', 'tv', 'monitor', 'remote', 'keyboard', 'mouse', 'picture', 'frame'];

                const verificationSteps = [
                    {
                        instruction: "Please look at the camera",
                        action: "center",
                        progress: 25,
                    },
                    {
                        instruction: "Turn your head to the left",
                        action: "right",
                        progress: 50,
                    },
                    {
                        instruction: "Turn your head to the right",
                        action: "left",
                        progress: 75,
                    },
                    {
                        instruction: "Verification complete!",
                        action: "complete",
                        progress: 100,
                    },
                ];

                const video = $("#video")[0];
                const studentName = $("#student-name");
                const studentStrand = $("#student-strand");
                const studentGender = $("#student-gender");
                const studentId = $("#student-id");
                const timeIn = $("#time-in");
                const resetButton = $("#resetButton");
                const overlay = $("#overlay")[0];
                const progressBar = $("#progress-bar");
                const loadingOverlay = $("#loading-overlay");
                const timeToggle = $("#timeToggle");
                const timeType = $("#time-type");

                // Time toggle event handler
                timeToggle.on("change", function () {
                    isTimeIn = $(this).is(":checked");
                    timeType.text(isTimeIn ? "In" : "Out");

                    hasSubmitted = false;
                    currentStepIndex = 0;
                    $("#instruction").text(verificationSteps[0].instruction);
                    progressBar.css("width", "0%");
                    studentName.text("N/A");
                    studentStrand.text("N/A");
                    studentGender.text("N/A");
                    studentId.text("N/A");
                    timeIn.text("N/A");
                });

                async function initializeSystem() {
                    try {
                        loadingOverlay.show();
                        
                        // Load face-api models
                        await Promise.all([
                            faceapi.nets.tinyFaceDetector.loadFromUri(
                                '{{ asset("face_api/models") }}'
                            ),
                            faceapi.nets.faceLandmark68Net.loadFromUri(
                                '{{ asset("face_api/models") }}'
                            ),
                            faceapi.nets.faceRecognitionNet.loadFromUri(
                                '{{ asset("face_api/models") }}'
                            ),
                        ]);

                        // Load COCO-SSD model for object detection
                        objectDetector = await cocoSsd.load();
                        
                        faceMatcher = await initializeFaceMatcher();
                        await startVideo();
                        loadingOverlay.hide();
                        isSystemReady = true;
                    } catch (error) {
                        console.error("Initialization error:", error);
                        loadingOverlay.hide();
                        Swal.fire({
                            title: "Error",
                            text: "Failed to initialize recognition system. Please refresh the page.",
                            icon: "error",
                        });
                    }
                }

                async function initializeFaceMatcher() {
                    try {
                        const labels = await $.get('{{ route("fetch_labels") }}');
                        const labeledFaceDescriptors = await Promise.all(
                            labels.map(async (label) => {
                                const descriptions = [];
                                for (let i = 0; i < 3; i++) {
                                    const img = await faceapi.fetchImage(
                                        `{{ asset('storage/face_images/') }}/${label}/${i}.jpg`
                                    );
                                    const detection = await faceapi
                                        .detectSingleFace(
                                            img,
                                            new faceapi.TinyFaceDetectorOptions()
                                        )
                                        .withFaceLandmarks()
                                        .withFaceDescriptor();

                                    if (detection) {
                                        descriptions.push(detection.descriptor);
                                    }
                                }
                                return new faceapi.LabeledFaceDescriptors(
                                    label,
                                    descriptions
                                );
                            })
                        );

                        return new faceapi.FaceMatcher(labeledFaceDescriptors, 0.4);
                    } catch (error) {
                        console.error("Error initializing face matcher:", error);
                        throw error;
                    }
                }

                function startVideo() {
                    return navigator.mediaDevices
                        .getUserMedia({
                            video: {},
                        })
                        .then((stream) => {
                            video.srcObject = stream;
                            return new Promise((resolve) => {
                                video.onloadedmetadata = () => {
                                    overlay.width = video.videoWidth;
                                    overlay.height = video.videoHeight;
                                    resolve();
                                };
                            });
                        });
                }

                $(video).on("play", async () => {
                    const displaySize = {
                        width: video.videoWidth,
                        height: video.videoHeight,
                    };
                    faceapi.matchDimensions(overlay, displaySize);

                    async function onPlay() {
                        if (!isSystemReady) return requestAnimationFrame(onPlay);

                        const ctx = overlay.getContext("2d");
                        ctx.clearRect(0, 0, overlay.width, overlay.height);

                        // Detect objects first
                        const objectDetections = await objectDetector.detect(video);
                        let hasForbiddenObject = false;
                        
                        // Draw object detections and check for forbidden objects
                        for (let i = 0; i < objectDetections.length; i++) {
                            const detection = objectDetections[i];
                            // Only process high confidence detections (above 60%)
                            if (detection.score > 0.6) {
                                // Check if this is a forbidden object
                                if (forbiddenObjects.includes(detection.class)) {
                                    hasForbiddenObject = true;
                                    
                                    // Get coordinates directly from the detection object
                                    const [x, y, width, height] = detection.bbox;
                                    
                                    // Draw red box for forbidden objects
                                    ctx.strokeStyle = '#FF0000';
                                    ctx.lineWidth = 3;
                                    ctx.strokeRect(x, y, width, height);
                                    
                                    // Create semi-transparent red fill
                                    ctx.fillStyle = 'rgba(255, 0, 0, 0.2)';
                                    ctx.fillRect(x, y, width, height);
                                    
                                    // Draw label with background
                                    const label = `${detection.class} (${Math.round(detection.score * 100)}%)`;
                                    const labelWidth = ctx.measureText(label).width + 10;
                                    
                                    // Label background
                                    ctx.fillStyle = '#FF0000';
                                    ctx.fillRect(x, y > 25 ? y - 25 : y + height, labelWidth, 25);
                                    
                                    // Label text
                                    ctx.fillStyle = '#FFFFFF';
                                    ctx.font = 'bold 16px Arial';
                                    ctx.fillText(label, x + 5, y > 25 ? y - 8 : y + height + 17);
                                } else {
                                    // Draw blue box for allowed objects (for debugging, can be removed in production)
                                    const [x, y, width, height] = detection.bbox;
                                    ctx.strokeStyle = 'rgba(0, 0, 255, 0.5)';
                                    ctx.lineWidth = 2;
                                    ctx.strokeRect(x, y, width, height);
                                }
                            }
                        }

                        if (hasForbiddenObject) {
                            // Display warning message in the center of the screen
                            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
                            ctx.fillRect(overlay.width/2 - 200, overlay.height/2 - 40, 400, 80);
                            
                            ctx.fillStyle = '#FFFFFF';
                            ctx.font = 'bold 20px Arial';
                            ctx.textAlign = 'center';
                            ctx.fillText("PROHIBITED OBJECT DETECTED", overlay.width/2, overlay.height/2 - 10);
                            ctx.font = '16px Arial';
                            ctx.fillText("Please remove all prohibited objects before continuing", overlay.width/2, overlay.height/2 + 20);
                            ctx.textAlign = 'start'; // Reset text alignment
                            
                            $("#instruction").text("");
                            requestAnimationFrame(onPlay);
                            return;
                        }

                        // Proceed with face detection if no forbidden objects are present
                        const detections = await faceapi
                            .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                            .withFaceLandmarks()
                            .withFaceDescriptors();

                        if (detections.length === 0) {
                            return requestAnimationFrame(onPlay);
                        }

                        const resizedDetections = faceapi.resizeResults(
                            detections,
                            displaySize
                        );
                        
                        // Draw face detection results with green color for faces
                        ctx.strokeStyle = '#00FF00';
                        ctx.lineWidth = 2;
                        faceapi.draw.drawDetections(overlay, resizedDetections);
                        faceapi.draw.drawFaceLandmarks(overlay, resizedDetections);

                        const landmarks = detections[0].landmarks;
                        const jawOutline = landmarks.getJawOutline();
                        const nose = landmarks.getNose();

                        // Get the current step object based on the index
                        const currentStep = verificationSteps[currentStepIndex];
                        
                        // switch (currentStep.action) {
                        switch('complete') {
                            case "center":
                                if (isLookingCenter(jawOutline, nose)) moveToNextStep();
                                break;
                            case "left":
                                if (isLookingLeft(jawOutline, nose)) moveToNextStep();
                                break;
                            case "right":
                                if (isLookingRight(jawOutline, nose)) moveToNextStep();
                                break;
                            case "complete":
                                if (!hasSubmitted) {
                                    const result = faceMatcher.findBestMatch(
                                        detections[0].descriptor
                                    );
                                    if (result.label !== "unknown") {
                                        $("#instruction").text(result.label);
                                        if (!hasSubmitted) updateStudentInfo(result.label);
                                    } else {
                                        $("#instruction").text("Unknown person");
                                    }
                                }
                                break;
                        }

                        requestAnimationFrame(onPlay);
                    }

                    onPlay();
                });

                function moveToNextStep() {
                    currentStepIndex++;
                    if (currentStepIndex < verificationSteps.length) {
                        $("#instruction").text(verificationSteps[currentStepIndex].instruction);
                        progressBar.css(
                            "width",
                            verificationSteps[currentStepIndex].progress + "%"
                        );
                    }
                }

                function isLookingLeft(jawOutline, nose) {
                    const jawCenter = getCenter(jawOutline);
                    const nosePosition = getCenter(nose);
                    return nosePosition.x - jawCenter.x < -10;
                }

                function isLookingRight(jawOutline, nose) {
                    const jawCenter = getCenter(jawOutline);
                    const nosePosition = getCenter(nose);
                    return nosePosition.x - jawCenter.x > 10;
                }

                function isLookingCenter(jawOutline, nose) {
                    const jawCenter = getCenter(jawOutline);
                    const nosePosition = getCenter(nose);
                    return Math.abs(nosePosition.x - jawCenter.x) < 5;
                }

                function getCenter(points) {
                    const center = points.reduce(
                        (acc, pt) => ({
                            x: acc.x + pt.x,
                            y: acc.y + pt.y,
                        }),
                        {
                            x: 0,
                            y: 0,
                        }
                    );
                    return {
                        x: center.x / points.length,
                        y: center.y / points.length,
                    };
                }

                function getTimeIn() {
                    const date = new Date();
                    const hours =
                        date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
                    const minutes = String(date.getMinutes()).padStart(2, "0");
                    return `${hours}:${minutes}${date.getHours() >= 12 ? " PM" : " AM"}`;
                }

                function getDate() {
                    const date = new Date();
                    const day = String(date.getDate()).padStart(2, "0");
                    const month = String(date.getMonth() + 1).padStart(2, "0");
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                }

                function updateStudentInfo(label) {
                    $.get(`/face_recognition/student-info/${label}`, (data) => {
                        const { id, name, strand, gender, id_number } = data;

                        studentGender.text(gender);
                        studentName.text(name);
                        studentStrand.text(strand);
                        studentId.text(id_number);
                        timeIn.text(getDate() + " " + getTimeIn());

                        if (!hasSubmitted) {
                            $.ajax({
                                url: '{{ route("face.attendance") }}',
                                type: "POST",
                                data: {
                                    student_id: id,
                                    is_time_in: String(isTimeIn),
                                },
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                        "content"
                                    ),
                                },
                                success: function (response) {
                                    hasSubmitted = true;

                                    console.log(response);
                                    Swal.fire({
                                        title: response.success
                                            ? "Face Successfully Scanned!"
                                            : "Info!",
                                        text: response.message,
                                        icon: response.success ? "success" : "info",
                                    });
                                },
                                error: function (err) {
                                    hasSubmitted = true;
                                    console.error("Error submitting attendance:", err);
                                    Swal.fire({
                                        title: "Error",
                                        text: "Failed to submit attendance. Please try again.",
                                        icon: "error",
                                    });
                                },
                            });

                            hasSubmitted = true;
                        }
                    }).fail((err) => {
                        console.error("Error fetching student info:", err);
                        Swal.fire({
                            title: "Error",
                            text: "Failed to fetch student information. Please try again.",
                            icon: "error",
                        });
                    });
                }

                resetButton.on("click", () => {
                    hasSubmitted = false;
                    currentStepIndex = 0;
                    $("#instruction").text(verificationSteps[0].instruction);
                    progressBar.css("width", "0%");
                    studentName.text("N/A");
                    studentStrand.text("N/A");
                    studentGender.text("N/A");
                    studentId.text("N/A");
                    timeIn.text("N/A");
                    // timeToggle.prop("checked", true);
                    // isTimeIn = true;
                    // timeType.text("In");

                    Swal.fire({
                        title: "Face Scan Reset successfully",
                        icon: "success",
                    });
                });

                // Confirmation before page reload
                window.addEventListener("beforeunload", function (e) {
                    var confirmationMessage =
                        "Are you sure to reload this page? This may take some time to load all models once you reload the page.";
                    (e || window.event).returnValue = confirmationMessage;
                    return confirmationMessage;
                });

                // Initialize the system when the page loads
                initializeSystem();
            });
    </script>
</body>

</html>