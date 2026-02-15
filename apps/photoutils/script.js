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
        // First, check for permissions
        const initialStream = await navigator.mediaDevices.getUserMedia({ video: true });
        initialStream.getTracks().forEach(track => track.stop()); // Release the dummy stream

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
            // Wait a bit for the select to update
            setTimeout(() => startCamera(), 100);
        }
    } catch (err) {
        console.error("Error listing cameras:", err);
        alert("Camera access denied or no camera found.");
    }
}

async function startCamera() {
    try {
        captureBtn.disabled = true; // Disable until new stream is ready
        
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }

        const deviceId = cameraSelect.value;
        const wIdeal = parseInt(widthInput.value) || 1920;
        const hIdeal = parseInt(heightInput.value) || 1080;

        const constraints = {
            video: {
                deviceId: deviceId ? { exact: deviceId } : undefined,
                width: { ideal: wIdeal },
                height: { ideal: hIdeal }
            }
        };

        stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        
        video.onloadedmetadata = () => {
            video.play();
            captureBtn.disabled = false;
            // Ensure overlay matches the new video dimensions
            setTimeout(drawOverlay, 300);
        };

    } catch (err) {
        console.error("Error accessing camera: ", err);
        alert("Could not start this camera module. It may be in use or unsupported at this resolution.");
    }
}

function drawOverlay() {
    if (!video.videoWidth) return;

    const ctx = overlay.getContext('2d');
    const cW = overlay.clientWidth;
    const cH = overlay.clientHeight;
    
    overlay.width = cW;
    overlay.height = cH;

    const vW = video.videoWidth;
    const vH = video.videoHeight;
    
    const targetWidth = parseInt(widthInput.value) || 1920;
    const targetHeight = parseInt(heightInput.value) || 1080;
    const tRatio = targetWidth / targetHeight;
    
    // Calculate actual video display size (object-fit: contain)
    const displayRatio = Math.min(cW / vW, cH / vH);
    const dW = vW * displayRatio;
    const dH = vH * displayRatio;
    const dX = (cW - dW) / 2;
    const dY = (cH - dH) / 2;

    // Calculate crop rectangle relative to the displayed video
    let rW, rH;
    const vRatio = vW / vH;

    if (vRatio > tRatio) {
        // Video is wider than target format
        rH = dH;
        rW = dH * tRatio;
    } else {
        // Video is taller than target format
        rW = dW;
        rH = dW / tRatio;
    }

    const rX = dX + (dW - rW) / 2;
    const rY = dY + (dH - rH) / 2;

    ctx.clearRect(0, 0, cW, cH);
    
    // 1. Semi-transparent black over whole canvas
    ctx.fillStyle = 'rgba(0, 0, 0, 0.6)';
    ctx.fillRect(0, 0, cW, cH);
    
    // 2. Clear out the crop rectangle
    ctx.globalCompositeOperation = 'destination-out';
    ctx.fillRect(rX, rY, rW, rH);
    ctx.globalCompositeOperation = 'source-over';

    // 3. Draw border around crop rectangle
    ctx.strokeStyle = '#fec90d';
    ctx.lineWidth = 3;
    ctx.strokeRect(rX, rY, rW, rH);

    // 4. Draw outer border of actual video stream (optional but helpful)
    ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
    ctx.lineWidth = 1;
    ctx.strokeRect(dX, dY, dW, dH);

    // Resolution text
    ctx.fillStyle = '#fec90d';
    ctx.font = 'bold 16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(`${targetWidth} x ${targetHeight}`, rX + rW/2, rY - 10);
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
