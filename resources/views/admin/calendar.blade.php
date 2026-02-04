@extends('layouts.admin')

@section('title', 'Calendar')

@section('content')
<header class="shrink-0 z-20 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 lg:py-4">
        <div class="flex items-center gap-3">
            <div class="lg:hidden relative group cursor-pointer">
                <div class="aspect-square rounded-full size-9 ring-2 ring-slate-200 dark:ring-slate-700 overflow-hidden img-loading-container">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=197fe6&color=fff" class="w-full h-full object-cover img-loading" onload="onImageLoad(this)">
                </div>
                <div class="absolute bottom-0 right-0 size-2.5 bg-green-500 rounded-full border-2 border-background-light dark:border-background-dark"></div>
            </div>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight">Calendar</h1>
                <p class="hidden lg:block text-sm text-slate-500">Manage and browse your moments by date</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.calendar', ['date' => now()->format('Y-m-d'), 'selected' => now()->format('Y-m-d')]) }}" class="flex items-center justify-center size-10 lg:size-11 rounded-full lg:rounded-xl hover:bg-slate-200 dark:hover:bg-surface-dark transition-colors text-slate-600 dark:text-slate-400 border border-transparent lg:border-slate-200 dark:lg:border-slate-800">
                <span class="material-symbols-outlined">today</span>
            </a>
            <button class="flex items-center justify-center size-10 lg:size-11 rounded-full lg:rounded-xl hover:bg-slate-200 dark:hover:bg-surface-dark transition-colors text-slate-600 dark:text-slate-400 border border-transparent lg:border-slate-200 dark:lg:border-slate-800">
                <span class="material-symbols-outlined">search</span>
            </button>
        </div>
    </div>
</header>

<main class="flex-1 overflow-hidden relative w-full flex flex-col lg:flex-row">
    <!-- Calendar Widget Container -->
    <div class="flex-1 overflow-y-auto no-scrollbar lg:border-r border-slate-200 dark:border-slate-800">
        <div class="bg-white dark:bg-surface-dark pb-4 lg:pb-8 shadow-sm lg:min-h-full">
            <div class="px-4 lg:px-8 pt-4 lg:pt-8 pb-2 flex items-center justify-between mb-4">
                <h2 class="text-xl lg:text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-1">
                    {{ $currentDate->format('F') }} <span class="text-slate-400 font-normal">{{ $currentDate->format('Y') }}</span>
                </h2>
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.calendar', ['date' => $currentDate->copy()->subMonth()->format('Y-m-d'), 'selected' => $selectedDate->format('Y-m-d')]) }}" class="p-2 lg:p-3 rounded-xl hover:bg-slate-100 dark:hover:bg-surface-dark-highlight text-slate-500 transition-colors">
                        <span class="material-symbols-outlined lg:text-3xl">chevron_left</span>
                    </a>
                    <a href="{{ route('admin.calendar', ['date' => $currentDate->copy()->addMonth()->format('Y-m-d'), 'selected' => $selectedDate->format('Y-m-d')]) }}" class="p-2 lg:p-3 rounded-xl hover:bg-slate-100 dark:hover:bg-surface-dark-highlight text-slate-500 transition-colors">
                        <span class="material-symbols-outlined lg:text-3xl">chevron_right</span>
                    </a>
                </div>
            </div>
            
            <!-- Day Headers -->
            <div class="grid grid-cols-7 mb-4 px-2 lg:px-8">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="text-center text-[10px] lg:text-xs font-bold uppercase text-slate-400 tracking-widest">{{ $day }}</div>
                @endforeach
            </div>
            
            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 px-2 lg:px-8 gap-y-2 lg:gap-y-4 gap-x-1 lg:gap-x-4">
                @php
                    $startOfMonth = $currentDate->copy()->startOfMonth();
                    $endOfMonth = $currentDate->copy()->endOfMonth();
                    $startDayOfWeek = $startOfMonth->dayOfWeek;
                    $prevMonth = $currentDate->copy()->subMonth();
                    $daysInPrevMonth = $prevMonth->daysInMonth;
                @endphp
                
                {{-- Previous month days --}}
                @for($i = $startDayOfWeek - 1; $i >= 0; $i--)
                <div class="aspect-square flex items-center justify-center text-slate-300 dark:text-slate-700 text-sm lg:text-lg">
                    {{ $daysInPrevMonth - $i }}
                </div>
                @endfor
                
                {{-- Current month days --}}
                @for($day = 1; $day <= $endOfMonth->day; $day++)
                @php
                    $dateStr = $currentDate->copy()->day($day)->format('Y-m-d');
                    $hasMoments = isset($moments[$dateStr]);
                    $isSelected = $selectedDate->format('Y-m-d') === $dateStr;
                    $isToday = now()->format('Y-m-d') === $dateStr;
                    $momentImage = $hasMoments && $moments[$dateStr]->first()->images->count() > 0 
                        ? $moments[$dateStr]->first()->images->first()->url 
                        : null;
                @endphp
                
                <a href="{{ route('admin.calendar', ['date' => $currentDate->format('Y-m-d'), 'selected' => $dateStr]) }}" 
                   class="aspect-square rounded-lg lg:rounded-2xl relative overflow-hidden transition-all duration-300 {{ $isSelected ? 'ring-2 lg:ring-4 ring-primary ring-offset-2 lg:ring-offset-4 ring-offset-white dark:ring-offset-surface-dark z-10' : '' }} {{ !$hasMoments && !$isSelected ? 'hover:bg-slate-100 dark:hover:bg-slate-800' : '' }} hover:scale-105 group">
                    @if($hasMoments && $momentImage)
                    <div class="absolute inset-0 bg-cover bg-center transition-all duration-500 {{ !$isSelected && !$isToday ? 'grayscale opacity-60' : '' }} group-hover:scale-110" style='background-image: url("{{ $momentImage }}");' onerror="this.style.backgroundImage='url({{ asset('images/placeholder.jpg') }})';"></div>
                    <div class="absolute inset-0 {{ $isSelected ? 'bg-primary/20 backdrop-blur-[1px]' : 'bg-black/30' }} transition-colors"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-white font-bold {{ $isSelected ? 'text-lg lg:text-2xl shadow-black drop-shadow-md' : 'text-sm lg:text-base' }}">{{ $day }}</div>
                    @if($isSelected && $moments[$dateStr]->count() > 1)
                    <div class="absolute bottom-2 w-full flex justify-center gap-1">
                        @for($dot = 0; $dot < min($moments[$dateStr]->count(), 3); $dot++)
                        <div class="size-1 lg:size-1.5 {{ $dot == 0 ? 'bg-white' : 'bg-white/50' }} rounded-full shadow-sm"></div>
                        @endfor
                    </div>
                    @endif
                    @else
                    <div class="w-full h-full flex items-center justify-center text-slate-700 dark:text-slate-300 text-sm lg:text-xl font-bold {{ $isSelected ? 'bg-primary text-white shadow-lg shadow-primary/30' : '' }} {{ $isToday && !$isSelected ? 'text-primary' : '' }}">
                        {{ $day }}
                        @if($isToday && !$isSelected)
                        <div class="absolute bottom-2 size-1.5 bg-primary rounded-full"></div>
                        @endif
                    </div>
                    @endif
                </a>
                @endfor
                
                {{-- Next month days --}}
                @php $remainingDays = 42 - ($startDayOfWeek + $endOfMonth->day); @endphp
                @for($i = 1; $i <= $remainingDays && $i <= 7; $i++)
                <div class="aspect-square flex items-center justify-center text-slate-300 dark:text-slate-700 text-sm lg:text-lg">{{ $i }}</div>
                @endfor
            </div>
        </div>
    </div>
    
    <!-- Selected Day Moments Container -->
    <div class="lg:w-96 lg:shrink-0 overflow-y-auto no-scrollbar bg-slate-50 dark:bg-background-dark/50">
        <div class="relative w-full max-w-md mx-auto mt-4 lg:mt-0 px-4 lg:px-6 py-6 lg:py-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xs lg:text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                        {{ $selectedDate->format('l') }}
                    </h3>
                    <p class="text-lg lg:text-xl font-bold text-slate-900 dark:text-white">{{ $selectedDate->format('M d, Y') }}</p>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-white dark:bg-surface-dark text-primary shadow-sm border border-slate-100 dark:border-slate-800">
                    {{ $selectedMoments->count() }} {{ Str::plural('Moment', $selectedMoments->count()) }}
                </span>
            </div>
            
            @if($selectedMoments->count() > 0)
            <div class="relative border-l-2 border-slate-200 dark:border-slate-800 ml-3 space-y-8 pt-2">
                @foreach($selectedMoments as $moment)
                <div class="relative pl-8 group">
                    <div class="absolute {{ $loop->first ? '-left-[11px] size-5 border-4 border-background-light dark:border-background-dark bg-primary shadow-lg shadow-primary/30' : '-left-[6px] size-3 bg-slate-300 dark:bg-slate-600' }} top-6 rounded-full box-content transition-all duration-300 group-hover:scale-125"></div>
                    <div class="flex flex-col rounded-2xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm hover:shadow-xl border border-slate-200 dark:border-slate-800/50 transition-all duration-300 hover:-translate-y-1">
                        @if($moment->images->count() > 0)
                        <div class="w-full h-44 bg-slate-200 dark:bg-slate-800 relative group/img overflow-hidden">
                            <div class="w-full h-full bg-center bg-cover transition-transform duration-700 group-hover/img:scale-110" style='background-image: url("{{ $moment->images->first()->url }}");' onerror="this.style.backgroundImage='url({{ asset('images/placeholder.jpg') }})';"></div>
                            <div class="absolute inset-0 bg-black/0 group-hover/img:bg-black/10 transition-colors"></div>
                            <div class="absolute top-3 right-3 opacity-0 group-hover/img:opacity-100 transition-opacity">
                                <a href="{{ route('admin.moments.edit', $moment) }}" class="size-9 flex items-center justify-center rounded-xl bg-white/90 dark:bg-surface-dark/90 backdrop-blur-md text-slate-700 dark:text-white hover:bg-white transition-all shadow-lg">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="p-4 flex flex-col gap-3">
                            <div class="flex justify-between items-start gap-2">
                                <h4 class="text-base font-bold text-slate-900 dark:text-white leading-tight group-hover:text-primary transition-colors">{{ $moment->title }}</h4>
                                @if($moment->status == 'in_progress')
                                <span class="shrink-0 px-2 py-0.5 rounded-full bg-blue-500/10 text-primary text-[10px] font-bold uppercase tracking-wider">Active</span>
                                @endif
                            </div>
                            
                            @if($moment->description)
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">{{ $moment->description }}</p>
                            @endif

                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500 dark:text-slate-400">
                                @if($moment->location)
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-primary">location_on</span>
                                    <span class="truncate max-w-[150px]">{{ $moment->location }}</span>
                                </div>
                                @endif
                                @if($moment->moment_time)
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                                    <span>{{ \Carbon\Carbon::parse($moment->moment_time)->format('h:i A') }}</span>
                                </div>
                                @endif
                            </div>

                            <a href="{{ route('admin.moments.show', $moment) }}" class="mt-2 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-slate-50 dark:bg-surface-dark-highlight hover:bg-primary hover:text-white text-slate-600 dark:text-slate-300 font-bold text-sm transition-all border border-slate-100 dark:border-slate-800">
                                View Details
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="size-20 bg-slate-100 dark:bg-surface-dark rounded-3xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-4xl text-slate-300">event_busy</span>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white mb-1">No moments</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400">Nothing was recorded on this day.</p>
                <a href="{{ route('admin.moments.create', ['date' => $selectedDate->format('Y-m-d')]) }}" class="mt-6 px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/30 hover:scale-105 transition-all">
                    Record Moment
                </a>
            </div>
            @endif
        </div>
        <div class="h-24 lg:hidden"></div>
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
