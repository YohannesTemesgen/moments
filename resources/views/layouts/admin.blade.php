<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#197fe6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BirthDay Admin">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                        "surface-dark": "#1c2126",
                        "surface-dark-highlight": "#2a323b",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .toggle-checkbox:checked { right: 0; border-color: #197fe6; }
        .toggle-checkbox:checked + .toggle-label { background-color: #197fe6; }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(2); opacity: 0; }
        }
        .pin-pulse::before {
            content: '';
            position: absolute;
            left: 0; top: 0;
            width: 100%; height: 100%;
            border-radius: 50%;
            background-color: rgba(25, 127, 230, 0.6);
            z-index: -1;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        .material-symbols-outlined.filled { font-variation-settings: 'FILL' 1; }
    </style>
    @yield('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white overflow-hidden h-screen w-full flex flex-col">
    @yield('content')
    
    <!-- PWA Update Available Popup -->
    <div id="pwa-update-prompt" class="fixed top-4 left-4 right-4 md:left-auto md:right-4 md:w-96 bg-white dark:bg-surface-dark rounded-xl shadow-2xl p-4 z-[100] hidden transform transition-all duration-300 border border-slate-200 dark:border-slate-700">
        <div class="flex items-start gap-3">
            <div class="shrink-0 w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-green-500 text-2xl">system_update</span>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">Update Available</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">A new version is available. Refresh to get the latest features.</p>
            </div>
            <button onclick="dismissUpdatePrompt()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="flex gap-2 mt-3">
            <button onclick="dismissUpdatePrompt()" class="flex-1 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                Later
            </button>
            <button onclick="applyUpdate()" class="flex-1 px-4 py-2 text-sm font-bold text-white bg-green-500 rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">refresh</span>
                Refresh Now
            </button>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 w-full z-40 bg-white/90 dark:bg-surface-dark/90 backdrop-blur-lg border-t border-slate-200 dark:border-slate-800 pb-safe">
        <div class="flex items-center justify-around h-16 max-w-md mx-auto">
            <a href="{{ route('admin.timeline') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full {{ request()->routeIs('admin.timeline') ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-200' }} transition-colors">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.timeline') ? 'filled' : '' }} text-[24px]">view_timeline</span>
                <span class="text-[10px] font-medium">Timeline</span>
            </a>
            <a href="{{ route('admin.calendar') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full {{ request()->routeIs('admin.calendar') ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-200' }} transition-colors">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.calendar') ? 'filled' : '' }} text-[24px]">calendar_month</span>
                <span class="text-[10px] font-medium">Calendar</span>
            </a>
            <a href="{{ route('admin.moments.create') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full relative">
                <div class="flex items-center justify-center w-12 h-12 bg-primary text-white rounded-2xl shadow-lg shadow-primary/40 -mt-2">
                    <span class="material-symbols-outlined text-[28px]">add</span>
                </div>
                <span class="text-[10px] font-medium text-primary">Create</span>
            </a>
            <a href="{{ route('admin.map') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full {{ request()->routeIs('admin.map') ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-200' }} transition-colors">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.map') ? 'filled' : '' }} text-[24px]">map</span>
                <span class="text-[10px] font-medium">Map</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full {{ request()->routeIs('admin.settings') ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-200' }} transition-colors">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.settings') ? 'filled' : '' }} text-[24px]">settings</span>
                <span class="text-[10px] font-medium">Settings</span>
            </a>
        </div>
        <div class="h-[env(safe-area-inset-bottom)] w-full"></div>
    </nav>

    <!-- Service Worker & Update Detection -->
    <script>
        let newWorkerWaiting = null;
        const updatePrompt = document.getElementById('pwa-update-prompt');

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => {
                        console.log('Service Worker registered');
                        
                        // Check for updates periodically (every 60 seconds)
                        setInterval(() => reg.update(), 60 * 1000);
                        
                        // Check if there's already a waiting worker
                        if (reg.waiting) {
                            newWorkerWaiting = reg.waiting;
                            showUpdatePrompt();
                        }
                        
                        // Listen for new service worker
                        reg.addEventListener('updatefound', () => {
                            const newWorker = reg.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    newWorkerWaiting = newWorker;
                                    showUpdatePrompt();
                                }
                            });
                        });
                    })
                    .catch(err => console.log('SW Error:', err));
            });
            
            // Reload page when SW takes control
            let refreshing = false;
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                if (!refreshing) {
                    refreshing = true;
                    window.location.reload();
                }
            });
        }
        
        function showUpdatePrompt() {
            if (updatePrompt) {
                updatePrompt.classList.remove('hidden');
            }
        }
        
        function dismissUpdatePrompt() {
            if (updatePrompt) {
                updatePrompt.classList.add('hidden');
            }
        }
        
        function applyUpdate() {
            if (newWorkerWaiting) {
                newWorkerWaiting.postMessage({ type: 'SKIP_WAITING' });
            }
            dismissUpdatePrompt();
        }
    </script>
    
    @yield('scripts')
</body>
</html>
