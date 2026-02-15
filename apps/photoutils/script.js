const video = document.getElementById('video');
const overlay = document.getElementById('overlay');
const captureCanvas = document.getElementById('capture-canvas');
const startBtn = document.getElementById('start-camera');
const captureBtn = document.getElementById('capture');
const widthInput = document.getElementById('width');
const heightInput = document.getElementById('height');
const maxSizeInput = document.getElementById('max-size');
const cameraSelect = document.getElementById('camera-select');

let stream = null;

// Initialize camera list
async function getCameras() {
    try {
        await navigator.mediaDevices.getUserMedia({ video: true }); // Request permission first
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(device => device.kind === 'videoinput');
        
        cameraSelect.innerHTML = '';
        videoDevices.forEach((device, index) => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Camera ${index + 1}`;
            cameraSelect.appendChild(option);
        });

        if (videoDevices.length > 0) {
            startCamera(); // Auto-start with default camera
        }
    } catch (err) {
        console.error("Error listing cameras:", err);
    }
}

async function startCamera() {
    try {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        const deviceId = cameraSelect.value;
        const constraints = {
            video: {
                deviceId: deviceId ? { exact: deviceId } : undefined,
                width: { ideal: parseInt(widthInput.value) || 1920 },
                height: { ideal: parseInt(heightInput.value) || 1080 }
            }
        };

        stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        
        video.onloadedmetadata = () => {
            video.play();
            captureBtn.disabled = false;
            // Force a slight delay to ensure video dimensions are available
            setTimeout(drawOverlay, 100);
        };

    } catch (err) {
        console.error("Error accessing camera: ", err);
        alert("Could not access camera. Please ensure permissions are granted.");
    }
}

function drawOverlay() {
    if (!video.videoWidth) return;

    const ctx = overlay.getContext('2d');
    const containerWidth = overlay.clientWidth;
    const containerHeight = overlay.clientHeight;
    
    overlay.width = containerWidth;
    overlay.height = containerHeight;

    const targetWidth = parseInt(widthInput.value) || 1920;
    const targetHeight = parseInt(heightInput.value) || 1080;
    const targetRatio = targetWidth / targetHeight;
    
    const viewportRatio = containerWidth / containerHeight;

    let rectWidth, rectHeight;

    if (targetRatio > viewportRatio) {
        rectWidth = containerWidth * 0.9;
        rectHeight = rectWidth / targetRatio;
    } else {
        rectHeight = containerHeight * 0.8;
        rectWidth = rectHeight * targetRatio;
    }

    const x = (containerWidth - rectWidth) / 2;
    const y = (containerHeight - rectHeight) / 2;

    ctx.clearRect(0, 0, containerWidth, containerHeight);
    
    // Dim background
    ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
    ctx.fillRect(0, 0, containerWidth, containerHeight);
    
    // Clear the rectangle area
    ctx.globalCompositeOperation = 'destination-out';
    ctx.fillRect(x, y, rectWidth, rectHeight);
    ctx.globalCompositeOperation = 'source-over';

    // Draw border
    ctx.strokeStyle = '#fec90d'; // Use theme accent
    ctx.lineWidth = 3;
    ctx.strokeRect(x, y, rectWidth, rectHeight);

    // Add resolution text
    ctx.fillStyle = '#fec90d';
    ctx.font = '14px Arial';
    ctx.fillText(`${targetWidth} x ${targetHeight}`, x, y - 10);
}

async function capturePhoto() {
    const targetWidth = parseInt(widthInput.value) || 1920;
    const targetHeight = parseInt(heightInput.value) || 1080;
    const maxKB = parseInt(maxSizeInput.value) || 500;

    captureCanvas.width = targetWidth;
    captureCanvas.height = targetHeight;

    const ctx = captureCanvas.getContext('2d');
    
    const videoWidth = video.videoWidth;
    const videoHeight = video.videoHeight;
    const videoRatio = videoWidth / videoHeight;
    const targetRatio = targetWidth / targetHeight;

    let sourceX = 0, sourceY = 0, sourceWidth = videoWidth, sourceHeight = videoHeight;

    if (videoRatio > targetRatio) {
        // Video is wider than target crop
        sourceWidth = videoHeight * targetRatio;
        sourceX = (videoWidth - sourceWidth) / 2;
    } else {
        // Video is taller than target crop
        sourceHeight = videoWidth / targetRatio;
        sourceY = (videoHeight - sourceHeight) / 2;
    }

    // Fill background black first
    ctx.fillStyle = '#000';
    ctx.fillRect(0, 0, targetWidth, targetHeight);
    
    // Draw cropped image
    ctx.drawImage(video, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, targetWidth, targetHeight);

    // Iterative quality reduction to meet file size
    let quality = 0.95;
    let blob = await getBlob(captureCanvas, 'image/jpeg', quality);
    
    while (blob.size / 1024 > maxKB && quality > 0.1) {
        quality -= 0.05;
        blob = await getBlob(captureCanvas, 'image/jpeg', quality);
    }

    // Download the photo
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `photo_${targetWidth}x${targetHeight}_${Math.round(blob.size/1024)}KB.jpg`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function getBlob(canvas, type, quality) {
    return new Promise((resolve) => {
        canvas.toBlob((blob) => resolve(blob), type, quality);
    });
}

startBtn.addEventListener('click', startCamera);
captureBtn.addEventListener('click', capturePhoto);
cameraSelect.addEventListener('change', startCamera);

// Redraw overlay when inputs change or window resizes
[widthInput, heightInput].forEach(el => el.addEventListener('input', drawOverlay));
window.addEventListener('resize', drawOverlay);

// Start on load
getCameras();
