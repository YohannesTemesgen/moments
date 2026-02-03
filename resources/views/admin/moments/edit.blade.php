<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Moment</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "background-light": "#ffffff",
                        "background-dark": "#111921",
                        "surface-light": "#f8fafc",
                        "surface-dark": "#1c2126",
                        "surface-dark-highlight": "#2a323b",
                        "accent": "#f1f5f9",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Mobile-first SweetAlert2 Styles */
        .swal2-mobile-popup {
            width: 90% !important;
            max-width: 400px !important;
            margin: 0 auto !important;
            border-radius: 16px !important;
            padding: 24px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        }
        
        .swal2-mobile-title {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: #1f2937 !important;
            margin-bottom: 12px !important;
            line-height: 1.3 !important;
        }
        
        .swal2-mobile-text {
            font-size: 15px !important;
            color: #6b7280 !important;
            line-height: 1.5 !important;
            margin-bottom: 24px !important;
        }
        
        .swal2-mobile-confirm {
            background-color: #ef4444 !important;
            color: white !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 14px 24px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            min-height: 48px !important;
            margin: 0 6px !important;
            transition: all 0.2s ease !important;
        }
        
        .swal2-mobile-confirm:hover {
            background-color: #dc2626 !important;
            transform: translateY(-1px) !important;
        }
        
        .swal2-mobile-cancel {
            background-color: #f3f4f6 !important;
            color: #6b7280 !important;
            border: 1px solid #d1d5db !important;
            border-radius: 12px !important;
            padding: 14px 24px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            min-height: 48px !important;
            margin: 0 6px !important;
            transition: all 0.2s ease !important;
        }
        
        .swal2-mobile-cancel:hover {
            background-color: #e5e7eb !important;
            border-color: #9ca3af !important;
            transform: translateY(-1px) !important;
        }
        
        .swal2-actions {
            margin-top: 24px !important;
            gap: 12px !important;
            flex-direction: column-reverse !important;
        }
        
        @media (min-width: 640px) {
            .swal2-actions {
                flex-direction: row !important;
            }
        }
        
        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
            font-size: 24px !important;
        }
        
        .swal2-icon.swal2-info {
            border-color: #197fe6 !important;
            color: #197fe6 !important;
        }
        
        /* Loading spinner customization */
        .swal2-loader {
            border-color: #197fe6 transparent #197fe6 transparent !important;
        }
        
        /* Debug info styles */
        .debug-info {
            position: fixed;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 9999;
            max-width: 300px;
            display: none;
        }
    </style>
</head>
<body class="bg-background-light font-display text-slate-900 overflow-hidden h-screen w-full flex flex-col relative">
<header class="absolute top-0 left-0 right-0 z-30 pt-safe transition-colors duration-300 pointer-events-none">
    <div class="bg-white/95 backdrop-blur-md border-b border-slate-100 pb-3 pt-3 px-4 flex items-center justify-between pointer-events-auto shadow-sm">
        <a href="{{ route('admin.timeline') }}" class="text-base font-medium text-slate-500 hover:text-slate-800 px-2 py-1 -ml-2">
            Cancel
        </a>
        <h1 class="text-base font-bold tracking-tight text-slate-900">Edit Moment</h1>
        <button type="submit" form="moment-form" class="text-base font-semibold text-primary hover:text-blue-600 px-2 py-1 -mr-2">
            Save
        </button>
    </div>
</header>

<main class="flex-1 w-full h-full overflow-y-auto pt-[60px] pb-24 bg-slate-50 no-scrollbar">
    <form id="moment-form" method="POST" action="{{ route('admin.moments.update', $moment) }}" enctype="multipart/form-data" class="max-w-md mx-auto px-4 space-y-6 py-6">
        @csrf
        @method('PUT')
        
        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Multiple Image Upload -->
        <div class="space-y-4">
            <!-- Upload Area -->
            <div id="upload-area" class="relative w-full min-h-[200px] rounded-2xl overflow-hidden shadow-sm bg-slate-100 group cursor-pointer border-2 border-dashed border-slate-300 hover:border-primary/50 transition-all duration-300" onclick="document.getElementById('images').click()">
                <div id="upload-placeholder" class="absolute inset-0 flex flex-col items-center justify-center p-6">
                    <div class="bg-white shadow-lg border border-slate-200 rounded-full p-4 text-slate-400 mb-3 group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                        <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                    </div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Click or drag photos here</p>
                    <p class="text-xs text-slate-400">JPG, PNG up to 10MB each • Multiple files supported</p>
                </div>
                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
            </div>

            <!-- Upload Progress -->
            <div id="upload-progress" class="hidden space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-slate-700">Uploading images...</span>
                    <span id="progress-text" class="text-slate-500">0%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                    <div id="progress-bar" class="h-full bg-gradient-to-r from-primary to-blue-500 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                </div>
            </div>

            <!-- Existing Images -->
            @if($moment->images->count() > 0)
            <div id="existing-images">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-700">Current Images</h3>
                    <span class="text-xs text-slate-500">{{ $moment->images->count() }} {{ Str::plural('image', $moment->images->count()) }}</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($moment->images as $image)
                    <div class="relative group rounded-xl overflow-hidden bg-slate-100 aspect-square">
                        <img src="{{ $image->url }}" alt="Moment image" class="w-full h-full object-cover" 
                             onerror="handleImageError(this, '{{ $image->url }}', '{{ $image->image_path }}', {{ $image->id }})"
                             onload="console.log('Image loaded successfully:', '{{ $image->url }}')">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <button type="button" onclick="removeExistingImage({{ $image->id }}, this)" class="opacity-0 group-hover:opacity-100 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-all duration-200 transform scale-90 hover:scale-100">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </div>
                        <div class="absolute bottom-2 left-2 right-2">
                            <div class="bg-black/60 backdrop-blur text-white text-xs px-2 py-1 rounded truncate">
                                {{ basename($image->image_path) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- New Image Preview Gallery -->
            <div id="image-gallery" class="hidden">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-700">New Images</h3>
                    <button type="button" onclick="clearAllImages()" class="text-xs text-red-500 hover:text-red-600 font-medium">Clear All</button>
                </div>
                <div id="preview-grid" class="grid grid-cols-2 gap-3"></div>
            </div>

            <!-- Hidden inputs for deleted images -->
            <div id="deleted-images"></div>
        </div>

        <div class="space-y-5">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">Moment Title *</label>
                <input name="title" type="text" required value="{{ old('title', $moment->title) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-sm hover:border-slate-300">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">Location</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">location_on</span>
                    </div>
                    <input name="location" type="text" value="{{ old('location', $moment->location) }}" placeholder="Add location..." class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-20 py-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-sm hover:border-slate-300">
                    <div class="absolute inset-y-0 right-0 pr-2 flex items-center gap-1">
                        <button type="button" onclick="openMapSelector()" class="p-1.5 rounded-lg text-slate-400 hover:text-primary hover:bg-slate-100 transition-colors" title="Select on map">
                            <span class="material-symbols-outlined text-[20px]">map</span>
                        </button>
                        <button type="button" onclick="getCurrentLocation()" class="p-1.5 rounded-lg text-slate-400 hover:text-primary hover:bg-slate-100 transition-colors" title="Use current location">
                            <span class="material-symbols-outlined text-[20px]">my_location</span>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $moment->latitude) }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $moment->longitude) }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">Date *</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors text-[20px]">calendar_today</span>
                        </div>
                        <input name="moment_date" type="date" required value="{{ old('moment_date', $moment->moment_date->format('Y-m-d')) }}" class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm font-medium text-slate-900 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-sm hover:border-slate-300">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">Time</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors text-[20px]">schedule</span>
                        </div>
                        <input name="moment_time" type="time" value="{{ old('moment_time', $moment->moment_time ? \Carbon\Carbon::parse($moment->moment_time)->format('H:i') : '') }}" class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm font-medium text-slate-900 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-sm hover:border-slate-300">
                    </div>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">Description</label>
                <textarea name="description" rows="4" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-sm resize-none hover:border-slate-300">{{ old('description', $moment->description) }}</textarea>
            </div>

            <div class="space-y-1.5 pb-4">
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">Category *</label>
                <div class="flex gap-2 flex-wrap">
                    @foreach(['Events', 'Concert', 'Game', 'Walk', 'Food', 'Shopping', 'Cinema', 'Traveling'] as $cat)
                    <label class="cursor-pointer">
                        <input type="radio" name="category" value="{{ Str::slug($cat) }}" class="hidden peer" {{ old('category', $moment->category) == Str::slug($cat) ? 'checked' : '' }}>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-medium border transition-colors peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:border-primary/20 bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50">{{ $cat }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Delete Button -->
            <div class="pt-4 border-t border-slate-200">
                <button type="button" onclick="confirmDelete()" class="w-full flex items-center justify-center gap-2 py-3 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                    <span class="material-symbols-outlined">delete</span>
                    <span class="font-medium">Delete Moment</span>
                </button>
            </div>
        </div>
    </form>
    
    <form id="delete-form" method="POST" action="{{ route('admin.moments.destroy', $moment) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</main>


<!-- Map Selection Modal -->
<div id="map-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeMapSelector()"></div>
    <div class="absolute inset-4 bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-900">Select Location</h2>
            <button onclick="closeMapSelector()" class="p-2 rounded-full hover:bg-slate-100 transition-colors">
                <span class="material-symbols-outlined text-slate-600">close</span>
            </button>
        </div>
        
        <!-- Map Container -->
        <div class="flex-1 relative">
            <div id="location-map" class="w-full h-full"></div>
            
            <!-- Search Box -->
            <div class="absolute top-4 left-4 right-4 z-10">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400">search</span>
                    </div>
                    <input type="text" id="map-search" placeholder="Search for a location..." class="w-full bg-white/95 backdrop-blur border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none shadow-lg">
                </div>
            </div>
            
            <!-- Current Location Button -->
            <button onclick="centerOnCurrentLocation()" class="absolute bottom-20 right-4 p-3 bg-white rounded-full shadow-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-primary">my_location</span>
            </button>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            <div class="flex items-center justify-between mb-3">
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-700" id="selected-address">Click on the map to select a location</p>
                    <p class="text-xs text-slate-500" id="selected-coords"></p>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="closeMapSelector()" class="flex-1 py-3 px-4 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-xl transition-colors">
                    Cancel
                </button>
                <button onclick="confirmLocationSelection()" class="flex-1 py-3 px-4 bg-primary hover:bg-blue-600 text-white font-medium rounded-xl transition-colors" disabled id="confirm-location-btn">
                    Confirm Location
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let selectedFiles = [];
let deletedImageIds = [];
let locationMap = null;
let selectedMarker = null;
let selectedLocation = null;

// Debug variables
let imageErrors = [];
let debugMode = {{ config('app.debug') ? 'true' : 'false' }};

// Image error handling and debugging
function handleImageError(imgElement, originalUrl, imagePath, imageId) {
    const errorInfo = {
        imageId: imageId,
        originalUrl: originalUrl,
        imagePath: imagePath,
        timestamp: new Date().toISOString(),
        userAgent: navigator.userAgent,
        currentDomain: window.location.origin,
        publicUrl: '{{ asset("") }}/',
        assetUrl: '{{ asset("") }}'
    };
    
    imageErrors.push(errorInfo);
    
    // Log to console
    console.error('Image loading failed:', errorInfo);
    
    // Try alternative URLs
    const alternatives = [
        '{{ asset("") }}/' + imagePath,
        '{{ url("") }}/' + imagePath,
        '/' + imagePath,
        originalUrl.replace(/^https?:\/\/[^\/]+/, window.location.origin)
    ];
    
    let attemptIndex = 0;
    
    function tryNextUrl() {
        if (attemptIndex < alternatives.length) {
            const nextUrl = alternatives[attemptIndex];
            console.log(`Trying alternative URL ${attemptIndex + 1}:`, nextUrl);
            
            const testImg = new Image();
            testImg.onload = function() {
                console.log('Alternative URL worked:', nextUrl);
                imgElement.src = nextUrl;
            };
            testImg.onerror = function() {
                console.log('Alternative URL failed:', nextUrl);
                attemptIndex++;
                tryNextUrl();
            };
            testImg.src = nextUrl;
        } else {
            // All alternatives failed, use placeholder
            console.log('All alternatives failed, using placeholder');
            imgElement.src = '{{ asset("images/placeholder.svg") }}';
            imgElement.onerror = null;
            
            // Show debug info if in debug mode
            if (debugMode) {
                showDebugInfo(errorInfo);
            }
        }
    }
    
    tryNextUrl();
}

// Show debug information
function showDebugInfo(errorInfo) {
    let debugDiv = document.getElementById('debug-info');
    if (!debugDiv) {
        debugDiv = document.createElement('div');
        debugDiv.id = 'debug-info';
        debugDiv.className = 'debug-info';
        document.body.appendChild(debugDiv);
    }
    
    debugDiv.innerHTML = `
        <h4>Image Loading Debug Info</h4>
        <p><strong>Image ID:</strong> ${errorInfo.imageId}</p>
        <p><strong>Original URL:</strong> ${errorInfo.originalUrl}</p>
        <p><strong>Image Path:</strong> ${errorInfo.imagePath}</p>
        <p><strong>Public URL:</strong> ${errorInfo.publicUrl}</p>
        <p><strong>Asset URL:</strong> ${errorInfo.assetUrl}</p>
        <p><strong>Current Domain:</strong> ${errorInfo.currentDomain}</p>
        <p><strong>Total Errors:</strong> ${imageErrors.length}</p>
        <button onclick="copyDebugInfo()" style="margin-top: 10px; padding: 5px 10px;">Copy Debug Info</button>
        <button onclick="hideDebugInfo()" style="margin-top: 10px; margin-left: 5px; padding: 5px 10px;">Hide</button>
    `;
    
    debugDiv.style.display = 'block';
}

// Copy debug info to clipboard
function copyDebugInfo() {
    const debugText = JSON.stringify({
        errors: imageErrors,
        environment: {
            url: window.location.href,
            userAgent: navigator.userAgent,
            timestamp: new Date().toISOString()
        }
    }, null, 2);
    
    navigator.clipboard.writeText(debugText).then(() => {
        alert('Debug info copied to clipboard!');
    }).catch(() => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = debugText;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        alert('Debug info copied to clipboard!');
    });
}

// Hide debug info
function hideDebugInfo() {
    const debugDiv = document.getElementById('debug-info');
    if (debugDiv) {
        debugDiv.style.display = 'none';
    }
}

// Check public directory configuration on page load
function checkPublicConfiguration() {
    console.log('=== PUBLIC DIRECTORY CONFIGURATION DEBUG ===');
    console.log('Public directory URL:', '{{ asset("") }}/');
    console.log('Asset URL:', '{{ asset("") }}');
    console.log('App URL:', '{{ config("app.url") }}');
    console.log('Environment:', '{{ config("app.env") }}');
    console.log('Debug mode:', debugMode);
    
    // Test if public directory is accessible
    fetch('{{ asset("test") }}')
        .then(response => {
            console.log('Public directory accessibility test response:', response.status);
        })
        .catch(error => {
            console.error('Public directory accessibility test failed:', error);
        });
}

// Initialize drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('images');
    
    // Drag and drop events
    uploadArea.addEventListener('dragover', handleDragOver);
    uploadArea.addEventListener('dragleave', handleDragLeave);
    uploadArea.addEventListener('drop', handleDrop);
    
    // File input change event
    fileInput.addEventListener('change', handleFileSelect);
    
    // Initialize debugging
    checkPublicConfiguration();
});

function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    const uploadArea = document.getElementById('upload-area');
    uploadArea.classList.add('border-primary', 'bg-primary/5');
    uploadArea.classList.remove('border-slate-300');
}

function handleDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    const uploadArea = document.getElementById('upload-area');
    uploadArea.classList.remove('border-primary', 'bg-primary/5');
    uploadArea.classList.add('border-slate-300');
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    const uploadArea = document.getElementById('upload-area');
    uploadArea.classList.remove('border-primary', 'bg-primary/5');
    uploadArea.classList.add('border-slate-300');
    
    const files = Array.from(e.dataTransfer.files);
    processFiles(files);
}

function handleFileSelect(e) {
    const files = Array.from(e.target.files);
    processFiles(files);
}

function processFiles(files) {
    // Filter for image files only
    const imageFiles = files.filter(file => file.type.startsWith('image/'));
    
    if (imageFiles.length === 0) {
        alert('Please select valid image files (JPG, PNG, etc.)');
        return;
    }
    
    // Check file sizes (10MB limit)
    const oversizedFiles = imageFiles.filter(file => file.size > 10 * 1024 * 1024);
    if (oversizedFiles.length > 0) {
        alert(`Some files are too large. Maximum size is 10MB per file.`);
        return;
    }
    
    // Add new files to selected files array
    selectedFiles = [...selectedFiles, ...imageFiles];
    
    // Update file input with all selected files
    updateFileInput();
    
    // Show progress and start "upload" simulation
    simulateUpload();
    
    // Generate previews
    generatePreviews();
}

function updateFileInput() {
    const fileInput = document.getElementById('images');
    const dt = new DataTransfer();
    
    selectedFiles.forEach(file => {
        dt.items.add(file);
    });
    
    fileInput.files = dt.files;
}

function simulateUpload() {
    const progressContainer = document.getElementById('upload-progress');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    
    progressContainer.classList.remove('hidden');
    
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
            setTimeout(() => {
                progressContainer.classList.add('hidden');
            }, 1000);
        }
        
        progressBar.style.width = progress + '%';
        progressText.textContent = Math.round(progress) + '%';
    }, 200);
}

function generatePreviews() {
    const gallery = document.getElementById('image-gallery');
    const previewGrid = document.getElementById('preview-grid');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    
    if (selectedFiles.length === 0) {
        gallery.classList.add('hidden');
        uploadPlaceholder.classList.remove('hidden');
        return;
    }
    
    gallery.classList.remove('hidden');
    uploadPlaceholder.classList.add('hidden');
    previewGrid.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = createPreviewItem(e.target.result, file.name, index);
            previewGrid.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    });
}

function createPreviewItem(src, filename, index) {
    const div = document.createElement('div');
    div.className = 'relative group rounded-xl overflow-hidden bg-slate-100 aspect-square';
    div.innerHTML = `
        <img src="${src}" alt="${filename}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
            <button type="button" onclick="removeImage(${index})" class="opacity-0 group-hover:opacity-100 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-all duration-200 transform scale-90 hover:scale-100">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
        <div class="absolute bottom-2 left-2 right-2">
            <div class="bg-black/60 backdrop-blur text-white text-xs px-2 py-1 rounded truncate">
                ${filename}
            </div>
        </div>
    `;
    return div;
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    updateFileInput();
    generatePreviews();
}

function clearAllImages() {
    selectedFiles = [];
    updateFileInput();
    generatePreviews();
}

function removeExistingImage(imageId, buttonElement) {
    Swal.fire({
        title: 'Remove Image?',
        text: 'Are you sure you want to remove this image? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Remove',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'swal2-mobile-popup',
            title: 'swal2-mobile-title',
            htmlContainer: 'swal2-mobile-text',
            confirmButton: 'swal2-mobile-confirm',
            cancelButton: 'swal2-mobile-cancel'
        },
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Add to deleted images array
            deletedImageIds.push(imageId);
            
            // Create hidden input for deleted image
            const deletedImagesContainer = document.getElementById('deleted-images');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_images[]';
            hiddenInput.value = imageId;
            deletedImagesContainer.appendChild(hiddenInput);
            
            // Remove the image element from DOM using the button element reference
            const imageContainer = buttonElement.closest('.relative');
            if (imageContainer) {
                imageContainer.remove();
            }
            
            // Update existing images count
            const existingImagesContainer = document.getElementById('existing-images');
            const remainingImages = existingImagesContainer.querySelectorAll('.grid > .relative').length;
            
            if (remainingImages === 0) {
                existingImagesContainer.style.display = 'none';
            } else {
                const countSpan = existingImagesContainer.querySelector('.text-xs.text-slate-500');
                if (countSpan) {
                    countSpan.textContent = `${remainingImages} ${remainingImages === 1 ? 'image' : 'images'}`;
                }
            }
            
            // Show success message
            Swal.fire({
                title: 'Removed!',
                text: 'The image has been removed.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal2-mobile-popup',
                    title: 'swal2-mobile-title',
                    htmlContainer: 'swal2-mobile-text'
                }
            });
        }
    });
}

// Get current location manually
function getCurrentLocation() {
    if (navigator.geolocation) {
        const locationInput = document.querySelector('input[name="location"]');
        locationInput.placeholder = 'Getting location...';
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                // Reverse geocode to get address
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            const address = data.display_name.split(',').slice(0, 3).join(',');
                            locationInput.value = address;
                            locationInput.placeholder = 'Add location...';
                        }
                    })
                    .catch(() => {
                        locationInput.placeholder = 'Add location...';
                    });
            },
            function(error) {
                locationInput.placeholder = 'Add location...';
                alert('Unable to get your location. Please check your location permissions.');
            }
        );
    } else {
        alert('Geolocation is not supported by this browser.');
    }
}

// Open map selector modal
function openMapSelector() {
    const modal = document.getElementById('map-modal');
    modal.classList.remove('hidden');
    
    // Initialize map if not already done
    if (!locationMap) {
        initializeLocationMap();
    }
    
    // Center on current location if available
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    
    if (lat && lng) {
        locationMap.setView([parseFloat(lat), parseFloat(lng)], 15);
        if (selectedMarker) {
            locationMap.removeLayer(selectedMarker);
        }
        selectedMarker = L.marker([parseFloat(lat), parseFloat(lng)], {
            draggable: true,
            icon: L.divIcon({
                className: 'custom-marker-selected',
                html: '<div class="w-8 h-8 bg-primary rounded-full border-4 border-white shadow-lg"></div>',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            })
        }).addTo(locationMap);
        
        selectedMarker.on('dragend', function(e) {
            const position = e.target.getLatLng();
            updateSelectedLocation(position.lat, position.lng);
        });
        
        selectedLocation = { lat: parseFloat(lat), lng: parseFloat(lng) };
        updateLocationDisplay(parseFloat(lat), parseFloat(lng));
    } else {
        // Default to a general location (you can change this)
        locationMap.setView([9.0054, 38.7636], 10);
    }
}

// Initialize the location selection map
function initializeLocationMap() {
    locationMap = L.map('location-map', {
        zoomControl: true
    }).setView([9.0054, 38.7636], 10);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(locationMap);
    
    // Add click event to map
    locationMap.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        // Remove existing marker
        if (selectedMarker) {
            locationMap.removeLayer(selectedMarker);
        }
        
        // Add new marker
        selectedMarker = L.marker([lat, lng], {
            draggable: true,
            icon: L.divIcon({
                className: 'custom-marker-selected',
                html: '<div class="w-8 h-8 bg-primary rounded-full border-4 border-white shadow-lg"></div>',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            })
        }).addTo(locationMap);
        
        selectedMarker.on('dragend', function(e) {
            const position = e.target.getLatLng();
            updateSelectedLocation(position.lat, position.lng);
        });
        
        selectedLocation = { lat, lng };
        updateLocationDisplay(lat, lng);
    });
    
    // Add search functionality
    const searchInput = document.getElementById('map-search');
    let searchTimeout;
    
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();
        
        if (query.length > 2) {
            searchTimeout = setTimeout(() => {
                searchLocation(query);
            }, 500);
        }
    });
}

// Search for location
function searchLocation(query) {
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const result = data[0];
                const lat = parseFloat(result.lat);
                const lng = parseFloat(result.lon);
                
                locationMap.setView([lat, lng], 15);
                
                // Remove existing marker
                if (selectedMarker) {
                    locationMap.removeLayer(selectedMarker);
                }
                
                // Add new marker
                selectedMarker = L.marker([lat, lng], {
                    draggable: true,
                    icon: L.divIcon({
                        className: 'custom-marker-selected',
                        html: '<div class="w-8 h-8 bg-primary rounded-full border-4 border-white shadow-lg"></div>',
                        iconSize: [32, 32],
                        iconAnchor: [16, 32]
                    })
                }).addTo(locationMap);
                
                selectedMarker.on('dragend', function(e) {
                    const position = e.target.getLatLng();
                    updateSelectedLocation(position.lat, position.lng);
                });
                
                selectedLocation = { lat, lng };
                updateLocationDisplay(lat, lng);
            }
        })
        .catch(error => {
            console.error('Search failed:', error);
        });
}

// Update selected location
function updateSelectedLocation(lat, lng) {
    selectedLocation = { lat, lng };
    updateLocationDisplay(lat, lng);
}

// Update location display in modal
function updateLocationDisplay(lat, lng) {
    const addressElement = document.getElementById('selected-address');
    const coordsElement = document.getElementById('selected-coords');
    const confirmBtn = document.getElementById('confirm-location-btn');
    
    addressElement.textContent = 'Getting address...';
    coordsElement.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    confirmBtn.disabled = false;
    
    // Reverse geocode
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                addressElement.textContent = data.display_name.split(',').slice(0, 3).join(',');
            } else {
                addressElement.textContent = 'Unknown location';
            }
        })
        .catch(() => {
            addressElement.textContent = 'Unknown location';
        });
}

// Center map on current location
function centerOnCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            locationMap.setView([lat, lng], 15);
            
            // Remove existing marker
            if (selectedMarker) {
                locationMap.removeLayer(selectedMarker);
            }
            
            // Add new marker
            selectedMarker = L.marker([lat, lng], {
                draggable: true,
                icon: L.divIcon({
                    className: 'custom-marker-selected',
                    html: '<div class="w-8 h-8 bg-primary rounded-full border-4 border-white shadow-lg"></div>',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32]
                })
            }).addTo(locationMap);
            
            selectedMarker.on('dragend', function(e) {
                const position = e.target.getLatLng();
                updateSelectedLocation(position.lat, position.lng);
            });
            
            selectedLocation = { lat, lng };
            updateLocationDisplay(lat, lng);
        });
    }
}

// Confirm location selection
function confirmLocationSelection() {
    if (selectedLocation) {
        document.getElementById('latitude').value = selectedLocation.lat;
        document.getElementById('longitude').value = selectedLocation.lng;
        
        const addressElement = document.getElementById('selected-address');
        document.querySelector('input[name="location"]').value = addressElement.textContent;
        
        closeMapSelector();
    }
}

// Close map selector modal
function closeMapSelector() {
    const modal = document.getElementById('map-modal');
    modal.classList.add('hidden');
    
    // Clear search input
    document.getElementById('map-search').value = '';
    
    // Reset modal state
    document.getElementById('selected-address').textContent = 'Click on the map to select a location';
    document.getElementById('selected-coords').textContent = '';
    document.getElementById('confirm-location-btn').disabled = true;
}

function confirmDelete() {
    Swal.fire({
        title: 'Delete Moment?',
        text: 'This action cannot be undone. All photos and data will be permanently removed.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            popup: 'swal2-mobile-popup',
            title: 'swal2-mobile-title',
            htmlContainer: 'swal2-mobile-text',
            confirmButton: 'swal2-mobile-confirm',
            cancelButton: 'swal2-mobile-cancel'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        allowEscapeKey: true,
        focusConfirm: false,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete your moment.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal2-mobile-popup',
                    title: 'swal2-mobile-title',
                    htmlContainer: 'swal2-mobile-text'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit the delete form
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
<style>
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .img-loading-container {
        position: relative;
        overflow: hidden;
        background-color: #e2e8f0;
    }
    .dark .img-loading-container {
        background-color: #1e293b;
    }
    .img-loading-container::after {
        content: "";
        position: absolute;
        inset: 0;
        transform: translateX(-100%);
        background-image: linear-gradient(90deg, transparent 0, rgba(255, 255, 255, 0.2) 20%, rgba(255, 255, 255, 0.5) 60%, transparent 100%);
        animation: shimmer 2s infinite;
    }
    .dark .img-loading-container::after {
        background-image: linear-gradient(90deg, transparent 0, rgba(255, 255, 255, 0.05) 20%, rgba(255, 255, 255, 0.1) 60%, transparent 100%);
    }
    .img-loading {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
</style>
<script>
    function onImageLoad(img) {
        img.classList.remove('img-loading', 'opacity-0');
        img.parentElement.classList.remove('img-loading-container');
    }
</script>
</body>
</html>
