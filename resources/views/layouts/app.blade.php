<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Moments')</title>
    
    <!-- PWA Support -->
    <meta name="theme-color" content="#ea2a33">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Moments">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ea2a33",
                        "stranger-red": "#E50914",
                        "background-light": "#f8f6f6",
                        "background-dark": "#000000",
                    },
                    fontFamily: {
                        "display": ["Newsreader", "serif"],
                        "sans": ["Noto Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    
    @yield('styles')
</head>
<body class="@yield('body-class', 'bg-background-dark text-white font-display')">
    @yield('content')
    
    <!-- PWA Update Available Popup -->
    <div id="pwa-update-prompt" class="fixed top-4 left-4 right-4 md:left-auto md:right-4 md:w-96 bg-white dark:bg-gray-900 rounded-xl shadow-2xl p-4 z-[100] hidden transform transition-all duration-300 border border-gray-200 dark:border-gray-700 animate-bounce-in">
        <div class="flex items-start gap-3">
            <div class="shrink-0 w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-green-500 text-2xl">system_update</span>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm">Update Available</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">A new version is available. Refresh to get the latest features and improvements.</p>
            </div>
            <button onclick="dismissUpdatePrompt()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="flex gap-2 mt-3">
            <button onclick="dismissUpdatePrompt()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                Later
            </button>
            <button onclick="applyUpdate()" class="flex-1 px-4 py-2 text-sm font-bold text-white bg-green-500 rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">refresh</span>
                Refresh Now
            </button>
        </div>
    </div>

    <!-- PWA Install Prompt -->
    <div id="pwa-install-prompt" class="fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:w-96 bg-white dark:bg-gray-900 rounded-xl shadow-2xl p-4 z-50 hidden transform transition-all duration-300 border border-gray-200 dark:border-gray-700">
        <div class="flex items-start gap-3">
            <div class="shrink-0 w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-2xl">download</span>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm">Install Moments App</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Add to your home screen for quick access and offline support.</p>
            </div>
            <button onclick="dismissInstallPrompt()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="flex gap-2 mt-3">
            <button onclick="dismissInstallPrompt()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                Not Now
            </button>
            <button onclick="installPWA()" class="flex-1 px-4 py-2 text-sm font-bold text-white bg-primary rounded-lg hover:bg-red-700 transition-colors">
                Install
            </button>
        </div>
    </div>

    <!-- Service Worker & PWA Script -->
    <script>
        let newWorkerWaiting = null;
        const updatePrompt = document.getElementById('pwa-update-prompt');

        // Register Service Worker
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
                                    // New SW is installed and waiting
                                    newWorkerWaiting = newWorker;
                                    showUpdatePrompt();
                                }
                            });
                        });
                    })
                    .catch(err => console.log('Service Worker registration failed:', err));
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

        // PWA Install Prompt
        let deferredPrompt;
        const installPrompt = document.getElementById('pwa-install-prompt');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Check if user hasn't dismissed the prompt recently
            const dismissed = localStorage.getItem('pwa-install-dismissed');
            if (!dismissed || Date.now() - parseInt(dismissed) > 7 * 24 * 60 * 60 * 1000) {
                setTimeout(() => {
                    installPrompt.classList.remove('hidden');
                }, 3000);
            }
        });

        function installPWA() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    }
                    deferredPrompt = null;
                    installPrompt.classList.add('hidden');
                });
            }
        }

        function dismissInstallPrompt() {
            installPrompt.classList.add('hidden');
            localStorage.setItem('pwa-install-dismissed', Date.now().toString());
        }

        // iOS Install Instructions
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches;
        
        if (isIOS && !isStandalone) {
            // Show iOS-specific install instructions
            setTimeout(() => {
                const iosPrompt = document.getElementById('pwa-install-prompt');
                if (iosPrompt && !localStorage.getItem('pwa-install-dismissed')) {
                    iosPrompt.querySelector('p').textContent = 'Tap the share button and select "Add to Home Screen" to install.';
                    iosPrompt.querySelector('button[onclick="installPWA()"]').textContent = 'Got it';
                    iosPrompt.querySelector('button[onclick="installPWA()"]').onclick = dismissInstallPrompt;
                    iosPrompt.classList.remove('hidden');
                }
            }, 3000);
        }
    </script>
    
    @yield('scripts')
</body>
</html>
