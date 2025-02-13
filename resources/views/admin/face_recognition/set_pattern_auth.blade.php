@extends('admin.layouts.app')

@section('title', 'WebInn - Set Face Recognition Authentication')
@section('content')

<div class="min-h-screen bg-gradient-to-br from-red-400 to-teal-400 p-4">
    <div class="flex flex-col md:flex-row justify-center items-center gap-6 min-h-[calc(100vh-2rem)]">
        <!-- Current Pattern Card -->
        <div class="w-full max-w-sm p-6 rounded-2xl bg-white/10 backdrop-blur-lg border border-white/20 shadow-lg transform transition-all duration-300 hover:-translate-y-1">
            <h3 class="text-xl text-white text-center mb-6">
                Current Pattern for Face<br>Recognition Security
            </h3>
            <div class="flex justify-center">
                <img src="{{ asset('storage/' . ($pattern->image_path ?? null)) }}" 
                     alt="Current Pattern" 
                     class="rounded-lg max-w-full h-auto" id="curr_pattern">
            </div>
        </div>

        <!-- New Pattern Card -->
        <div class="w-full max-w-sm p-6 rounded-2xl bg-white/10 backdrop-blur-lg border border-white/20 shadow-lg transform transition-all duration-300 hover:-translate-y-1">
            <h3 class="text-xl text-white text-center mb-6">
                Set Pattern for Face<br>Recognition Security
            </h3>
            <div class="flex justify-center">
                <canvas id="patternCanvas" 
                        class="rounded-lg transition-transform duration-300 touch-none"
                        style="max-width: 100%; height: auto;" width="300" height="300">
                </canvas>
            </div>

            <p id="patternOutput" class=" text-white/80 text-center text-sm"></p>
            <div class="flex gap-3 mt-4">
                <button id="submitPattern" 
                        class="flex-1 px-4 py-2 rounded-lg bg-white/20 hover:bg-white/30 text-white transition-all duration-300">
                    Save Pattern
                </button>
                <button id="resetButton" 
                        class="hidden flex-1 px-4 py-2 rounded-lg bg-red-500/30 hover:bg-red-500/40 text-white transition-all duration-300">
                    Reset Pattern
                </button>
            </div>
        </div>
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
    let isDrawing = false;

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

    function getCoordinates(e) {
        const rect = canvas.getBoundingClientRect();
        // Check if it's a touch event or mouse event
        const x = e.touches ? e.touches[0].clientX - rect.left : e.clientX - rect.left;
        const y = e.touches ? e.touches[0].clientY - rect.top : e.clientY - rect.top;
        return { x, y };
    }

    function startDrawing(e) {
        // Prevent default to stop scrolling/zooming
        e.preventDefault();
        isDrawing = true;
        const { x, y } = getCoordinates(e);
        const closestPoint = getClosestPoint(x, y);
        
        if (closestPoint && !selectedPoints.has(closestPoint.id)) {
            selectedPoints.add(closestPoint.id);
            pattern.push(closestPoint.id);
            lastPoint = closestPoint;
            drawGrid();
        }
    }

    function continueDrawing(e) {
        if (!isDrawing) return;
        
        // Prevent default to stop scrolling/zooming
        e.preventDefault();
        const { x, y } = getCoordinates(e);

        currentPoint = {
            x: x,
            y: y
        };
        const closestPoint = getClosestPoint(x, y);

        if (closestPoint && !selectedPoints.has(closestPoint.id)) {
            selectedPoints.add(closestPoint.id);
            pattern.push(closestPoint.id);
            lastPoint = closestPoint;
        }

        drawGrid();
        resetButton.style.display = 'block';
    }

    function stopDrawing(e) {
        isDrawing = false;
        currentPoint = null;
        patternOutput.textContent = `Pattern: ${pattern.join('-')}`;
    }

    // Mouse event listeners
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', continueDrawing);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Touch event listeners
    canvas.addEventListener('touchstart', startDrawing, { passive: false });
    canvas.addEventListener('touchmove', continueDrawing, { passive: false });
    canvas.addEventListener('touchend', stopDrawing);
    canvas.addEventListener('touchcancel', stopDrawing);

    submitButton.addEventListener('click', () => {
        const canvasData = canvas.toDataURL("image/png");
        const patternData = pattern.join('-');
        if (patternData) {
            Swal.fire({
                title: 'Saving Pattern...',
                text: 'Please wait',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    fetch('{{ route("face.recognition.create") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            pattern: patternData,
                            image: canvasData,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#curr_pattern').src = canvasData;

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
                        });
                    })
                    .catch(error => {
                        console.log(error)
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

    // Hover and scale effects
    canvas.addEventListener('mouseover', () => {
        canvas.style.transform = 'scale(1.02)';
    });

    canvas.addEventListener('mouseout', () => {
        canvas.style.transform = 'scale(1)';
    });

    // Initial grid drawing
    drawGrid();
</script>
@endsection