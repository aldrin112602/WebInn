<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="google-site-verification" content="tU_6Yfck8dwvd94C-xcOivOWlkmvLrw3SELDsWyvA_g">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WebInn - Face Recognition Authentication</title>
    <!-- <script src="{{ asset('build/assets/app.js') }}" defer></script> -->

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="{{ asset('js/jquery.min.js') }}"></script>
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
    <style>
        @import url(https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap);button,canvas{cursor:pointer;transition:.3s;backdrop-filter:blur(5px)}#patternOutput,h3{color:#fff;text-align:center}*{margin:0;padding:0;box-sizing:border-box;font-family:Montserrat,sans-serif}body{display:flex;justify-content:center;align-items:center;min-height:100vh;background:linear-gradient(45deg,#ff6b6b,#4ecdc4)}.container{position:relative;padding:2rem;background:rgba(255,255,255,.1);backdrop-filter:blur(10px);border-radius:20px;border:1px solid rgba(255,255,255,.2);box-shadow:0 8px 32px 0 rgba(31,38,135,.37);transition:transform .3s}.container:hover{transform:translateY(-5px)}canvas{border-radius:15px;background:rgba(255,255,255,.05);border:2px solid rgba(255,255,255,.1)}canvas:hover{border-color:rgba(255,255,255,.3)}#patternOutput{margin-top:1rem;font-size:.9rem;opacity:.8}.button-container{display:flex;gap:1rem;margin-top:1rem}button{width:100%;padding:.8rem;border:1px solid rgba(255,255,255,.1);border-radius:10px;background:rgba(255,255,255,.2);color:#fff;font-size:1rem}#resetButton{background:rgba(255,87,87,.3);display:none}button:hover{background:rgba(255,255,255,.3);transform:translateY(-2px)}#resetButton:hover{background:rgba(255,87,87,.4)}button:active{transform:translateY(0)}.point{animation:2s infinite pulse}@keyframes pulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.1);opacity:.8}}.shake{animation:.5s ease-in-out shake}@keyframes shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}h3{margin:10px 0}
    </style>
</head>

<body>
    <div class="container">
        <h3>Please Draw Pattern</h3>
        <canvas id="patternCanvas" width="300" height="300"></canvas>
        <p id="patternOutput"></p>
        <div class="button-container">
            <button id="submitPattern">Verify Pattern</button>
            <button id="resetButton">Reset Pattern</button>
        </div>
    </div>

    <script src="{{ asset('js/pattern-auth.min.js') }}"></script>
</body>

</html>