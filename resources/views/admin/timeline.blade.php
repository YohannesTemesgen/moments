@extends('layouts.admin')

@section('title', 'Timeline')

@section('content')
<style>
    /* Auto-scroll carousel styles */
    .carousel-container {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .carousel-track {
        display: flex;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .carousel-slide {
        min-width: 100%;
        height: 100%;
        flex-shrink: 0;
    }
    .carousel-dots {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
        z-index: 10;
    }
    .carousel-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        transition: all 0.3s ease;
    }
    .carousel-dot.active {
        background: white;
        width: 18px;
        border-radius: 3px;
    }
    /* Category color mapping */
    .category-milestone { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .category-celebration { background: linear-gradient(135deg, #ec4899, #db2777); }
    .category-travel { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .category-everyday { background: linear-gradient(135deg, #10b981, #059669); }
    .category-special { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .category-default { background: linear-gradient(135deg, #6b7280, #4b5563); }
</style>

<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800/50 transition-colors duration-300">
    <div class="flex items-center justify-between px-4 py-3 max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <div class="relative group cursor-pointer">
                <div class="aspect-square rounded-full size-10 ring-2 ring-primary/20 shadow-lg overflow-hidden img-loading-container">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=197fe6&color=fff" class="w-full h-full object-cover img-loading" onload="onImageLoad(this)">
                </div>
                <div class="absolute bottom-0 right-0 size-3 bg-green-500 rounded-full border-2 border-background-light dark:border-background-dark ring-2 ring-green-500/20"></div>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Timeline</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Your memories</p>
            </div>
        </div>
        <button class="flex items-center justify-center size-10 rounded-xl bg-slate-100 dark:bg-surface-dark hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-slate-600 dark:text-slate-400">
            <span class="material-symbols-outlined text-[22px]">search</span>
        </button>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28">
    @forelse($moments as $date => $dateMoments)
    <div class="relative w-full max-w-lg mx-auto {{ !$loop->first ? 'mt-1' : '' }}">
        <!-- Sticky Section Header -->
        <div class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-xl px-4 py-3">
            <div class="flex items-center gap-2">
                <div class="size-2 rounded-full {{ \Carbon\Carbon::parse($date)->isToday() ? 'bg-primary animate-pulse' : 'bg-slate-400 dark:bg-slate-600' }}"></div>
                <h3 class="text-sm font-semibold tracking-wide {{ \Carbon\Carbon::parse($date)->isToday() ? 'text-primary' : 'text-slate-600 dark:text-slate-400' }}">
                    @if(\Carbon\Carbon::parse($date)->isToday())
                        Today, {{ \Carbon\Carbon::parse($date)->format('M d') }}
                    @elseif(\Carbon\Carbon::parse($date)->isYesterday())
                        Yesterday, {{ \Carbon\Carbon::parse($date)->format('M d') }}
                    @else
                        {{ \Carbon\Carbon::parse($date)->format('l, M d') }}
                    @endif
                </h3>
                <span class="ml-auto text-xs text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-full">{{ count($dateMoments) }} {{ Str::plural('moment', count($dateMoments)) }}</span>
            </div>
        </div>
        
        <!-- Timeline Container -->
        <div class="px-4 pb-4 space-y-4">
            @foreach($dateMoments as $moment)
            <a href="{{ route('admin.moments.show', $moment) }}" class="block group">
                <div class="relative rounded-2xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm hover:shadow-xl border border-slate-200/50 dark:border-slate-800/50 transition-all duration-300 hover:-translate-y-1">
                    <!-- Card Image with Auto-scroll Carousel -->
                    @if($moment->images->count() > 0)
                    <div class="w-full aspect-[4/3] sm:aspect-video bg-slate-200 dark:bg-slate-800 relative overflow-hidden">
                        @if($moment->images->count() > 1)
                        <!-- Auto-scroll carousel for multiple images -->
                        <div class="carousel-container" data-carousel data-speed="4000">
                            <div class="carousel-track">
                                @foreach($moment->images as $image)
                                <div class="carousel-slide">
                                    <img src="{{ $image->url }}" alt="{{ $moment->title }}" class="w-full h-full object-cover" 
                                         onerror="handleImageError(this, '{{ $image->url }}', '{{ $image->image_path }}', {{ $image->id }})"
                                         loading="lazy">
                                </div>
                                @endforeach
                            </div>
                            <!-- Carousel dots -->
                            <div class="carousel-dots">
                                @foreach($moment->images as $index => $image)
                                <div class="carousel-dot {{ $loop->first ? 'active' : '' }}"></div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <!-- Single image -->
                        <img src="{{ $moment->images->first()->url }}" alt="{{ $moment->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                             onerror="handleImageError(this, '{{ $moment->images->first()->url }}', '{{ $moment->images->first()->image_path }}', {{ $moment->images->first()->id }})"
                             loading="lazy">
                        @endif
                        
                        <!-- Image count badge -->
                        <div class="absolute top-3 left-3 flex items-center gap-1.5 bg-black/50 backdrop-blur-md text-white px-2.5 py-1 rounded-full text-xs font-medium">
                            <span class="material-symbols-outlined text-[14px]">photo_library</span>
                            <span>{{ $moment->images->count() }}</span>
                        </div>
                        
                        <!-- Category badge -->
                        @if($moment->category)
                        @php
                            $categoryClass = 'category-default';
                            $categoryLower = strtolower($moment->category);
                            if(str_contains($categoryLower, 'milestone')) $categoryClass = 'category-milestone';
                            elseif(str_contains($categoryLower, 'celebration') || str_contains($categoryLower, 'birthday') || str_contains($categoryLower, 'party')) $categoryClass = 'category-celebration';
                            elseif(str_contains($categoryLower, 'travel') || str_contains($categoryLower, 'trip') || str_contains($categoryLower, 'vacation')) $categoryClass = 'category-travel';
                            elseif(str_contains($categoryLower, 'everyday') || str_contains($categoryLower, 'daily')) $categoryClass = 'category-everyday';
                            elseif(str_contains($categoryLower, 'special')) $categoryClass = 'category-special';
                        @endphp
                        <div class="absolute top-3 right-3 {{ $categoryClass }} text-white px-2.5 py-1 rounded-full text-xs font-medium shadow-lg">
                            {{ ucfirst($moment->category) }}
                        </div>
                        @endif
                        
                        <!-- Edit button -->
                        <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <button onclick="event.stopPropagation(); event.preventDefault(); window.location.href='{{ route('admin.moments.edit', $moment) }}';" class="size-9 flex items-center justify-center rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-700 dark:text-white hover:bg-white dark:hover:bg-slate-800 transition-colors shadow-lg">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                        </div>
                        
                        <!-- Gradient overlay for text readability -->
                        <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                    </div>
                    @else
                    <!-- No images placeholder -->
                    <div class="w-full aspect-[4/3] sm:aspect-video bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-400 dark:text-slate-600">image</span>
                            <p class="text-xs text-slate-400 dark:text-slate-600 mt-1">No images</p>
                        </div>
                        @if($moment->category)
                        @php
                            $categoryClass = 'category-default';
                            $categoryLower = strtolower($moment->category);
                            if(str_contains($categoryLower, 'milestone')) $categoryClass = 'category-milestone';
                            elseif(str_contains($categoryLower, 'celebration') || str_contains($categoryLower, 'birthday') || str_contains($categoryLower, 'party')) $categoryClass = 'category-celebration';
                            elseif(str_contains($categoryLower, 'travel') || str_contains($categoryLower, 'trip') || str_contains($categoryLower, 'vacation')) $categoryClass = 'category-travel';
                            elseif(str_contains($categoryLower, 'everyday') || str_contains($categoryLower, 'daily')) $categoryClass = 'category-everyday';
                            elseif(str_contains($categoryLower, 'special')) $categoryClass = 'category-special';
                        @endphp
                        <div class="absolute top-3 right-3 {{ $categoryClass }} text-white px-2.5 py-1 rounded-full text-xs font-medium shadow-lg">
                            {{ ucfirst($moment->category) }}
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Card Content -->
                    <div class="p-4">
                        <!-- Title and Status -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <h4 class="text-base font-bold text-slate-900 dark:text-white leading-snug line-clamp-2 flex-1">{{ $moment->title }}</h4>
                            @if($moment->status == 'in_progress')
                            <span class="shrink-0 inline-flex items-center gap-1 px-2 py-1 rounded-full bg-blue-500/10 text-primary text-xs font-medium">
                                <span class="size-1.5 rounded-full bg-primary animate-pulse"></span>
                                In Progress
                            </span>
                            @endif
                        </div>
                        
                        <!-- Description -->
                        @if($moment->description)
                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 mb-3">{{ $moment->description }}</p>
                        @endif
                        
                        <!-- Meta info: Location, Category, Time -->
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500 dark:text-slate-400">
                            @if($moment->location)
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
                                <span class="truncate max-w-[140px]">{{ $moment->location }}</span>
                            </div>
                            @endif
                            
                            @if($moment->moment_time)
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-slate-400">schedule</span>
                                <span>{{ \Carbon\Carbon::parse($moment->moment_time)->format('h:i A') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @empty
    <div class="flex flex-col items-center justify-center min-h-[60vh] py-20 px-6">
        <div class="w-24 h-24 bg-gradient-to-br from-primary/20 to-primary/5 rounded-3xl flex items-center justify-center mb-6 shadow-lg">
            <span class="material-symbols-outlined text-5xl text-primary">timeline</span>
        </div>
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">No moments yet</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 text-center max-w-xs mb-6">Start capturing your precious memories by adding your first moment.</p>
        <a href="{{ route('admin.moments.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white font-medium shadow-lg shadow-primary/30 hover:shadow-primary/40 hover:scale-105 transition-all">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add First Moment
        </a>
    </div>
    @endforelse
</main>


<script>
// Debug variables
let imageErrors = [];
let debugMode = {{ config('app.debug') ? 'true' : 'false' }};

// Image error handling
function handleImageError(imgElement, originalUrl, imagePath, imageId) {
    const alternatives = [
        '{{ asset("") }}' + imagePath,
        '/storage/' + imagePath,
        '{{ asset("images/placeholder.svg") }}'
    ];
    
    let attemptIndex = 0;
    
    function tryNextUrl() {
        if (attemptIndex < alternatives.length) {
            const nextUrl = alternatives[attemptIndex];
            const testImg = new Image();
            testImg.onload = function() {
                imgElement.src = nextUrl;
            };
            testImg.onerror = function() {
                attemptIndex++;
                tryNextUrl();
            };
            testImg.src = nextUrl;
        } else {
            imgElement.src = '{{ asset("images/placeholder.svg") }}';
            imgElement.onerror = null;
        }
    }
    
    tryNextUrl();
}

// Carousel class for auto-scrolling images
class ImageCarousel {
    constructor(container) {
        this.container = container;
        this.track = container.querySelector('.carousel-track');
        this.dots = container.querySelectorAll('.carousel-dot');
        this.slides = container.querySelectorAll('.carousel-slide');
        this.totalSlides = this.slides.length;
        this.currentIndex = 0;
        this.speed = parseInt(container.dataset.speed) || 4000;
        this.interval = null;
        this.isHovered = false;
        this.isVisible = true;
        
        this.init();
    }
    
    init() {
        if (this.totalSlides <= 1) return;
        
        this.startAutoScroll();
        
        // Pause on hover/touch
        this.container.addEventListener('mouseenter', () => this.pause());
        this.container.addEventListener('mouseleave', () => this.resume());
        this.container.addEventListener('touchstart', () => this.pause(), { passive: true });
        this.container.addEventListener('touchend', () => this.resume());
        
        // Visibility change handling
        document.addEventListener('visibilitychange', () => {
            this.isVisible = !document.hidden;
            if (this.isVisible && !this.isHovered) {
                this.startAutoScroll();
            } else {
                this.stopAutoScroll();
            }
        });
        
        // Intersection observer for performance
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.resume();
                } else {
                    this.stopAutoScroll();
                }
            });
        }, { threshold: 0.3 });
        
        observer.observe(this.container);
    }
    
    goToSlide(index) {
        this.currentIndex = index;
        this.track.style.transform = `translateX(-${index * 100}%)`;
        this.updateDots();
    }
    
    nextSlide() {
        const next = (this.currentIndex + 1) % this.totalSlides;
        this.goToSlide(next);
    }
    
    updateDots() {
        this.dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === this.currentIndex);
        });
    }
    
    startAutoScroll() {
        if (this.interval) return;
        this.interval = setInterval(() => this.nextSlide(), this.speed);
    }
    
    stopAutoScroll() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    }
    
    pause() {
        this.isHovered = true;
        this.stopAutoScroll();
    }
    
    resume() {
        this.isHovered = false;
        if (this.isVisible) {
            this.startAutoScroll();
        }
    }
}

// Initialize carousels on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all carousels
    document.querySelectorAll('[data-carousel]').forEach(container => {
        new ImageCarousel(container);
    });
    
    // Add touch swipe support for carousels
    document.querySelectorAll('.carousel-container').forEach(container => {
        let startX = 0;
        let endX = 0;
        
        container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        }, { passive: true });
        
        container.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            
            if (Math.abs(diff) > 50) {
                const track = container.querySelector('.carousel-track');
                const dots = container.querySelectorAll('.carousel-dot');
                const totalSlides = container.querySelectorAll('.carousel-slide').length;
                
                let currentIndex = Array.from(dots).findIndex(d => d.classList.contains('active'));
                
                if (diff > 0 && currentIndex < totalSlides - 1) {
                    currentIndex++;
                } else if (diff < 0 && currentIndex > 0) {
                    currentIndex--;
                }
                
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                dots.forEach((dot, i) => dot.classList.toggle('active', i === currentIndex));
            }
        });
    });
});
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

@endsection
