<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WebInn - Face Recognition Authentication</title>
    <script src="{{ asset('build/assets/app.js') }}" defer></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
        }

        .container {
            position: relative;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        canvas {
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            
        }

        canvas:hover {
            border-color: rgba(255, 255, 255, 0.3);
            
        }

        #patternOutput {
            margin-top: 1rem;
            color: white;
            font-size: 0.9rem;
            text-align: center;
            opacity: 0.8;
        }

        .button-container {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        #resetButton {
            background: rgba(255, 87, 87, 0.3);
            display: none;
        }

        button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        #resetButton:hover {
            background: rgba(255, 87, 87, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .point {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        h3 {
            margin: 10px 0;
            color: white;
            text-align: center;
        }
        
        

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

    <script>
    const canvas = document.getElementById('patternCanvas');
    const ctx = canvas.getContext('2d');
    const patternOutput = document.getElementById('patternOutput');
    const submitButton = document.getElementById('submitPattern');
    const resetButton = document.getElementById('resetButton');

    const canvasSize = 300;
    const gridSize = 3;
    const pointRadius = 12;
    const arrowSize = 8;
    const points = [];
    const pattern = [];
    const selectedPoints = new Set();
    let lastPoint = null;
    let currentPoint = null;
    let isPatternValid = true;

    // Initialize grid points
    const gap = canvasSize / (gridSize + 1);
    for (let row = 1; row <= gridSize; row++) {
        for (let col = 1; col <= gridSize; col++) {
            points.push({
                x: col * gap,
                y: row * gap,
                id: (row - 1) * gridSize + col
            });
        }
    }

    function resetPattern() {
        pattern.length = 0;
        selectedPoints.clear();
        lastPoint = null;
        currentPoint = null;
        isPatternValid = true;
        resetButton.style.display = 'none';
        canvas.classList.remove('shake');
        drawGrid();
        patternOutput.textContent = '';
    }

    function drawArrow(fromX, fromY, toX, toY, color) {
        const angle = Math.atan2(toY - fromY, toX - fromX);
        const arrowX = fromX + (toX - fromX) * 0.8;
        const arrowY = fromY + (toY - fromY) * 0.8;

        ctx.save();
        ctx.translate(arrowX, arrowY);
        ctx.rotate(angle);

        ctx.beginPath();
        ctx.moveTo(-arrowSize, -arrowSize);
        ctx.lineTo(0, 0);
        ctx.lineTo(-arrowSize, arrowSize);

        ctx.strokeStyle = color;
        ctx.lineWidth = 2;
        ctx.stroke();

        ctx.restore();
    }

    const drawGrid = () => {
        ctx.clearRect(0, 0, canvasSize, canvasSize);

        // Draw connection lines and arrows
        if (pattern.length > 1) {
            for (let i = 0; i < pattern.length - 1; i++) {
                const point1 = points.find(p => p.id === pattern[i]);
                const point2 = points.find(p => p.id === pattern[i + 1]);

                const gradient = ctx.createLinearGradient(point1.x, point1.y, point2.x, point2.y);
                gradient.addColorStop(0, isPatternValid ? '#4ecdc4' : '#ff5757');
                gradient.addColorStop(1, isPatternValid ? '#2ab7ca' : '#ff3333');

                ctx.beginPath();
                ctx.moveTo(point1.x, point1.y);
                ctx.lineTo(point2.x, point2.y);
                ctx.strokeStyle = gradient;
                ctx.lineWidth = 3;
                ctx.stroke();
                ctx.closePath();

                drawArrow(point1.x, point1.y, point2.x, point2.y, '#ffffff');
            }
        }

        if (lastPoint && currentPoint) {
            const gradient = ctx.createLinearGradient(lastPoint.x, lastPoint.y, currentPoint.x, currentPoint.y);
            gradient.addColorStop(0, isPatternValid ? '#4ecdc4' : '#ff5757');
            gradient.addColorStop(1, isPatternValid ? '#2ab7ca' : '#ff3333');

            ctx.beginPath();
            ctx.moveTo(lastPoint.x, lastPoint.y);
            ctx.lineTo(currentPoint.x, currentPoint.y);
            ctx.strokeStyle = gradient;
            ctx.lineWidth = 3;
            ctx.stroke();
            ctx.closePath();

            drawArrow(lastPoint.x, lastPoint.y, currentPoint.x, currentPoint.y, '#ffffff');
        }

        // Draw points
        points.forEach((point) => {
            // Glow effect
            ctx.save();
            ctx.beginPath();
            ctx.arc(point.x, point.y, pointRadius + 5, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(255, 255, 255, 0.1)';
            ctx.filter = 'blur(3px)';
            ctx.fill();
            ctx.restore();

            // Main point
            ctx.beginPath();
            ctx.arc(point.x, point.y, pointRadius, 0, Math.PI * 2);
            ctx.fillStyle = selectedPoints.has(point.id) ?
                (isPatternValid ? '#4ecdc4' : '#ff5757') :
                'rgba(255, 255, 255, 0.8)';
            ctx.fill();
            ctx.closePath();

            // Inner circle
            ctx.beginPath();
            ctx.arc(point.x, point.y, pointRadius - 4, 0, Math.PI * 2);
            ctx.fillStyle = selectedPoints.has(point.id) ?
                (isPatternValid ? '#2ab7ca' : '#ff3333') :
                'rgba(255, 255, 255, 0.4)';
            ctx.fill();
            ctx.closePath();

            // Position numbers
            if (selectedPoints.has(point.id)) {
                const position = pattern.indexOf(point.id) + 1;
                ctx.fillStyle = '#ffffff';
                ctx.font = 'bold 12px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(position, point.x, point.y);
            }
        });
    };

    const getClosestPoint = (x, y) => {
        return points.find(point =>
            Math.sqrt((point.x - x) ** 2 + (point.y - y) ** 2) < pointRadius * 2
        );
    };

    // Function to get coordinates for both touch and mouse events
    function getEventCoordinates(e) {
        e.preventDefault(); // Prevent default touch behavior
        const rect = canvas.getBoundingClientRect();
        
        // Check if it's a touch event
        if (e.touches && e.touches.length > 0) {
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        }
        
        // Otherwise, it's a mouse event
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }

    let isDrawing = false;

    // Combined event handlers for both mouse and touch
    function handleStart(e) {
        isDrawing = true;
        const { x, y } = getEventCoordinates(e);
        const closestPoint = getClosestPoint(x, y);
        
        if (closestPoint && !selectedPoints.has(closestPoint.id)) {
            selectedPoints.add(closestPoint.id);
            pattern.push(closestPoint.id);
            lastPoint = closestPoint;
            drawGrid();
        }
    }

    function handleMove(e) {
        if (!isDrawing) return;
        
        const { x, y } = getEventCoordinates(e);

        currentPoint = { x, y };
        const closestPoint = getClosestPoint(x, y);

        if (closestPoint && !selectedPoints.has(closestPoint.id)) {
            selectedPoints.add(closestPoint.id);
            pattern.push(closestPoint.id);
            lastPoint = closestPoint;
        }

        drawGrid();
        resetButton.style.display = 'block';
    }

    function handleEnd(e) {
        isDrawing = false;
        currentPoint = null;
        patternOutput.textContent = `Pattern: ${pattern.join('-')}`;
    }

    // Mouse event listeners
    canvas.addEventListener('mousedown', handleStart);
    canvas.addEventListener('mousemove', handleMove);
    canvas.addEventListener('mouseup', handleEnd);
    canvas.addEventListener('mouseout', handleEnd);

    // Touch event listeners
    canvas.addEventListener('touchstart', handleStart, { passive: false });
    canvas.addEventListener('touchmove', handleMove, { passive: false });
    canvas.addEventListener('touchend', handleEnd, { passive: false });
    canvas.addEventListener('touchcancel', handleEnd, { passive: false });

    // Existing submit and reset button logic remains the same
    submitButton.addEventListener('click', () => {
        const patternData = pattern.join('-');
        if (patternData) {
            Swal.fire({
                title: 'Verifying Pattern...',
                text: 'Please wait',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    fetch('{{ route("face.recognition.validate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                pattern: patternData
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                isPatternValid = false;
                                resetButton.style.display = 'block';
                                canvas.classList.add('shake');
                                drawGrid();
                            }
                            Swal.fire({
                                icon: data.success ? 'success' : 'error',
                                title: data.success ? 'Success!' : 'Error!',
                                text: data.message,
                                showConfirmButton: true
                            }).then(() => {
                                if(data.success) {
                                    location.href = '/face_recognition'
                                }
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            });

                            resetButton.style.display = 'block';
                        });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No Pattern',
                text: 'Please draw a pattern first.'
            });
        }
    });

    resetButton.addEventListener('click', resetPattern);
    canvas.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        resetPattern();
    });

    drawGrid();

    canvas.addEventListener('mouseover', () => {
        canvas.style.transform = 'scale(1.02)';
    });

    canvas.addEventListener('mouseout', () => {
        canvas.style.transform = 'scale(1)';
    });

    // Prevent scrolling on canvas
    canvas.style.touchAction = 'none';
</script>
</body>

</html>