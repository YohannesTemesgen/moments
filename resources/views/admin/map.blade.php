@extends('layouts.admin')

@section('title', 'Map View')

@section('content')
<header class="absolute top-0 left-0 right-0 z-30 pt-safe transition-colors duration-300 pointer-events-none">
    <div class="bg-gradient-to-b from-white/90 via-white/50 to-transparent dark:from-black/80 dark:via-black/40 dark:to-transparent pb-6 pt-3 px-4 flex items-center justify-between pointer-events-auto">
        <div class="flex items-center gap-3">
            <div class="relative group cursor-pointer shadow-sm">
                <div class="aspect-square rounded-full size-10 ring-2 ring-white dark:ring-slate-700 shadow-md overflow-hidden img-loading-container">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=197fe6&color=fff" class="w-full h-full object-cover img-loading" onload="onImageLoad(this)">
                </div>
            </div>
            <h1 class="text-xl font-bold tracking-tight drop-shadow-sm text-slate-900 dark:text-white">Map View</h1>
        </div>
        <div class="flex gap-2">
            <button class="flex items-center justify-center size-10 rounded-full bg-white/80 dark:bg-surface-dark/80 backdrop-blur-md shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-surface-dark transition-colors text-slate-600 dark:text-slate-300">
                <span class="material-symbols-outlined">filter_list</span>
            </button>
            <button class="flex items-center justify-center size-10 rounded-full bg-white/80 dark:bg-surface-dark/80 backdrop-blur-md shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-surface-dark transition-colors text-slate-600 dark:text-slate-300">
                <span class="material-symbols-outlined">search</span>
            </button>
        </div>
    </div>
</header>

<main class="flex-1 relative w-full h-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
    <!-- Map Background -->
    <div class="absolute inset-0 w-full h-full z-0">
        <div id="map" class="w-full h-full"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>
    </div>
    
    @if($moments->count() == 0)
    <!-- Empty State -->
    <div class="absolute inset-0 flex items-center justify-center z-10">
        <div class="text-center px-4">
            <div class="w-20 h-20 bg-white/80 dark:bg-surface-dark/80 backdrop-blur rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-4xl text-slate-400">location_off</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300">No locations yet</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Add moments with locations to see them on the map.</p>
        </div>
    </div>
    @endif

    <!-- Bottom Card Slider -->
    @if($moments->count() > 0)
    <div class="absolute bottom-4 left-0 right-0 z-30 pb-8">
        <div class="px-4">
            <div id="cards-container" class="flex gap-3 overflow-x-auto scrollbar-hide pb-2 snap-x snap-mandatory">
                @foreach($moments as $index => $moment)
                <div class="moment-card shrink-0 w-80 bg-white dark:bg-surface-dark rounded-2xl p-3 shadow-xl border border-slate-100 dark:border-slate-800/50 flex gap-3 snap-center transition-all duration-300 {{ $index == 0 ? 'ring-2 ring-primary/30' : '' }}" data-index="{{ $index }}">
                    <div class="shrink-0 size-20 rounded-xl overflow-hidden bg-slate-200 dark:bg-slate-800 relative group cursor-pointer">
                        <div class="w-full h-full img-loading-container transition-transform group-hover:scale-105">
                            <img src="{{ $moment->images->count() > 0 ? $moment->images->first()->url : asset('images/placeholder.jpg') }}" class="w-full h-full object-cover img-loading" onload="onImageLoad(this)" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                        </div>
                        @if($moment->images->count() > 1)
                        <div class="absolute top-1 right-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded-full">
                            +{{ $moment->images->count() - 1 }}
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 flex flex-col justify-center min-w-0">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $moment->title }}</h3>
                            <span class="text-[10px] font-medium px-1.5 py-0.5 rounded bg-green-500/10 text-green-600 dark:text-green-400 shrink-0">{{ $moment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="mb-1">
                            @php
                                $categoryColors = [
                                    'events' => 'text-blue-600 bg-blue-500/10 dark:text-blue-400',
                                    'concert' => 'text-purple-600 bg-purple-500/10 dark:text-purple-400',
                                    'game' => 'text-red-600 bg-red-500/10 dark:text-red-400',
                                    'walk' => 'text-emerald-600 bg-emerald-500/10 dark:text-emerald-400',
                                    'food' => 'text-amber-600 bg-amber-500/10 dark:text-amber-400',
                                    'shopping' => 'text-pink-600 bg-pink-500/10 dark:text-pink-400',
                                    'cinema' => 'text-indigo-600 bg-indigo-500/10 dark:text-indigo-400',
                                    'traveling' => 'text-cyan-600 bg-cyan-500/10 dark:text-cyan-400',
                                ];
                                $catSlug = Str::slug($moment->category ?? 'general');
                                $catColorClass = $categoryColors[$catSlug] ?? 'text-slate-600 bg-slate-500/10 dark:text-slate-400';
                            @endphp
                            <span class="text-[10px] font-medium px-1.5 py-0.5 rounded {{ $catColorClass }} capitalize">
                                {{ $moment->category ?? 'General' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-2">{{ $moment->description }}</p>
                        <div class="flex items-center gap-3 text-[10px] text-slate-400 dark:text-slate-500">
                            <div class="flex items-center gap-1 min-w-0">
                                <span class="material-symbols-outlined text-[12px] shrink-0">location_on</span>
                                <span class="break-words leading-tight">{{ $moment->location }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">schedule</span>
                                <span>{{ $moment->moment_date->format('M j') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between shrink-0 pl-2 border-l border-slate-100 dark:border-slate-800">
                        <a href="{{ route('admin.moments.show', $moment) }}" class="size-8 flex items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-surface-dark-highlight text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                        <button class="size-8 flex items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-surface-dark-highlight text-slate-400 transition-colors">
                            <span class="material-symbols-outlined text-[18px] filled">bookmark</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-center mt-3 gap-1.5">
            @foreach($moments as $index => $moment)
            <button onclick="showMoment({{ $index }})" class="moment-dot w-1.5 h-1.5 rounded-full {{ $index == 0 ? 'bg-slate-800 dark:bg-white' : 'bg-slate-400 dark:bg-slate-600' }} shadow-sm transition-colors"></button>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Gallery Overlay -->
    <div id="gallery-overlay" class="absolute inset-0 z-40 bg-black/10 hidden overflow-y-auto" style="clip-path: circle(0% at 50% 50%);" onclick="closeGallery()">
        <div class="min-h-full p-6">
            <button onclick="closeGallery()" class="fixed top-6 right-6 z-50 p-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors shadow-lg">
                <span class="material-symbols-outlined">close</span>
            </button>
            <div class="max-w-7xl mx-auto pt-12">
                <div id="gallery-grid" class="flex gap-4 overflow-x-auto scrollbar-hide pb-4">
                    <!-- Images will be injected here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="fixed inset-0 z-[60] bg-black/80 backdrop-blur-md hidden flex items-center justify-center cursor-zoom-out opacity-0 transition-opacity duration-300" onclick="closeLightbox()">
        <img id="lightbox-image" src="" alt="Full screen" class="max-w-[95%] max-h-[95vh] object-contain rounded-lg shadow-2xl transform transition-transform duration-300 scale-95" onclick="event.stopPropagation()">
    </div>
</main>

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

@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const moments = @json($moments);
    let currentIndex = 0;
    let map, markers = [];

    const categoryColors = {
        'events': '#2563eb', // blue-600
        'concert': '#9333ea', // purple-600
        'game': '#dc2626', // red-600
        'walk': '#059669', // emerald-600
        'food': '#d97706', // amber-600
        'shopping': '#db2777', // pink-600
        'cinema': '#4f46e5', // indigo-600
        'traveling': '#0891b2', // cyan-600
        'default': '#475569' // slate-600
    };

    function getCategoryColor(category) {
        if (!category) return categoryColors['default'];
        const slug = category.toLowerCase().replace(/\s+/g, '-');
        return categoryColors[slug] || categoryColors['default'];
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        const defaultLat = moments.length > 0 && moments[0].latitude ? moments[0].latitude : 9.0054;
        const defaultLng = moments.length > 0 && moments[0].longitude ? moments[0].longitude : 38.7636;
        
        map = L.map('map', {
            zoomControl: false
        }).setView([defaultLat, defaultLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);

        // Add markers with enhanced styling
        moments.forEach((moment, index) => {
            if (moment.latitude && moment.longitude) {
                const hasImage = moment.images && moment.images.length > 0;
                const imageUrl = hasImage ? moment.images[0].url : '{{ asset("images/placeholder.jpg") }}';
                const imageCount = moment.images ? moment.images.length : 0;
                const catColor = getCategoryColor(moment.category);
                
                const marker = L.marker([moment.latitude, moment.longitude], {
                    icon: L.divIcon({
                        className: 'custom-marker',
                        html: `<div class="marker-container relative">
                            <div class="marker-frame w-14 h-14 rounded-2xl overflow-hidden border-3 ${index === currentIndex ? 'scale-110 shadow-xl' : 'shadow-lg'} bg-white cursor-pointer transition-all duration-300 hover:scale-105" 
                                 style="border-color: ${catColor}; ${index === currentIndex ? `box-shadow: 0 20px 25px -5px ${catColor}66` : ''}">
                                <div class="w-full h-full bg-cover bg-center" style="background-image: url('${imageUrl}')"></div>
                                ${imageCount > 1 ? `<div class="absolute -top-1 -right-1 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-md" style="background-color: ${catColor}">${imageCount}</div>` : ''}
                            </div>
                            <div class="pin-point absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-white border-2 rounded-full shadow-sm" style="border-color: ${catColor}"></div>
                        </div>`,
                        iconSize: [56, 64],
                        iconAnchor: [28, 64]
                    })
                }).addTo(map);
                
                marker.on('click', (e) => {
                    showMoment(index);
                    expandGallery(index, e);
                });
                markers.push(marker);
            }
        });

        // Add scroll event listener for cards
        const cardsContainer = document.getElementById('cards-container');
        if (cardsContainer) {
            cardsContainer.addEventListener('scroll', handleCardScroll);
        }

        // Check for highlight parameter
        const urlParams = new URLSearchParams(window.location.search);
        const highlightId = urlParams.get('highlight');
        
        if (highlightId) {
            const index = moments.findIndex(m => m.id == highlightId);
            if (index !== -1) {
                setTimeout(() => {
                    showMoment(index);
                }, 100);
            }
        }
    });

    function showMoment(index) {
        currentIndex = index;
        const moment = moments[index];
        const catColor = getCategoryColor(moment.category);
        
        // Update card highlights
        document.querySelectorAll('.moment-card').forEach((card, i) => {
            if (i === index) {
                card.classList.add('ring-2');
                card.style.setProperty('--tw-ring-color', catColor + '4D'); // 30% opacity
                card.style.borderColor = catColor + '80'; // 50% opacity
            } else {
                card.classList.remove('ring-2');
                card.style.removeProperty('--tw-ring-color');
                card.style.borderColor = '';
            }
        });
        
        // Scroll to the selected card
        const cardsContainer = document.getElementById('cards-container');
        const targetCard = document.querySelector(`.moment-card[data-index="${index}"]`);
        if (cardsContainer && targetCard) {
            // Calculate the scroll position to center the card
            const containerWidth = cardsContainer.clientWidth;
            const cardWidth = targetCard.offsetWidth;
            const cardOffsetLeft = targetCard.offsetLeft;
            const gap = 12; // 3 * 4px (gap-3 in Tailwind)
            
            // Center the card in the container
            const scrollLeft = cardOffsetLeft - (containerWidth / 2) + (cardWidth / 2);
            
            // Ensure we don't scroll past the boundaries
            const maxScroll = cardsContainer.scrollWidth - containerWidth;
            const finalScrollLeft = Math.max(0, Math.min(scrollLeft, maxScroll));
            
            cardsContainer.scrollTo({ 
                left: finalScrollLeft, 
                behavior: 'smooth' 
            });
        }
        
        // Update dots
        document.querySelectorAll('.moment-dot').forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-slate-400', 'dark:bg-slate-600');
                dot.style.backgroundColor = catColor;
            } else {
                dot.style.backgroundColor = '';
                dot.classList.add('bg-slate-400', 'dark:bg-slate-600');
            }
        });
        
        // Update markers
        markers.forEach((marker, i) => {
            const markerElement = marker.getElement();
            if (markerElement) {
                const markerDiv = markerElement.querySelector('.marker-frame');
                const m = moments[i];
                const cColor = getCategoryColor(m.category);
                
                if (markerDiv) {
                    if (i === index) {
                        markerDiv.classList.add('scale-110', 'shadow-xl');
                        markerDiv.classList.remove('shadow-lg');
                        markerDiv.style.boxShadow = `0 20px 25px -5px ${cColor}66`;
                    } else {
                        markerDiv.classList.remove('scale-110', 'shadow-xl');
                        markerDiv.classList.add('shadow-lg');
                        markerDiv.style.boxShadow = '';
                    }
                    // Always keep the border color
                    markerDiv.style.borderColor = cColor;
                }
                
                const pinElement = markerElement.querySelector('.pin-point');
                if (pinElement) {
                    pinElement.style.borderColor = cColor;
                }
            }
        });
        
        // Center map
        if (moment.latitude && moment.longitude) {
            map.panTo([moment.latitude, moment.longitude]);
        }
    }

    function handleCardScroll() {
        const cardsContainer = document.getElementById('cards-container');
        if (!cardsContainer) return;
        
        const cards = document.querySelectorAll('.moment-card');
        const containerRect = cardsContainer.getBoundingClientRect();
        const containerCenter = containerRect.left + containerRect.width / 2;
        
        let closestIndex = 0;
        let closestDistance = Infinity;
        
        cards.forEach((card, index) => {
            const cardRect = card.getBoundingClientRect();
            const cardCenter = cardRect.left + cardRect.width / 2;
            const distance = Math.abs(containerCenter - cardCenter);
            
            if (distance < closestDistance) {
                closestDistance = distance;
                closestIndex = index;
            }
        });
        
        if (closestIndex !== currentIndex) {
            showMoment(closestIndex);
        }
    }

    let lastClickX = '50%';
    let lastClickY = '50%';

    function expandGallery(index, event) {
        const moment = moments[index];
        const overlay = document.getElementById('gallery-overlay');
        const grid = document.getElementById('gallery-grid');
        
        // Populate images
        grid.innerHTML = '';
        if (moment.images && moment.images.length > 0) {
            moment.images.forEach(image => {
                const imgDiv = document.createElement('div');
                imgDiv.className = 'shrink-0 w-40 aspect-square rounded-xl overflow-hidden cursor-pointer hover:scale-105 transition-transform shadow-md group relative';
                imgDiv.innerHTML = `
                    <img src="${image.url}" class="w-full h-full object-cover" loading="lazy" alt="Gallery image">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                `;
                imgDiv.onclick = (e) => {
                    e.stopPropagation();
                    openLightbox(image.url);
                };
                grid.appendChild(imgDiv);
            });
        } else {
             grid.innerHTML = '<p class="w-full text-center text-slate-500">No images available for this moment.</p>';
        }
        
        // Calculate click position for animation origin
        if (event && event.containerPoint) {
            lastClickX = event.containerPoint.x + 'px';
            lastClickY = event.containerPoint.y + 'px';
        }
        
        // Reset clip-path to start from click position
        overlay.style.transition = 'none';
        overlay.style.clipPath = `circle(0% at ${lastClickX} ${lastClickY})`;
        
        // Show overlay
        overlay.classList.remove('hidden');
        
        // Force reflow
        overlay.offsetHeight;
        
        // Animate expand
        overlay.style.transition = 'clip-path 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
        overlay.style.clipPath = `circle(150% at ${lastClickX} ${lastClickY})`;
    }

    function closeGallery() {
        const overlay = document.getElementById('gallery-overlay');
        
        overlay.style.transition = 'clip-path 0.5s ease-in-out';
        overlay.style.clipPath = `circle(0% at ${lastClickX} ${lastClickY})`;
        
        setTimeout(() => {
            overlay.classList.add('hidden');
        }, 500);
    }

    function openLightbox(url) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-image');
        
        img.src = url;
        lightbox.classList.remove('hidden');
        
        // Animation
        requestAnimationFrame(() => {
            lightbox.classList.remove('opacity-0');
            img.classList.remove('scale-95', 'opacity-0');
            img.classList.add('scale-100', 'opacity-100');
        });
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-image');
        
        lightbox.classList.add('opacity-0');
        img.classList.remove('scale-100', 'opacity-100');
        img.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            lightbox.classList.add('hidden');
            img.src = '';
        }, 300);
    }
</script>
<style>
    .custom-marker { background: transparent !important; border: none !important; }
    .leaflet-container { background: #1c2126; }
    
    /* Scrollable cards styling */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    /* Enhanced marker styling */
    .marker-container {
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
    }
    
    /* Card animations */
    .moment-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .moment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Snap scroll behavior */
    #cards-container {
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
    }
    
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Border width utility */
    .border-3 {
        border-width: 3px;
    }
</style>
@endsection
