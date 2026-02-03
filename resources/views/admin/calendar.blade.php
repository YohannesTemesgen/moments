@extends('layouts.admin')

@section('title', 'Calendar')

@section('content')
<header class="shrink-0 z-20 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
    <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center gap-3">
            <div class="relative group cursor-pointer">
                <div class="aspect-square rounded-full size-9 ring-2 ring-slate-200 dark:ring-slate-700 overflow-hidden img-loading-container">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=197fe6&color=fff" class="w-full h-full object-cover img-loading" onload="onImageLoad(this)">
                </div>
                <div class="absolute bottom-0 right-0 size-2.5 bg-green-500 rounded-full border-2 border-background-light dark:border-background-dark"></div>
            </div>
            <h1 class="text-lg font-bold tracking-tight">Calendar</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.calendar', ['date' => now()->format('Y-m-d'), 'selected' => now()->format('Y-m-d')]) }}" class="flex items-center justify-center size-10 rounded-full hover:bg-slate-200 dark:hover:bg-surface-dark transition-colors text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined">today</span>
            </a>
            <button class="flex items-center justify-center size-10 rounded-full hover:bg-slate-200 dark:hover:bg-surface-dark transition-colors text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined">search</span>
            </button>
        </div>
    </div>
</header>

<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-24">
    <!-- Calendar Widget -->
    <div class="bg-white dark:bg-surface-dark border-b border-slate-200 dark:border-slate-800 pb-4 shadow-sm">
        <div class="px-4 pt-4 pb-2 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-1">
                {{ $currentDate->format('F') }} <span class="text-slate-400 font-normal">{{ $currentDate->format('Y') }}</span>
            </h2>
            <div class="flex items-center gap-1">
                <a href="{{ route('admin.calendar', ['date' => $currentDate->copy()->subMonth()->format('Y-m-d'), 'selected' => $selectedDate->format('Y-m-d')]) }}" class="p-1 rounded-full hover:bg-slate-100 dark:hover:bg-surface-dark-highlight text-slate-500">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
                <a href="{{ route('admin.calendar', ['date' => $currentDate->copy()->addMonth()->format('Y-m-d'), 'selected' => $selectedDate->format('Y-m-d')]) }}" class="p-1 rounded-full hover:bg-slate-100 dark:hover:bg-surface-dark-highlight text-slate-500">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </div>
        </div>
        
        <!-- Day Headers -->
        <div class="grid grid-cols-7 mb-2 px-2">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="text-center text-[10px] font-semibold uppercase text-slate-400">{{ $day }}</div>
            @endforeach
        </div>
        
        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 px-2 gap-y-2 gap-x-1">
            @php
                $startOfMonth = $currentDate->copy()->startOfMonth();
                $endOfMonth = $currentDate->copy()->endOfMonth();
                $startDayOfWeek = $startOfMonth->dayOfWeek;
                $prevMonth = $currentDate->copy()->subMonth();
                $daysInPrevMonth = $prevMonth->daysInMonth;
            @endphp
            
            {{-- Previous month days --}}
            @for($i = $startDayOfWeek - 1; $i >= 0; $i--)
            <div class="aspect-square flex items-center justify-center text-slate-300 dark:text-slate-700 text-sm">
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
               class="aspect-square rounded-lg relative overflow-hidden {{ $isSelected ? 'ring-2 ring-primary ring-offset-2 ring-offset-white dark:ring-offset-surface-dark z-10' : '' }} {{ !$hasMoments && !$isSelected ? 'hover:bg-slate-100 dark:hover:bg-slate-800' : '' }}">
                @if($hasMoments && $momentImage)
                <div class="absolute inset-0 bg-cover bg-center {{ !$isSelected && !$isToday ? 'grayscale opacity-60' : '' }}" style='background-image: url("{{ $momentImage }}");' onerror="this.style.backgroundImage='url({{ asset('images/placeholder.jpg') }})';"></div>
                <div class="absolute inset-0 {{ $isSelected ? 'bg-primary/20 backdrop-blur-[1px]' : 'bg-black/30' }}"></div>
                <div class="absolute inset-0 flex items-center justify-center text-white font-bold {{ $isSelected ? 'text-lg shadow-black drop-shadow-md' : 'text-sm' }}">{{ $day }}</div>
                @if($isSelected && $moments[$dateStr]->count() > 1)
                <div class="absolute bottom-1 w-full flex justify-center gap-0.5">
                    @for($dot = 0; $dot < min($moments[$dateStr]->count(), 3); $dot++)
                    <div class="size-1 {{ $dot == 0 ? 'bg-white' : 'bg-white/50' }} rounded-full"></div>
                    @endfor
                </div>
                @endif
                @else
                <div class="w-full h-full flex items-center justify-center text-slate-700 dark:text-slate-300 text-sm font-medium {{ $isSelected ? 'bg-primary text-white' : '' }}">{{ $day }}</div>
                @endif
            </a>
            @endfor
            
            {{-- Next month days --}}
            @php $remainingDays = 42 - ($startDayOfWeek + $endOfMonth->day); @endphp
            @for($i = 1; $i <= $remainingDays && $i <= 7; $i++)
            <div class="aspect-square flex items-center justify-center text-slate-300 dark:text-slate-700 text-sm">{{ $i }}</div>
            @endfor
        </div>
    </div>
    
    <!-- Selected Day Moments -->
    <div class="relative w-full max-w-md mx-auto mt-4 px-4 pb-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                {{ $selectedDate->format('l, M d') }}
            </h3>
            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-slate-100 dark:bg-surface-dark-highlight text-slate-600 dark:text-slate-300">
                {{ $selectedMoments->count() }} {{ Str::plural('Moment', $selectedMoments->count()) }}
            </span>
        </div>
        
        @if($selectedMoments->count() > 0)
        <div class="relative border-l-2 border-slate-200 dark:border-slate-800 ml-3 space-y-6 pt-2">
            @foreach($selectedMoments as $moment)
            <div class="relative pl-6 group">
                <div class="absolute {{ $loop->first ? '-left-[9px] size-4 border-4 border-background-light dark:border-background-dark bg-primary' : '-left-[5px] size-2.5 bg-slate-300 dark:bg-slate-600' }} top-6 rounded-full box-content"></div>
                <div class="flex flex-col rounded-xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm border border-slate-200 dark:border-slate-800/50">
                    @if($moment->images->count() > 0)
                    <div class="w-full h-40 bg-slate-200 dark:bg-slate-800 relative">
                        <div class="w-full h-full bg-center bg-cover" style='background-image: url("{{ $moment->images->first()->url }}");' onerror="this.style.backgroundImage='url({{ asset('images/placeholder.jpg') }})';"></div>
                        <div class="absolute top-2 right-2">
                            <a href="{{ route('admin.moments.edit', $moment) }}" class="size-8 flex items-center justify-center rounded-full bg-black/40 backdrop-blur-md text-white hover:bg-black/60 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="p-3 flex flex-col gap-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">{{ $moment->title }}</h4>
                                @if($moment->description)
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $moment->description }}</p>
                                @endif
                            </div>
                            @if($moment->status == 'in_progress')
                            <span class="px-2 py-0.5 rounded bg-blue-500/10 text-primary text-[10px] font-medium">In Progress</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            @if($moment->location)
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
                                <span class="truncate max-w-[120px]">{{ $moment->location }}</span>
                            </div>
                            @endif
                            @if($moment->moment_time)
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                <span>{{ \Carbon\Carbon::parse($moment->moment_time)->format('h:i A') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-slate-500 dark:text-slate-400 text-sm">No moments on this day</p>
        </div>
        @endif
    </div>
    <div class="h-20"></div>
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
