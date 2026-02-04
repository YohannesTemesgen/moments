@extends('layouts.admin')

@section('title', 'Edit Moment')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Marker Styles */
    .custom-marker-selected div {
        animation: marker-pulse 2s infinite;
    }
    @keyframes marker-pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(25, 127, 230, 0.4); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(25, 127, 230, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(25, 127, 230, 0); }
    }

    /* SweetAlert2 Desktop Customization */
    .swal2-popup {
        border-radius: 24px !important;
        padding: 2rem !important;
        font-family: 'Inter', sans-serif !important;
    }
    .swal2-title {
        font-weight: 800 !important;
        color: #1e293b !important;
    }
    .swal2-confirm {
        border-radius: 12px !important;
        font-weight: 700 !important;
        padding: 0.75rem 2rem !important;
    }
    .swal2-cancel {
        border-radius: 12px !important;
        font-weight: 700 !important;
        padding: 0.75rem 2rem !important;
    }
</style>
@endsection

@section('content')
<div class="h-full flex flex-col bg-slate-50 dark:bg-background-dark overflow-hidden">
    <!-- Desktop Header -->
    <header class="z-30 bg-white/95 dark:bg-surface-dark/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 p-4 lg:px-8 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.moments.show', $moment) }}" class="lg:hidden size-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Edit Moment</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.moments.show', $moment) }}" class="hidden lg:block px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                Cancel
            </a>
            <button type="submit" form="moment-form" class="px-6 py-2 bg-primary hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-95">
                Save Changes
            </button>
        </div>
    </header>

    <main class="flex-1 overflow-hidden relative">
        <form id="moment-form" method="POST" action="{{ route('admin.moments.update', $moment) }}" enctype="multipart/form-data" class="h-full flex flex-col lg:flex-row overflow-hidden">
            @csrf
            @method('PUT')
            
            <!-- Left Column: Media Management -->
            <div class="w-full lg:w-[45%] xl:w-[40%] h-auto lg:h-full overflow-y-auto no-scrollbar p-5 lg:p-8 lg:border-r lg:border-slate-200 lg:dark:border-slate-800">
                <div class="space-y-8">
                    <!-- Current Gallery -->
                    @if($moment->images->count() > 0)
                    <section id="existing-images">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Current Photos</h3>
                            <span class="text-xs font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md">{{ $moment->images->count() }}</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($moment->images as $image)
                            <div class="relative group rounded-2xl overflow-hidden bg-white dark:bg-surface-dark aspect-square shadow-sm border border-slate-100 dark:border-slate-800">
                                <img src="{{ $image->url }}" alt="Moment image" class="w-full h-full object-cover" 
                                     onerror="this.src='{{ asset('images/placeholder.svg') }}'">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" onclick="removeExistingImage({{ $image->id }}, this)" class="size-10 bg-red-500 text-white rounded-xl flex items-center justify-center transform scale-75 group-hover:scale-100 transition-transform shadow-lg">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- New Upload Area -->
                    <section>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4">Add More Photos</h3>
                        <div id="upload-area" class="relative w-full min-h-[180px] rounded-2xl overflow-hidden bg-white dark:bg-surface-dark group cursor-pointer border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-primary/50 dark:hover:border-primary/50 transition-all duration-300 shadow-sm" onclick="document.getElementById('images').click()">
                            <div id="upload-placeholder" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                                <div class="size-12 bg-slate-50 dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 rounded-xl flex items-center justify-center text-slate-400 mb-3 group-hover:text-primary transition-all">
                                    <span class="material-symbols-outlined text-2xl">add_photo_alternate</span>
                                </div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-200">Upload New</p>
                            </div>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        </div>

                        <!-- New Previews -->
                        <div id="image-gallery" class="hidden mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">New Additions</h3>
                                <button type="button" onclick="clearAllImages()" class="text-xs text-red-500 hover:text-red-600 font-bold uppercase tracking-widest">Clear All</button>
                            </div>
                            <div id="preview-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-4"></div>
                        </div>

                        <!-- Deleted Images Tracking -->
                        <div id="deleted-images"></div>
                    </section>
                </div>
            </div>

            <!-- Right Column: Form Fields -->
            <div class="flex-1 h-full overflow-y-auto no-scrollbar p-5 lg:p-8 bg-white dark:bg-surface-dark lg:bg-transparent lg:dark:bg-transparent">
                <div class="max-w-2xl mx-auto space-y-8">
                    @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-xl text-sm font-medium flex items-center gap-3">
                        <span class="material-symbols-outlined">error</span>
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <!-- Basic Info Section -->
                    <section class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Moment Title *</label>
                            <input name="title" type="text" required value="{{ old('title', $moment->title) }}" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl px-5 py-4 text-lg font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all shadow-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Date *</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">calendar_today</span>
                                    </div>
                                    <input name="moment_date" type="date" required value="{{ old('moment_date', $moment->moment_date->format('Y-m-d')) }}" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl pl-12 pr-5 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all shadow-sm">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Time</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">schedule</span>
                                    </div>
                                    <input name="moment_time" type="time" value="{{ old('moment_time', $moment->moment_time ? \Carbon\Carbon::parse($moment->moment_time)->format('H:i') : '') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl pl-12 pr-5 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Location</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">location_on</span>
                                </div>
                                <input name="location" id="location-input" type="text" value="{{ old('location', $moment->location) }}" placeholder="Add location..." class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl pl-12 pr-24 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all shadow-sm">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center gap-1">
                                    <button type="button" onclick="openMapSelector()" class="p-2 rounded-xl text-slate-400 hover:text-primary hover:bg-primary/5 transition-all" title="Select on map">
                                        <span class="material-symbols-outlined">map</span>
                                    </button>
                                    <button type="button" onclick="getCurrentLocation()" class="p-2 rounded-xl text-slate-400 hover:text-primary hover:bg-primary/5 transition-all" title="Current location">
                                        <span class="material-symbols-outlined">my_location</span>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $moment->latitude) }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $moment->longitude) }}">
                        </div>
                    </section>

                    <!-- Category Section -->
                    <section class="space-y-4">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Category *</label>
                        <div class="flex gap-2 flex-wrap">
                            @foreach(['Events', 'Concert', 'Game', 'Walk', 'Food', 'Shopping', 'Cinema', 'Traveling'] as $cat)
                            <label class="cursor-pointer">
                                <input type="radio" name="category" value="{{ Str::slug($cat) }}" class="hidden peer" {{ old('category', $moment->category) == Str::slug($cat) ? 'checked' : '' }}>
                                <span class="px-5 py-2.5 rounded-xl text-sm font-bold border-2 transition-all inline-block
                                    peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary peer-checked:shadow-lg peer-checked:shadow-primary/20
                                    bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-100 dark:border-slate-700 hover:border-slate-200 dark:hover:border-slate-600">
                                    {{ $cat }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </section>

                    <!-- Description Section -->
                    <section class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">The Story</label>
                        <textarea name="description" rows="6" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-medium text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all shadow-sm resize-none">{{ old('description', $moment->description) }}</textarea>
                    </section>

                    <!-- Danger Zone -->
                    <section class="pt-8 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" onclick="confirmDelete()" class="w-full flex items-center justify-center gap-3 py-4 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-2xl transition-all font-bold group">
                            <span class="material-symbols-outlined group-hover:scale-110 transition-transform">delete_forever</span>
                            Delete this Moment
                        </button>
                    </section>
                </div>
            </div>
        </form>
    </main>
</div>

<form id="delete-form" method="POST" action="{{ route('admin.moments.destroy', $moment) }}" class="hidden">
    @csrf
    @method('DELETE')
</form>

<!-- Map Selection Modal -->
<div id="map-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-md transition-opacity duration-300" onclick="closeMapSelector()"></div>
    <div class="absolute inset-4 lg:inset-20 bg-white dark:bg-surface-dark rounded-3xl shadow-2xl flex flex-col overflow-hidden scale-95 opacity-0 transition-all duration-300" id="map-modal-container">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-white dark:bg-surface-dark z-10">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Pin Location</h2>
                <p class="text-xs text-slate-500 font-medium">Click on the map to set coordinates</p>
            </div>
            <button onclick="closeMapSelector()" class="size-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-500 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Map Container -->
        <div class="flex-1 relative">
            <div id="location-map" class="w-full h-full"></div>
            
            <!-- Search Box -->
            <div class="absolute top-6 left-6 right-6 z-10 max-w-md">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">search</span>
                    </div>
                    <input type="text" id="map-search" placeholder="Search address or city..." class="w-full bg-white/95 dark:bg-surface-dark/95 backdrop-blur-md border border-slate-200 dark:border-slate-700 rounded-2xl pl-12 pr-5 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none shadow-2xl">
                </div>
            </div>
            
            <!-- Current Location Button -->
            <button onclick="centerOnCurrentLocation()" class="absolute bottom-6 right-6 size-14 bg-white dark:bg-surface-dark rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 text-primary flex items-center justify-center hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-90 z-10">
                <span class="material-symbols-outlined text-3xl">my_location</span>
            </button>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-surface-dark/50">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="material-symbols-outlined text-primary text-xl">location_on</span>
                        <p class="text-base font-bold text-slate-900 dark:text-white truncate" id="selected-address">Select a spot on the map</p>
                    </div>
                    <p class="text-xs font-medium text-slate-400 ml-7" id="selected-coords"></p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <button onclick="closeMapSelector()" class="flex-1 md:flex-none px-8 py-3 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </button>
                    <button onclick="confirmLocationSelection()" class="flex-1 md:flex-none px-8 py-3 bg-primary hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-primary/20 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled id="confirm-location-btn">
                        Set Location
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let selectedFiles = [];
let deletedImageIds = [];
let locationMap = null;
let selectedMarker = null;
let selectedLocation = null;

document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('images');
    
    // Drag and drop events
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-primary', 'bg-primary/5');
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('border-primary', 'bg-primary/5');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-primary', 'bg-primary/5');
        processFiles(Array.from(e.dataTransfer.files));
    });
    
    fileInput.addEventListener('change', (e) => processFiles(Array.from(e.target.files)));
});

function processFiles(files) {
    const imageFiles = files.filter(file => file.type.startsWith('image/'));
    if (imageFiles.length === 0) return;
    
    const oversized = imageFiles.filter(file => file.size > 10 * 1024 * 1024);
    if (oversized.length > 0) {
        alert('Some files exceed the 10MB limit.');
        return;
    }
    
    selectedFiles = [...selectedFiles, ...imageFiles];
    updateFileInput();
    generatePreviews();
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    document.getElementById('images').files = dt.files;
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
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'relative group rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 aspect-square shadow-sm';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <button type="button" onclick="removeImage(${index})" class="size-10 bg-red-500 text-white rounded-xl flex items-center justify-center transform scale-75 group-hover:scale-100 transition-transform shadow-lg">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            `;
            previewGrid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
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
        title: 'Remove Photo?',
        text: 'This photo will be removed from this moment permanently.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Remove',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            deletedImageIds.push(imageId);
            const container = document.getElementById('deleted-images');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_images[]';
            input.value = imageId;
            container.appendChild(input);
            
            const item = buttonElement.closest('.relative');
            item.remove();
            
            const remaining = document.querySelectorAll('#existing-images .grid > div').length;
            if (remaining === 0) document.getElementById('existing-images').style.display = 'none';
        }
    });
}

function getCurrentLocation() {
    if (navigator.geolocation) {
        document.getElementById('location-input').placeholder = 'Locating...';
        navigator.geolocation.getCurrentPosition(position => {
            updateLocationInputs(position.coords.latitude, position.coords.longitude);
        }, () => {
            document.getElementById('location-input').placeholder = 'Add location...';
        });
    }
}

function updateLocationInputs(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
        .then(res => res.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('location-input').value = data.display_name.split(',').slice(0, 3).join(',');
            }
        });
}

// Map Logic
function openMapSelector() {
    const modal = document.getElementById('map-modal');
    const container = document.getElementById('map-modal-container');
    modal.classList.remove('hidden');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
    }, 10);
    
    if (!locationMap) initializeMap();
    
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    if (lat && lng) {
        const coords = [parseFloat(lat), parseFloat(lng)];
        locationMap.setView(coords, 15);
        updateMapMarker(coords);
    }
}

function closeMapSelector() {
    const modal = document.getElementById('map-modal');
    const container = document.getElementById('map-modal-container');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

function initializeMap() {
    locationMap = L.map('location-map').setView([9.0054, 38.7636], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(locationMap);
    
    locationMap.on('click', (e) => {
        updateMapMarker([e.latlng.lat, e.latlng.lng]);
    });
    
    const searchInput = document.getElementById('map-search');
    let timeout;
    searchInput.addEventListener('input', (e) => {
        clearTimeout(timeout);
        if (e.target.value.length > 2) {
            timeout = setTimeout(() => searchLocation(e.target.value), 500);
        }
    });
}

function updateMapMarker(coords) {
    if (selectedMarker) locationMap.removeLayer(selectedMarker);
    selectedMarker = L.marker(coords, {
        draggable: true,
        icon: L.divIcon({
            className: 'custom-marker-selected',
            html: '<div class="size-8 bg-primary rounded-full border-4 border-white shadow-2xl"></div>',
            iconSize: [32, 32],
            iconAnchor: [16, 32]
        })
    }).addTo(locationMap);
    
    selectedLocation = { lat: coords[0], lng: coords[1] };
    updateMapDisplay(coords[0], coords[1]);
}

function updateMapDisplay(lat, lng) {
    const addr = document.getElementById('selected-address');
    const coords = document.getElementById('selected-coords');
    const btn = document.getElementById('confirm-location-btn');
    
    addr.textContent = 'Searching address...';
    coords.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    btn.disabled = false;
    
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
        .then(res => res.json())
        .then(data => {
            addr.textContent = data.display_name ? data.display_name.split(',').slice(0, 3).join(',') : 'Unknown location';
        });
}

function searchLocation(query) {
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
        .then(res => res.json())
        .then(data => {
            if (data[0]) {
                const coords = [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                locationMap.setView(coords, 15);
                updateMapMarker(coords);
            }
        });
}

function confirmLocationSelection() {
    if (selectedLocation) {
        document.getElementById('latitude').value = selectedLocation.lat;
        document.getElementById('longitude').value = selectedLocation.lng;
        document.getElementById('location-input').value = document.getElementById('selected-address').textContent;
        closeMapSelector();
    }
}

function centerOnCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const coords = [pos.coords.latitude, pos.coords.longitude];
            locationMap.setView(coords, 15);
            updateMapMarker(coords);
        });
    }
}

function confirmDelete() {
    Swal.fire({
        title: 'Delete this Moment?',
        text: 'This will permanently delete this moment and all associated photos. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete It',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we remove this moment.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endsection