<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stranger Things Countdown</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Moments">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    
    <!-- Fonts -->
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
    <style>
        body { -webkit-font-smoothing: none; -moz-osx-font-smoothing: grayscale; }
        .retro-hover:hover { text-shadow: 0 0 1px currentColor; }
        .stranger-outline {
            color: transparent;
            -webkit-text-stroke: 2px #E50914;
            text-stroke: 2px #E50914;
            text-shadow: 0 0 10px rgba(229, 9, 20, 0.5), 0 0 20px rgba(229, 9, 20, 0.3);
        }
        .stranger-outline-sm {
            color: transparent;
            -webkit-text-stroke: 1px #E50914;
            text-stroke: 1px #E50914;
            text-shadow: 0 0 8px rgba(229, 9, 20, 0.4);
        }
        .stranger-outline-light {
            color: transparent;
            -webkit-text-stroke: 1px #E50914;
            text-stroke: 1px #E50914;
            text-shadow: 0 0 8px rgba(229, 9, 20, 0.4);
        }
        @media (max-width: 640px) {
            .stranger-outline { -webkit-text-stroke: 1.5px #E50914; }
        }
    </style>
</head>
<body class="relative flex min-h-screen w-full flex-col bg-background-light dark:bg-background-dark text-white font-display overflow-x-hidden selection:bg-primary selection:text-white">
    <!-- Video Background -->
    <video id="bgVideo" class="fixed top-0 left-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000 z-[-1]" autoplay muted loop playsinline>
        <source src="{{ asset('video.mp4') }}" type="video/mp4">
    </video>
    
    <!-- Audio Background -->
    <audio id="bgAudio" loop>
        <source src="{{ asset('audio.opus') }}" type="audio/opus">
    </audio>

    <!-- Bell Sound -->
    <audio id="bellAudio" loop preload="auto">
        <source src="{{ asset('sound') }}" type="audio/mp4">
    </audio>
    
    <header class="relative w-full flex items-center justify-center md:justify-between border-b border-[#1a1a1a] px-4 sm:px-6 py-4 md:px-12">
    <div class="flex items-center gap-2 sm:gap-3 text-white group cursor-default">
        <span class="material-symbols-outlined text-primary text-xl sm:text-2xl group-hover:scale-110 transition-transform duration-300">movie_filter</span>
        <h2 class="text-white text-sm sm:text-lg font-bold tracking-widest uppercase leading-tight">Stranger Life</h2>
    </div>
    
    <div class="flex items-center gap-4 md:gap-6 absolute right-4 md:static">
        <button id="bellToggle" class="flex items-center gap-2 text-[#666] hover:text-primary transition-colors group" aria-label="Toggle Sound Bell">
            <span class="material-symbols-outlined group-hover:animate-pulse transition-colors" id="bellIcon">notifications_off</span>
            <span class="text-xs font-bold tracking-widest uppercase hidden md:inline transition-colors">Sound Bell</span>
        </button>
        <span class="hidden md:inline text-xs font-medium tracking-[0.2em] text-[#666] uppercase border-l border-[#333] pl-6">Official Teaser Site</span>
    </div>
</header>
    
    <main class="flex-grow flex flex-col items-center justify-center w-full px-4 py-8 sm:py-12 relative z-0">
        <div class="flex flex-col items-center text-center gap-3 sm:gap-4 mb-8 sm:mb-16 max-w-4xl mx-auto animate-fade-in">
            <p class="text-primary font-bold tracking-[0.3em] sm:tracking-[0.4em] text-sm sm:text-base md:text-lg uppercase border-b border-primary/30 pb-1">Season 24</p>
            <h1 class="text-white text-4xl sm:text-5xl md:text-7xl lg:text-9xl font-black italic tracking-tighter uppercase leading-[0.9] retro-hover cursor-default">
                Premiere
            </h1>
        </div>
        
        <div class="w-full max-w-[1200px] mx-auto mb-8 sm:mb-16">
            <div class="flex flex-wrap items-start justify-center text-center gap-2 sm:gap-4 md:gap-8 lg:gap-12">
                <div class="flex flex-col items-center flex-1 min-w-[60px] sm:min-w-[80px]">
                    <div id="days" class="text-4xl sm:text-6xl md:text-8xl lg:text-[10rem] leading-none font-bold stranger-outline tabular-nums tracking-tighter">00</div>
                    <div class="w-full h-px bg-[#333] my-2 sm:my-4"></div>
                    <p class="text-[#666] text-[10px] sm:text-xs md:text-sm font-medium tracking-[0.2em] sm:tracking-[0.3em] uppercase">Days</p>
                </div>
                <div class="text-4xl sm:text-6xl md:text-8xl lg:text-[9rem] leading-none font-light stranger-outline-light opacity-80 -mt-1 sm:-mt-2">:</div>
                <div class="flex flex-col items-center flex-1 min-w-[60px] sm:min-w-[80px]">
                    <div id="hours" class="text-4xl sm:text-6xl md:text-8xl lg:text-[10rem] leading-none font-bold stranger-outline tabular-nums tracking-tighter">00</div>
                    <div class="w-full h-px bg-[#333] my-2 sm:my-4"></div>
                    <p class="text-[#666] text-[10px] sm:text-xs md:text-sm font-medium tracking-[0.2em] sm:tracking-[0.3em] uppercase">Hours</p>
                </div>
                <div class="text-4xl sm:text-6xl md:text-8xl lg:text-[9rem] leading-none font-light stranger-outline-light opacity-80 -mt-1 sm:-mt-2">:</div>
                <div class="flex flex-col items-center flex-1 min-w-[60px] sm:min-w-[80px]">
                    <div id="minutes" class="text-4xl sm:text-6xl md:text-8xl lg:text-[10rem] leading-none font-bold stranger-outline tabular-nums tracking-tighter">00</div>
                    <div class="w-full h-px bg-[#333] my-2 sm:my-4"></div>
                    <p class="text-[#666] text-[10px] sm:text-xs md:text-sm font-medium tracking-[0.2em] sm:tracking-[0.3em] uppercase">Minutes</p>
                </div>
                <div class="text-4xl sm:text-6xl md:text-8xl lg:text-[9rem] leading-none font-light stranger-outline-light opacity-80 -mt-1 sm:-mt-2">:</div>
                <div class="flex flex-col items-center flex-1 min-w-[60px] sm:min-w-[80px]">
                    <div id="seconds" class="text-4xl sm:text-6xl md:text-8xl lg:text-[10rem] leading-none font-bold stranger-outline tabular-nums tracking-tighter">00</div>
                    <div class="w-full h-px bg-[#333] my-2 sm:my-4"></div>
                    <p class="text-[#666] text-[10px] sm:text-xs md:text-sm font-medium tracking-[0.2em] sm:tracking-[0.3em] uppercase">Seconds</p>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col items-center gap-6 sm:gap-8">
            <p class="stranger-outline-sm text-xs sm:text-sm md:text-base font-bold tracking-[0.3em] sm:tracking-[0.5em] uppercase text-center px-4">
                Countdown<br/> to<br class="sm:hidden">the Upside Down<br/><br/> 2.5 
            </p>

        </div>
    </main>
    


    <!-- PWA Install Prompt -->
    <div id="pwa-install-prompt" class="fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:w-96 bg-gray-900 rounded-xl shadow-2xl p-4 z-50 hidden transform transition-all duration-300 border border-gray-700" style="display: none !important;">
        <div class="flex items-start gap-3">
            <div class="shrink-0 w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-2xl">download</span>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-white text-sm">Install Moment App</h3>
                <p class="text-xs text-gray-400 mt-1">Add to your home screen for quick access.</p>
            </div>
            <button onclick="dismissInstallPrompt()" class="text-gray-400 hover:text-gray-200">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="flex gap-2 mt-3">
            <button onclick="dismissInstallPrompt()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-300 bg-gray-800 rounded-lg hover:bg-gray-700 transition-colors">
                Not Now
            </button>
            <button onclick="installPWA()" class="flex-1 px-4 py-2 text-sm font-bold text-white bg-primary rounded-lg hover:bg-red-700 transition-colors">
                Install
            </button>
        </div>
    </div>

    <script>
        // Target date from server
        const targetDate = new Date("{{ $targetDate }}");

        // Video display logic - show every 7 seconds for 7 seconds
        const video = document.getElementById('bgVideo');
        const audio = document.getElementById('bgAudio');
        let videoInterval;
        let isAudioInitialized = false;
        let isVideoVisible = false;
        let isPWA = false;

        // Bell Sound Logic
        const bellAudio = document.getElementById('bellAudio');
        const bellToggle = document.getElementById('bellToggle');
        const bellIcon = document.getElementById('bellIcon');
        let isBellEnabled = false;

        function updateBellUI() {
            if (isBellEnabled) {
                bellIcon.textContent = 'notifications_active';
                bellIcon.classList.add('text-primary');
                bellToggle.classList.add('text-primary');
                bellToggle.classList.remove('text-[#666]');
            } else {
                bellIcon.textContent = 'notifications_off';
                bellIcon.classList.remove('text-primary');
                bellToggle.classList.remove('text-primary');
                bellToggle.classList.add('text-[#666]');
            }
        }

        function playBell() {
            if (!bellAudio.paused) return;
            
            bellAudio.currentTime = 0;
            const playPromise = bellAudio.play();
            if (playPromise !== undefined) {
                playPromise.catch(error => {
                    console.log("Bell playback failed (autoplay policy?):", error);
                    // We don't disable here because interaction might fix it later
                });
            }
        }

        function stopBell() {
            bellAudio.pause();
            bellAudio.currentTime = 0;
        }

        function toggleBell(e) {
            // if (e) e.stopPropagation(); // Removed to allow initAudio to run (start bgAudio)
            
            isBellEnabled = !isBellEnabled;
            localStorage.setItem('bellEnabled', isBellEnabled);
            updateBellUI();

            if (isBellEnabled) {
                playBell();
            } else {
                stopBell();
            }
        }

        if (bellToggle) {
            bellToggle.addEventListener('click', toggleBell);
        }

        if (bellAudio) {
            bellAudio.addEventListener('error', (e) => {
                console.error("Error loading bell sound:", e);
                isBellEnabled = false;
                localStorage.setItem('bellEnabled', false);
                updateBellUI();
                if (bellToggle) {
                    bellToggle.disabled = true;
                    bellToggle.classList.add('opacity-50', 'cursor-not-allowed');
                    bellIcon.textContent = 'error';
                }
            });
        }

        // Check if running as PWA
        function checkPWAMode() {
            isPWA = window.matchMedia('(display-mode: standalone)').matches || 
                   window.navigator.standalone === true ||
                   document.referrer.includes('android-app://');
            return isPWA;
        }

        // Initialize audio with PWA-specific handling
        function initAudio() {
            if (!isAudioInitialized) {
                audio.volume = 1.0;
                audio.load(); // Preload audio
                
                // Start Bell if enabled
                if (isBellEnabled) {
                    playBell();
                }

                // For PWA, try to enable autoplay immediately
                if (isPWA) {
                    audio.play().then(() => {
                        audio.pause(); // Pause immediately after successful play
                        console.log('PWA audio autoplay enabled');
                    }).catch(e => {
                        console.log('PWA audio autoplay failed, will require user interaction:', e);
                    });
                }
                
                isAudioInitialized = true;
            }
        }

        function showVideo() {
            if (isVideoVisible) return; // Prevent overlapping calls
            
            isVideoVisible = true;
            video.style.opacity = '0.3';
            
            // Play audio if initialized
            if (isAudioInitialized) {
                audio.currentTime = 0; // Restart from beginning
                const playPromise = audio.play();
                
                if (playPromise !== undefined) {
                    playPromise.catch(e => {
                        console.log('Audio play failed:', e);
                        // For PWA, try alternative approach
                        if (isPWA) {
                            setTimeout(() => audio.play().catch(() => {}), 100);
                        }
                    });
                }
            }
            
            setTimeout(() => {
                video.style.opacity = '0';
                audio.pause();
                isVideoVisible = false;
            }, 7000);
        }

        // Start the 14-second cycle (7 seconds show + 7 seconds hide)
        function startVideoCycle() {
            showVideo(); // Show immediately
            videoInterval = setInterval(showVideo, 14000); // Repeat every 14 seconds
        }

        // Countdown function
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate.getTime() - now;

            if (distance < 0) {
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }

        const countdownInterval = setInterval(updateCountdown, 1000);

        document.addEventListener('DOMContentLoaded', function() {
            // Restore Bell State
            const savedBellState = localStorage.getItem('bellEnabled');
            if (savedBellState === 'true') {
                isBellEnabled = true;
                updateBellUI();
            }

            updateCountdown();
            
            // Check if running as PWA
            checkPWAMode();
            
            // For PWA, initialize audio immediately
            if (isPWA) {
                initAudio();
            }
            
            setTimeout(startVideoCycle, 1000);
        });

        // Add user interaction listeners to initialize audio (for non-PWA)
        if (!isPWA) {
            document.addEventListener('click', initAudio, { once: true });
            document.addEventListener('keydown', initAudio, { once: true });
            document.addEventListener('touchstart', initAudio, { once: true });
        }

        // Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(err => console.log('SW Error:', err));
        }

        // PWA Install
        let deferredPrompt;
        const installPrompt = document.getElementById('pwa-install-prompt');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            const dismissed = localStorage.getItem('pwa-install-dismissed');
            if (!dismissed || Date.now() - parseInt(dismissed) > 7 * 24 * 60 * 60 * 1000) {
                setTimeout(() => installPrompt.classList.remove('hidden'), 3000);
            }
        });

        function installPWA() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choice) => {
                    deferredPrompt = null;
                    installPrompt.classList.add('hidden');
                });
            }
        }

        function dismissInstallPrompt() {
            installPrompt.classList.add('hidden');
            localStorage.setItem('pwa-install-dismissed', Date.now().toString());
        }
    </script>

<!-- Mobile Navigation -->
@include('components.mobile-nav')

</body>
</html>
