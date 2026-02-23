/* Copyright belongs to Kamalpur Netaji High School (H.S.) Estd 1956 */
const video = document.getElementById('video');
const overlay = document.getElementById('overlay');
const captureCanvas = document.getElementById('capture-canvas');
const startBtn = document.getElementById('start-camera');
const captureBtn = document.getElementById('capture');
const widthInput = document.getElementById('width');
const heightInput = document.getElementById('height');
const maxSizeInput = document.getElementById('max-size');
const cameraSelect = document.getElementById('camera-select');
const presetSelect = document.getElementById('preset-select');
const savePresetBtn = document.getElementById('save-preset');
const deletePresetBtn = document.getElementById('delete-preset');
const swapDimsBtn = document.getElementById('swap-dims');
const bwModeInput = document.getElementById('bw-mode');
const viewportContainer = document.querySelector('.viewport-container');

let stream = null;
let customPresets = JSON.parse(localStorage.getItem('photo-presets') || '[]');

function swapDimensions() {
    const w = widthInput.value;
    const h = heightInput.value;
    widthInput.value = h;
    heightInput.value = w;
    drawOverlay();
}

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
            setTimeout(() => startCamera(true), 100);
        }
    } catch (err) {
        console.error("Error listing cameras:", err);
        alert("Camera access denied or no camera found.");
    }
}

async function startCamera(autoAdjust = false) {
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
            
            const vW = video.videoWidth;
            const vH = video.videoHeight;
            const tW = parseInt(widthInput.value);
            const tH = parseInt(heightInput.value);

            if (autoAdjust) {
                // If camera orientation doesn't match target orientation, swap targets and restart
                if ((vH > vW && tW > tH) || (vW > vH && tH > tW)) {
                    widthInput.value = tH;
                    heightInput.value = tW;
                    // Restart camera with new ideal constraints matching the orientation
                    startCamera(false);
                    return;
                }
            }

            viewportContainer.style.aspectRatio = `${vW}/${vH}`;
            
            // Ensure overlay matches the new video dimensions
            setTimeout(drawOverlay, 300);
        };

    } catch (err) {
        console.error("Error accessing camera: ", err);
        captureBtn.disabled = true;
        alert("Could not start this camera module. It may be in use or unsupported at this resolution.");
    }
}

function drawOverlay() {
    if (!video.videoWidth || !overlay.clientWidth) return;

    const ctx = overlay.getContext('2d');
    const cW = overlay.clientWidth;
    const cH = overlay.clientHeight;
    
    overlay.width = cW;
    overlay.height = cH;

    const vW = video.videoWidth;
    const vH = video.videoHeight;
    
    const targetWidth = parseInt(widthInput.value) || 1920;
    const targetHeight = parseInt(heightInput.value) || 1080;
    
    // Calculate actual video display size (object-fit: contain)
    const displayRatio = Math.min(cW / vW, cH / vH);
    const dW = vW * displayRatio;
    const dH = vH * displayRatio;
    const dX = (cW - dW) / 2;
    const dY = (cH - dH) / 2;

    // Calculate marker rectangle relative to the displayed video
    const rW = targetWidth * displayRatio;
    const rH = targetHeight * displayRatio;

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

function applyBwFilter() {
    if (bwModeInput.checked) {
        video.style.filter = 'grayscale(100%)';
    } else {
        video.style.filter = 'none';
    }
}

async function capturePhoto() {
    const targetWidth = parseInt(widthInput.value) || 1920;
    const targetHeight = parseInt(heightInput.value) || 1080;
    const maxKB = parseInt(maxSizeInput.value) || 500;
    const isBw = bwModeInput.checked;

    captureCanvas.width = targetWidth;
    captureCanvas.height = targetHeight;

    const ctx = captureCanvas.getContext('2d');
    
    const videoWidth = video.videoWidth;
    const videoHeight = video.videoHeight;

    let sourceX = (videoWidth - targetWidth) / 2;
    let sourceY = (videoHeight - targetHeight) / 2;
    let sourceWidth = targetWidth;
    let sourceHeight = targetHeight;

    // Fill background black first
    ctx.fillStyle = '#000';
    ctx.fillRect(0, 0, targetWidth, targetHeight);
    
    // Apply grayscale filter if enabled
    if (isBw) {
        ctx.filter = 'grayscale(100%)';
    } else {
        ctx.filter = 'none';
    }

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
    a.download = `photo_${targetWidth}x${targetHeight}_${Math.round(blob.size/1024)}KB.knhs.jpg`;
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

// Preset Logic
function loadPresets() {
    // Clear current dynamic options (after the first 4 default ones)
    while (presetSelect.options.length > 4) {
        presetSelect.remove(4);
    }
    
    customPresets.forEach((p, index) => {
        const option = document.createElement('option');
        const bwPart = p.bw ? ' (B&W)' : '';
        option.value = `${p.w}x${p.h}x${p.size}x${p.bw ? 1 : 0}`;
        option.text = `${p.name} (${p.w}x${p.h}, ${p.size}KB)${bwPart}`;
        presetSelect.appendChild(option);
    });
}

function savePreset() {
    const name = prompt("Enter a name for this preset:");
    if (!name) return;

    const w = parseInt(widthInput.value);
    const h = parseInt(heightInput.value);
    const size = parseInt(maxSizeInput.value);
    const bw = bwModeInput.checked;

    const newPreset = { name, w, h, size, bw };
    customPresets.push(newPreset);
    localStorage.setItem('photo-presets', JSON.stringify(customPresets));
    
    loadPresets();
    presetSelect.value = `${w}x${h}x${size}x${bw ? 1 : 0}`;
    deletePresetBtn.style.display = 'inline-block';
}

function deletePreset() {
    const val = presetSelect.value;
    if (!val) return;

    // Default presets are the first 4 (0 to 3 index in options)
    // and they aren't in customPresets array
    const selectedIndex = presetSelect.selectedIndex;
    if (selectedIndex <= 3) {
        alert("Cannot delete default presets.");
        return;
    }

    if (!confirm("Are you sure you want to delete this preset?")) return;

    // Custom presets starts at index 4 in select, 0 in customPresets
    const customIndex = selectedIndex - 4;
    customPresets.splice(customIndex, 1);
    localStorage.setItem('photo-presets', JSON.stringify(customPresets));
    
    loadPresets();
    presetSelect.value = '';
    deletePresetBtn.style.display = 'none';
}

function applyPreset() {
    const val = presetSelect.value;
    if (!val) {
        deletePresetBtn.style.display = 'none';
        return;
    }

    const [w, h, size, bw] = val.split('x');
    widthInput.value = w;
    heightInput.value = h;
    maxSizeInput.value = size;
    bwModeInput.checked = bw === '1';
    
    // Show delete button only for custom presets (index > 3)
    if (presetSelect.selectedIndex > 3) {
        deletePresetBtn.style.display = 'inline-block';
    } else {
        deletePresetBtn.style.display = 'none';
    }

    applyBwFilter();
    startCamera();
}

startBtn.addEventListener('click', () => startCamera(false));
captureBtn.addEventListener('click', capturePhoto);
cameraSelect.addEventListener('change', () => startCamera(true));
presetSelect.addEventListener('change', applyPreset);
savePresetBtn.addEventListener('click', savePreset);
deletePresetBtn.addEventListener('click', deletePreset);
swapDimsBtn.addEventListener('click', swapDimensions);
bwModeInput.addEventListener('change', () => {
    presetSelect.value = ''; // Reset to manual
    deletePresetBtn.style.display = 'none';
    applyBwFilter();
});

// Redraw overlay when inputs change or window resizes
[widthInput, heightInput].forEach(el => el.addEventListener('input', () => {
    presetSelect.value = ''; // Reset to manual
    deletePresetBtn.style.display = 'none';
    drawOverlay();
}));
maxSizeInput.addEventListener('input', () => {
    presetSelect.value = ''; // Reset to manual
    deletePresetBtn.style.display = 'none';
    drawOverlay();
});
window.addEventListener('resize', drawOverlay);

// Start on load
getCameras();
loadPresets();
applyBwFilter();
