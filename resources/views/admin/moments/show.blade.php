@extends('layouts.admin')

@section('title', $moment->title)

@section('content')
<div class="h-full flex flex-col bg-background-light dark:bg-background-dark overflow-hidden">
    <!-- Header Actions -->
    <div class="z-20 p-4 flex items-center justify-between lg:border-b lg:border-slate-100 lg:dark:border-slate-800 lg:bg-white/50 lg:dark:bg-surface-dark/50 lg:backdrop-blur-md">
        <button onclick="history.back()" class="size-10 rounded-full bg-black/20 lg:bg-slate-100 lg:dark:bg-slate-800 backdrop-blur-md text-white lg:text-slate-600 lg:dark:text-slate-300 flex items-center justify-center hover:bg-black/30 lg:hover:bg-slate-200 lg:dark:hover:bg-slate-700 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </button>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.moments.edit', $moment) }}" class="size-10 rounded-full bg-black/20 lg:bg-slate-100 lg:dark:bg-slate-800 backdrop-blur-md text-white lg:text-slate-600 lg:dark:text-slate-300 flex items-center justify-center hover:bg-black/30 lg:hover:bg-slate-200 lg:dark:hover:bg-slate-700 transition-colors">
                <span class="material-symbols-outlined">edit</span>
            </a>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
        <!-- Left Side: Hero Image / Gallery (Desktop) -->
        <div class="w-full lg:w-[60%] xl:w-[65%] h-auto lg:h-full relative bg-slate-200 dark:bg-slate-800 lg:border-r lg:border-slate-100 lg:dark:border-slate-800">
            <div class="relative w-full aspect-[4/5] sm:aspect-video lg:aspect-auto lg:h-full">
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
                                     
                                <!-- Gradient Overlay (Mobile Only) -->
                                <div class="absolute inset-0 z-20 bg-gradient-to-b from-black/30 via-transparent to-background-light dark:to-background-dark opacity-90 pointer-events-none lg:hidden"></div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($moment->images->count() > 1)
                        <!-- Navigation Arrows -->
                        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/40 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/60 transition-colors">
                            <span class="material-symbols-outlined text-3xl">chevron_left</span>
                        </button>
                        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-black/40 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/60 transition-colors">
                            <span class="material-symbols-outlined text-3xl">chevron_right</span>
                        </button>

                        <!-- Indicators -->
                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                            @foreach($moment->images as $index => $image)
                            <button class="w-2.5 h-2.5 rounded-full bg-white/50 transition-all duration-300 data-[active=true]:bg-white data-[active=true]:w-8" 
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
                        <span class="material-symbols-outlined text-8xl mb-4">image</span>
                        <span class="text-lg">No images available</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Content Body -->
        <main class="flex-1 overflow-y-auto no-scrollbar pb-safe bg-slate-50 dark:bg-background-dark lg:bg-white lg:dark:bg-surface-dark">
            <div class="relative px-5 lg:px-8 py-8 lg:py-10">
                <!-- Header Info -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
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
                            <span class="px-4 py-1.5 rounded-full text-sm font-semibold {{ $badgeClass }}">
                                {{ ucfirst($moment->category) }}
                            </span>
                        @endif
                        
                        <div class="flex items-center gap-2">
                            @if($moment->status == 'in_progress')
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
                                <span class="text-sm font-medium text-slate-500">In Progress</span>
                            @elseif($moment->status == 'completed')
                                <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                                <span class="text-sm font-medium text-slate-500">Completed</span>
                            @endif
                        </div>
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white leading-tight mb-6">{{ $moment->title }}</h1>

                    <!-- Meta Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Date -->
                        <div class="flex items-start gap-3">
                            <div class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">calendar_today</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Date</p>
                                <p class="text-slate-700 dark:text-slate-200 font-medium">{{ $moment->moment_date->format('F j, Y') }}</p>
                                @if($moment->moment_time)
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($moment->moment_time)->format('g:i A') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Location -->
                        @if($moment->location)
                        <div class="flex items-start gap-3">
                            <div class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">location_on</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Location</p>
                                <p class="text-slate-700 dark:text-slate-200 font-medium truncate">{{ $moment->location }}</p>
                                @if($moment->latitude && $moment->longitude)
                                <a href="{{ route('admin.map', ['highlight' => $moment->id]) }}" class="text-sm text-primary hover:underline font-medium">View on Map</a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                @if($moment->description)
                <div class="mb-10">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4">The Story</h3>
                    <div class="prose dark:prose-invert prose-slate max-w-none">
                        <p class="text-lg leading-relaxed text-slate-600 dark:text-slate-300 whitespace-pre-wrap">{{ $moment->description }}</p>
                    </div>
                </div>
                @endif

                <!-- Map Preview (Desktop Only) -->
                @if($moment->latitude && $moment->longitude)
                <div class="mb-10">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4">Map Location</h3>
                    <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-800 h-64 bg-slate-100 relative group">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0" 
                            loading="lazy" 
                            class="filter grayscale hover:grayscale-0 transition-all duration-500"
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $moment->longitude - 0.005 }},{{ $moment->latitude - 0.005 }},{{ $moment->longitude + 0.005 }},{{ $moment->latitude + 0.005 }}&layer=mapnik&marker={{ $moment->latitude }},{{ $moment->longitude }}">
                        </iframe>
                    </div>
                </div>
                @endif

                <!-- Timeline Info -->
                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm text-slate-400">
                    <p>Created {{ $moment->created_at->format('M j, Y') }}</p>
                    <p>Last updated {{ $moment->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </main>
    </div>
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
