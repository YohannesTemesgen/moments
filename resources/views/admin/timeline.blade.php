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
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 lg:py-5 max-w-[1600px] mx-auto">
        <div class="flex items-center gap-3">
            <div class="lg:hidden relative group cursor-pointer">
                <div class="aspect-square rounded-full size-10 ring-2 ring-primary/20 shadow-lg overflow-hidden img-loading-container">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=197fe6&color=fff" class="w-full h-full object-cover img-loading" onload="onImageLoad(this)">
                </div>
                <div class="absolute bottom-0 right-0 size-3 bg-green-500 rounded-full border-2 border-background-light dark:border-background-dark ring-2 ring-green-500/20"></div>
            </div>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Timeline</h1>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Chronological view of your captured memories</p>
            </div>
        </div>
        <div class="flex items-center gap-2 lg:gap-4">
            <a href="{{ route('admin.moments.create') }}" class="hidden lg:flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <span class="material-symbols-outlined text-[20px]">add</span>
                New Moment
            </a>
            <button class="flex items-center justify-center size-10 lg:size-11 rounded-xl bg-slate-100 dark:bg-surface-dark hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-slate-600 dark:text-slate-400 border border-transparent lg:border-slate-200 dark:lg:border-slate-800">
                <span class="material-symbols-outlined text-[22px] lg:text-[26px]">search</span>
            </button>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28 lg:pb-12 bg-slate-50/50 dark:bg-background-dark/50">
    <div class="max-w-[1600px] mx-auto lg:px-8 py-2 lg:py-8">
        @forelse($moments as $date => $dateMoments)
        <div class="relative w-full {{ !$loop->first ? 'mt-6 lg:mt-12' : '' }}">
            <!-- Sticky Section Header -->
            <div class="sticky top-0 z-10 bg-slate-50/90 dark:bg-background-dark/90 backdrop-blur-md px-4 lg:px-0 py-3 lg:py-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="size-2.5 lg:size-3 rounded-full {{ \Carbon\Carbon::parse($date)->isToday() ? 'bg-primary animate-pulse shadow-[0_0_10px_rgba(25,127,230,0.5)]' : 'bg-slate-400 dark:bg-slate-600' }}"></div>
                    <h3 class="text-base lg:text-xl font-bold tracking-tight {{ \Carbon\Carbon::parse($date)->isToday() ? 'text-primary' : 'text-slate-800 dark:text-white' }}">
                        @if(\Carbon\Carbon::parse($date)->isToday())
                            Today <span class="text-slate-400 dark:text-slate-500 font-medium ml-1">· {{ \Carbon\Carbon::parse($date)->format('M d') }}</span>
                        @elseif(\Carbon\Carbon::parse($date)->isYesterday())
                            Yesterday <span class="text-slate-400 dark:text-slate-500 font-medium ml-1">· {{ \Carbon\Carbon::parse($date)->format('M d') }}</span>
                        @else
                            {{ \Carbon\Carbon::parse($date)->format('l, M d, Y') }}
                        @endif
                    </h3>
                    <div class="ml-auto flex items-center gap-2">
                        <span class="text-[10px] lg:text-xs font-bold text-slate-400 dark:text-slate-500 bg-white dark:bg-surface-dark px-3 py-1 rounded-full border border-slate-100 dark:border-slate-800 shadow-sm">{{ count($dateMoments) }} {{ Str::plural('moment', count($dateMoments)) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Moments Grid -->
            <div class="px-4 lg:px-0 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 lg:gap-6">
                @foreach($dateMoments as $moment)
                <a href="{{ route('admin.moments.show', $moment) }}" class="block group">
                    <div class="relative h-full flex flex-col rounded-2xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm hover:shadow-2xl border border-slate-200/50 dark:border-slate-800/50 transition-all duration-500 hover:-translate-y-2">
                        <!-- Card Image -->
                        @if($moment->images->count() > 0)
                        <div class="w-full aspect-[4/3] bg-slate-200 dark:bg-slate-800 relative overflow-hidden">
                            @if($moment->images->count() > 1)
                            <div class="carousel-container h-full" data-carousel data-speed="4000">
                                <div class="carousel-track h-full">
                                    @foreach($moment->images as $image)
                                    <div class="carousel-slide h-full">
                                        <img src="{{ $image->url }}" alt="{{ $moment->title }}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                    @endforeach
                                </div>
                                <div class="carousel-dots">
                                    @foreach($moment->images as $index => $image)
                                    <div class="carousel-dot {{ $loop->first ? 'active' : '' }}"></div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <img src="{{ $moment->images->first()->url }}" alt="{{ $moment->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                            @endif
                            
                            <div class="absolute top-3 left-3 flex items-center gap-1.5 bg-black/40 backdrop-blur-md text-white px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[14px]">photo_library</span>
                                <span>{{ $moment->images->count() }}</span>
                            </div>
                            
                            @if($moment->category)
                            @php
                                $categoryClass = 'category-default';
                                $categoryLower = strtolower($moment->category);
                                if(str_contains($categoryLower, 'milestone')) $categoryClass = 'category-milestone';
                                elseif(str_contains($categoryLower, 'celebration')) $categoryClass = 'category-celebration';
                                elseif(str_contains($categoryLower, 'travel')) $categoryClass = 'category-travel';
                                elseif(str_contains($categoryLower, 'everyday')) $categoryClass = 'category-everyday';
                                elseif(str_contains($categoryLower, 'special')) $categoryClass = 'category-special';
                            @endphp
                            <div class="absolute top-3 right-3 {{ $categoryClass }} text-white px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider shadow-lg">
                                {{ $moment->category }}
                            </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-500"></div>
                        </div>
                        @else
                        <div class="w-full aspect-[4/3] bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 flex flex-col items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-700">image</span>
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-600 uppercase tracking-widest">No images</span>
                        </div>
                        @endif
                        
                        <!-- Card Content -->
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h4 class="text-base lg:text-lg font-bold text-slate-900 dark:text-white leading-tight line-clamp-2 group-hover:text-primary transition-colors">{{ $moment->title }}</h4>
                                @if($moment->status == 'in_progress')
                                <span class="shrink-0 px-2 py-0.5 rounded-md bg-blue-500/10 text-primary text-[10px] font-bold uppercase tracking-widest">Active</span>
                                @endif
                            </div>
                            
                            @if($moment->description)
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-4 leading-relaxed flex-1">{{ $moment->description }}</p>
                            @endif
                            
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-4 border-t border-slate-50 dark:border-slate-800/50">
                                @if($moment->location)
                                <div class="flex items-center gap-1.5 text-xs text-slate-400 dark:text-slate-500">
                                    <span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
                                    <span class="truncate max-w-[120px]">{{ $moment->location }}</span>
                                </div>
                                @endif
                                
                                @if($moment->moment_time)
                                <div class="flex items-center gap-1.5 text-xs text-slate-400 dark:text-slate-500 ml-auto">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <span>{{ \Carbon\Carbon::parse($moment->moment_time)->format('h:i A') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Edit Hover Action -->
                        <div class="absolute top-3 right-3 lg:top-4 lg:right-4 opacity-0 lg:group-hover:opacity-100 transition-all duration-300 transform translate-y-2 lg:group-hover:translate-y-0 z-20">
                            <button onclick="event.preventDefault(); window.location.href='{{ route('admin.moments.edit', $moment) }}';" class="size-10 flex items-center justify-center rounded-xl bg-white dark:bg-slate-900 text-slate-700 dark:text-white hover:text-primary transition-colors shadow-2xl border border-slate-100 dark:border-slate-800">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center min-h-[60vh] py-20 px-6 text-center">
            <div class="w-24 h-24 bg-white dark:bg-surface-dark rounded-[2.5rem] flex items-center justify-center mb-8 shadow-xl border border-slate-100 dark:border-slate-800">
                <span class="material-symbols-outlined text-5xl text-primary">timeline</span>
            </div>
            <h3 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-2">Your timeline is empty</h3>
            <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 max-w-sm mb-10 leading-relaxed">Every great journey starts with a single moment. Start capturing yours today.</p>
            <a href="{{ route('admin.moments.create') }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-primary text-white font-bold shadow-xl shadow-primary/30 hover:shadow-primary/40 hover:scale-105 transition-all">
                <span class="material-symbols-outlined">add_circle</span>
                Capture Your First Moment
            </a>
        </div>
        @endforelse
    </div>
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
