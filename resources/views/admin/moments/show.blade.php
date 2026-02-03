@extends('layouts.admin')

@section('title', $moment->title)

@section('content')
<div class="h-full flex flex-col bg-background-light dark:bg-background-dark overflow-hidden">
    <!-- Header Actions (Absolute) -->
    <div class="absolute top-0 left-0 right-0 z-20 p-4 flex items-center justify-between pointer-events-none">
        <button onclick="history.back()" class="pointer-events-auto size-10 rounded-full bg-black/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/30 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </button>
        
        <div class="flex items-center gap-2 pointer-events-auto">
            <a href="{{ route('admin.moments.edit', $moment) }}" class="size-10 rounded-full bg-black/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/30 transition-colors">
                <span class="material-symbols-outlined">edit</span>
            </a>
        </div>
    </div>

    <!-- Main Scrollable Content -->
    <main class="flex-1 overflow-y-auto no-scrollbar pb-safe">
        <!-- Hero Image / Gallery -->
        <div class="relative w-full aspect-[4/5] sm:aspect-video bg-slate-200 dark:bg-slate-800">
            @if($moment->images->count() > 0)
                <div class="carousel-container w-full h-full relative overflow-hidden touch-pan-y" id="main-carousel">
                    <div class="carousel-track flex h-full overflow-x-auto snap-x snap-mandatory no-scrollbar scroll-smooth">
                        @foreach($moment->images as $image)
                        <div class="carousel-slide min-w-full h-full relative overflow-hidden bg-slate-900 snap-start">
                            <!-- Blurred Background -->
                            <div class="absolute inset-0 bg-cover bg-center blur-2xl scale-110 opacity-50" 
                                 style="background-image: url('{{ $image->url }}')"></div>
                            
                            <!-- Main Image -->
                            <img src="{{ $image->url }}" 
                                 alt="{{ $moment->title }}" 
                                 class="w-full h-full object-contain relative z-10"
                                 onclick="openLightbox('{{ $image->url }}')"
                                 onerror="this.src='{{ asset('images/placeholder.svg') }}'">
                                 
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 z-20 bg-gradient-to-b from-black/30 via-transparent to-background-light dark:to-background-dark opacity-90 pointer-events-none"></div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($moment->images->count() > 1)
                    <!-- Navigation Arrows -->
                    <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-black/20 backdrop-blur-md text-white hidden md:flex items-center justify-center hover:bg-black/40 transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-black/20 backdrop-blur-md text-white hidden md:flex items-center justify-center hover:bg-black/40 transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>

                    <!-- Indicators -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                        @foreach($moment->images as $index => $image)
                        <button class="w-2 h-2 rounded-full bg-white/50 transition-all duration-300 data-[active=true]:bg-white data-[active=true]:w-6" 
                                onclick="goToSlide({{ $index }})"
                                data-index="{{ $index }}"
                                data-active="{{ $index === 0 ? 'true' : 'false' }}">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
            @else
                <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400">
                    <span class="material-symbols-outlined text-6xl mb-2">image</span>
                    <span class="text-sm">No images available</span>
                </div>
            @endif
        </div>

        <!-- Content Body -->
        <div class="relative px-5 -mt-6 z-10">
            <!-- Title Card -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-xl p-5 mb-6 border border-slate-100 dark:border-slate-800">
                <div class="flex items-start justify-between gap-4 mb-2">
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white leading-tight">{{ $moment->title }}</h1>
                    @if($moment->category)
                        @php
                            $categoryColors = [
                                'milestone' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                'celebration' => 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400',
                                'travel' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'everyday' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                'special' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                            ];
                            $catKey = strtolower($moment->category);
                            $badgeClass = 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400';
                            
                            foreach($categoryColors as $key => $class) {
                                if(str_contains($catKey, $key)) {
                                    $badgeClass = $class;
                                    break;
                                }
                            }
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap {{ $badgeClass }}">
                            {{ ucfirst($moment->category) }}
                        </span>
                    @endif
                </div>

                <!-- Date & Time -->
                <div class="flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-4">
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        <span>{{ $moment->moment_date->format('F j, Y') }}</span>
                    </div>
                    @if($moment->moment_time)
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">schedule</span>
                        <span>{{ \Carbon\Carbon::parse($moment->moment_time)->format('g:i A') }}</span>
                    </div>
                    @endif
                </div>

                <!-- Location -->
                @if($moment->location)
                <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-50 dark:bg-surface-dark-highlight/50 border border-slate-100 dark:border-slate-700/50">
                    <span class="material-symbols-outlined text-primary mt-0.5">location_on</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $moment->location }}</p>
                        @if($moment->latitude && $moment->longitude)
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            {{ number_format($moment->latitude, 4) }}, {{ number_format($moment->longitude, 4) }}
                        </p>
                        @endif
                    </div>
                    @if($moment->latitude && $moment->longitude)
                    <a href="{{ route('admin.map', ['highlight' => $moment->id]) }}" class="text-xs font-medium text-primary hover:underline whitespace-nowrap px-2 py-1">
                        View Map
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <!-- Description -->
            @if($moment->description)
            <div class="mb-8">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3 px-1">The Story</h3>
                <div class="prose dark:prose-invert prose-slate max-w-none">
                    <p class="text-base leading-relaxed text-slate-600 dark:text-slate-300 whitespace-pre-wrap">{{ $moment->description }}</p>
                </div>
            </div>
            @endif

            <!-- Map Preview -->
            @if($moment->latitude && $moment->longitude)
            <div class="mb-8 rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-800 h-48 bg-slate-100 relative group">
                <iframe 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    style="border:0" 
                    loading="lazy" 
                    class="filter grayscale hover:grayscale-0 transition-all duration-500"
                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $moment->longitude - 0.01 }},{{ $moment->latitude - 0.01 }},{{ $moment->longitude + 0.01 }},{{ $moment->latitude + 0.01 }}&layer=mapnik&marker={{ $moment->latitude }},{{ $moment->longitude }}">
                </iframe>
                <div class="absolute inset-0 pointer-events-none ring-1 ring-inset ring-black/10 rounded-2xl"></div>
            </div>
            @endif

            <!-- Metadata Footer -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-white dark:bg-surface-dark p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Status</span>
                    <div class="flex items-center gap-2 mt-1">
                        @if($moment->status == 'in_progress')
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">In Progress</span>
                        @elseif($moment->status == 'completed')
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Completed</span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Draft</span>
                        @endif
                    </div>
                </div>
                <div class="bg-white dark:bg-surface-dark p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Created</span>
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mt-1">{{ $moment->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        
        <!-- Bottom Spacer for Tab Bar -->
        <div class="h-20"></div>
    </main>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-50 bg-black/95 hidden flex flex-col opacity-0 transition-opacity duration-300">
    <div class="absolute top-4 right-4 z-50">
        <button onclick="closeLightbox()" class="size-10 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-white/20">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <div class="flex-1 flex items-center justify-center p-4">
        <img id="lightbox-img" src="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl scale-95 transition-transform duration-300">
    </div>
</div>

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
    /* Specific override for show page main image to avoid background color issue with object-contain */
    .bg-transparent.img-loading-container {
        background-color: transparent !important;
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
<script>
    // Carousel Logic
    let currentSlide = 0;
    const totalSlides = {{ $moment->images->count() }};
    const track = document.querySelector('.carousel-track');
    const dots = document.querySelectorAll('[data-index]');
    
    function updateDots(index) {
        dots.forEach(dot => {
            if (parseInt(dot.dataset.index) === index) {
                dot.dataset.active = 'true';
            } else {
                dot.dataset.active = 'false';
            }
        });
    }

    function goToSlide(index) {
        if (!track) return;
        const width = track.offsetWidth;
        track.scrollTo({
            left: width * index,
            behavior: 'smooth'
        });
    }

    // Scroll Listener for snapping updates
    if (track) {
        track.addEventListener('scroll', () => {
            const index = Math.round(track.scrollLeft / track.offsetWidth);
            if (currentSlide !== index) {
                currentSlide = index;
                updateDots(index);
            }
        }, { passive: true });
    }

    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            goToSlide(currentSlide + 1);
        } else {
            goToSlide(0);
        }
    }

    function prevSlide() {
        if (currentSlide > 0) {
            goToSlide(currentSlide - 1);
        } else {
            goToSlide(totalSlides - 1);
        }
    }

    // Lightbox Logic
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');

    function openLightbox(url) {
        lightboxImg.src = url;
        lightbox.classList.remove('hidden');
        // Trigger reflow
        void lightbox.offsetWidth;
        lightbox.classList.remove('opacity-0');
        lightboxImg.classList.remove('scale-95');
    }

    function closeLightbox() {
        lightbox.classList.add('opacity-0');
        lightboxImg.classList.add('scale-95');
        setTimeout(() => {
            lightbox.classList.add('hidden');
            lightboxImg.src = '';
        }, 300);
    }
</script>
@endsection
