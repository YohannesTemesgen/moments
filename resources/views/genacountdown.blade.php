<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Genna Countdown – ገና ቆጠራ</title>

<!-- PWA Meta Tags -->
<meta name="theme-color" content="#000000">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="Genna Countdown">
<link rel="manifest" href="/manifest.json">
<link rel="apple-touch-icon" href="/icons/icon-192x192.png">
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Ethiopic:wght@400;700;900&family=Work+Sans:wght@300;400;600;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#D92323", // Deep Red from flag
                        "eth-green": "#009A44", // Green from flag
                        "eth-yellow": "#FFD700", // Yellow from flag
                        "background-light": "#F9F5EB", // Light Parchment
                        "background-dark": "#1E1810", // Dark Coffee
                        "accent-brown": "#8B4513", // Earthy brown
                        "accent-gold": "#DAA520", // Metallic gold
                        "paper": "#FFFDF5", 
                    },
                    fontFamily: {
                        "display": ["Work Sans", "sans-serif"],
                        "ethiopic": ["Noto Serif Ethiopic", "serif"],
                    },
                    backgroundImage: {
                        'tibeb-pattern': "repeating-linear-gradient(90deg, #009A44 0px, #009A44 10px, #FFD700 10px, #FFD700 20px, #D92323 20px, #D92323 30px)",
                        'mesob-texture': "radial-gradient(circle at center, transparent 0%, transparent 95%, rgba(139, 69, 19, 0.05) 100%), linear-gradient(45deg, rgba(139, 69, 19, 0.02) 25%, transparent 25%, transparent 75%, rgba(139, 69, 19, 0.02) 75%, rgba(139, 69, 19, 0.02))",
                    },
                    boxShadow: {
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                        'glow': '0 0 15px rgba(255, 215, 0, 0.3)',
                    }
                },
            },
        }
    </script>
<style>::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #F9F5EB; }
        ::-webkit-scrollbar-thumb { background: #8B4513; border-radius: 3px; }
        
        /* Bottom Up Expandable Question Section */
        .question-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #FFFDF5;
            border-radius: 1.5rem 1.5rem 0 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, padding 0.4s ease-out;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        }
        .question-section.active {
            max-height: 85vh;
            padding: 2rem 1rem 4rem;
            overflow-y: auto;
        }
        .question-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .question-handle {
            width: 40px;
            height: 4px;
            background: #8B4513;
            border-radius: 2px;
            margin: 0 auto 1.5rem;
            cursor: pointer;
        }
        .question-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .question-item {
            background: rgba(255, 253, 245, 0.9);
            border: 1px solid rgba(139, 69, 19, 0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            font-family: 'Noto Serif Ethiopic', serif;
        }
        .question-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #3E2723;
            margin-bottom: 0.5rem;
        }
        .question-reference {
            font-size: 0.9rem;
            color: #8B4513;
            font-style: italic;
            margin-top: 0.5rem;
        }
        .question-item.correct {
            border-color: #009A44;
            background: rgba(0, 154, 68, 0.1);
        }
        .question-item.incorrect {
            border-color: #D92323;
        }
        .answer-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(139, 69, 19, 0.3);
            border-radius: 0.5rem;
            font-size: 1.25rem;
            text-align: center;
            margin-top: 0.5rem;
            transition: border-color 0.3s;
        }
        .answer-input:focus {
            outline: none;
            border-color: #009A44;
        }
        .answer-input:disabled {
            background: rgba(0, 154, 68, 0.1);
            border-color: #009A44;
        }
        .submit-btn {
            background: linear-gradient(135deg, #009A44, #007a36);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            width: 100%;
            margin-top: 0.5rem;
        }
        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 154, 68, 0.3);
        }
        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .feedback-msg {
            margin-top: 0.5rem;
            font-weight: bold;
            text-align: center;
        }
        .feedback-msg.correct {
            color: #009A44;
        }
        .feedback-msg.incorrect {
            color: #D92323;
        }
        .level-complete-number {
            font-size: 4rem;
            font-weight: 900;
            color: #009A44;
        }
        .level-complete-number.yellow {
            color: #FFD700;
        }
        .level-complete-number.red {
            color: #D92323;
        }
        .level-complete-number.brown {
            color: #8B4513;
        }
        .level-complete-number.stranger {
            color: #E50914;
            text-shadow: 0 0 10px rgba(229, 9, 20, 0.5), 0 0 20px rgba(229, 9, 20, 0.3);
        }
        
        /* Level 4 Code Page Styles - Stranger Things Theme */
        .code-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #000000;
            border-radius: 1.5rem 1.5rem 0 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, padding 0.4s ease-out;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(229, 9, 20, 0.3);
            border: 1px solid #E50914;
        }
        .code-section.active {
            max-height: 85vh;
            padding: 2rem 1rem 4rem;
            overflow-y: auto;
        }
        .code-btn {
            background: linear-gradient(135deg, #E50914, #B8070F);
            color: white;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
            text-shadow: 0 0 8px rgba(229, 9, 20, 0.4);
        }
        .code-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 9, 20, 0.6);
        }
        .code-icon {
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #E50914;
        }
        .stranger-outline {
            color: transparent;
            -webkit-text-stroke: 2px #E50914;
            text-stroke: 2px #E50914;
            text-shadow: 0 0 10px rgba(229, 9, 20, 0.5), 0 0 20px rgba(229, 9, 20, 0.3);
        }
        
        /* Level 3 Contact Styles */
        .contact-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #FFFDF5;
            border-radius: 1.5rem 1.5rem 0 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, padding 0.4s ease-out;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        }
        .contact-section.active {
            max-height: 85vh;
            padding: 2rem 1rem 4rem;
            overflow-y: auto;
        }
        .telegram-btn {
            background: linear-gradient(135deg, #0088cc, #006699);
            color: white;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
        }
        .telegram-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 136, 204, 0.4);
        }
        .telegram-icon {
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #0088cc;
        }
        
        /* Word Scramble Game Styles */
        .scramble-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #FFFDF5;
            border-radius: 1.5rem 1.5rem 0 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, padding 0.4s ease-out;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        }
        .scramble-section.active {
            max-height: 85vh;
            padding: 2rem 1rem 4rem;
            overflow-y: auto;
        }
        .scramble-timer {
            font-size: 2.5rem;
            font-weight: 900;
            color: #FFD700;
            text-align: center;
        }
        .scramble-timer.warning {
            color: #D92323;
            animation: pulse 0.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .scramble-score {
            font-size: 1.25rem;
            font-weight: bold;
            color: #8B4513;
            text-align: center;
        }
        .scramble-word {
            background: linear-gradient(135deg, #FFD700, #DAA520);
            color: #3E2723;
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: 0.3em;
            padding: 1rem 2rem;
            border-radius: 1rem;
            text-align: center;
            margin: 1rem 0;
            text-transform: uppercase;
        }
        .scramble-input {
            width: 100%;
            padding: 1rem;
            font-size: 1.25rem;
            text-align: center;
            text-transform: uppercase;
            border: 3px solid #FFD700;
            border-radius: 0.75rem;
            background: white;
            letter-spacing: 0.2em;
        }
        .scramble-input:focus {
            outline: none;
            border-color: #DAA520;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        }
        .scramble-btn {
            background: linear-gradient(135deg, #FFD700, #DAA520);
            color: #3E2723;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
        }
        .scramble-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
        }
        .scramble-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .scramble-progress {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin: 1rem 0;
        }
        .progress-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
        }
        .progress-dot.correct {
            background: #009A44;
        }
        .progress-dot.incorrect {
            background: #D92323;
        }
        .progress-dot.current {
            background: #FFD700;
            box-shadow: 0 0 8px rgba(255, 215, 0, 0.6);
        }
        .scramble-result {
            text-align: center;
            padding: 2rem;
        }
        .scramble-result.success {
            background: rgba(0, 154, 68, 0.1);
            border: 2px solid #009A44;
            border-radius: 1rem;
        }
        .scramble-result.fail {
            background: rgba(217, 35, 35, 0.1);
            border: 2px solid #D92323;
            border-radius: 1rem;
        }
        
        .glass-panel {
            background: rgba(255, 253, 245, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 69, 19, 0.1);
        }
        @keyframes flicker {
            0%, 100% { opacity: 1; transform: scale(1); filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.6)); }
            50% { opacity: 0.8; transform: scale(0.98); filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.8)); }
        }
        .candle-flame {
            animation: flicker 2s infinite ease-in-out;
        }
        
        /* Flip Card Styles */
        .flip-card {
            perspective: 1000px;
            cursor: pointer;
            height: auto;
            min-height: 200px;
        }
        
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 200px;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }
        
        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }
        
        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            min-height: 200px;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 1rem;
            top: 0;
            left: 0;
        }
        
        .flip-card-front {
            z-index: 2;
        }
        
        .flip-card-back {
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 253, 245, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 69, 19, 0.1);
            padding: 1.5rem;
        }
    </style>
</head>
<body class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark text-[#3E2723] dark:text-[#F9F5EB] overflow-x-hidden font-display transition-colors duration-300">
<div class="h-3 w-full bg-tibeb-pattern shadow-md z-50"></div>
<div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
<div class="absolute inset-0 bg-mesob-texture opacity-60 z-0 bg-[length:40px_40px]"></div>
<div class="absolute bottom-0 left-0 w-full h-[65vh] bg-contain bg-bottom bg-no-repeat opacity-25 dark:opacity-15 mix-blend-multiply dark:mix-blend-overlay z-10" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAWL8c2kqep_IYEOmm6MzLlFNuIIzfuv5W4ajKELYvCWcRRc7Pvm8FJcPNK-zkDoA0Ah9zrLtnhCjS9FNjaFT0Ia_dJrIMe4d4gFxnNJGrq1-5p20caLasI1XWTyU4_t2uDQIUbts8NjhvWehKl-aAXwXLnJUkcUpSIXiH-q3Q16CikJTJf0ikODpVPRwA0XWO9gK-jaRCuYKnvOB618MBpDyNw6DvaU0T8S1JmXooN9uoHJO75pukuDH4lV0UzjB9G2V0wU8xtXog');">
</div>
<div class="absolute inset-0 bg-gradient-to-t from-background-light via-transparent to-background-light/50 dark:from-background-dark dark:via-transparent dark:to-background-dark/50 z-20"></div>
</div>
<div class="relative z-30 flex flex-col min-h-screen">
<header class="flex items-center justify-between px-6 py-6 md:px-12 lg:px-24">
<div class="flex items-center gap-4">
<div class="p-2 rounded-full border border-accent-brown/20 bg-white/40 backdrop-blur-sm shadow-sm">
<span class="material-symbols-outlined text-accent-brown text-2xl">church</span>
</div>
<div>
<h1 class="text-xl font-bold text-primary font-ethiopic leading-none">ገና</h1>
<p class="text-[10px] uppercase tracking-[0.2em] text-accent-brown font-semibold opacity-80 mt-1">Ethiopian Christmas</p>
</div>
</div>
<button class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 dark:bg-black/30 border border-eth-yellow/30 hover:border-eth-yellow hover:bg-white dark:hover:bg-black/50 transition-all group shadow-sm cursor-pointer">
<span class="material-symbols-outlined text-lg text-accent-brown dark:text-eth-yellow group-hover:scale-110 transition-transform">holiday_village</span>
<span class="text-xs font-bold uppercase tracking-wide hidden sm:inline-block">Tree</span>
</button>
</header>
<main class="flex-grow flex flex-col justify-center items-center px-4 py-8 relative"><div class="w-full max-w-5xl mx-auto flex flex-col items-center gap-0">
<div class="text-center space-y-3">
<div class="inline-flex flex-col items-center p-6 rounded-3xl border border-white/40 bg-white/30 backdrop-blur-md shadow-sm max-w-lg mx-auto">
<div class="flex items-center gap-3 mb-2">
<span class="material-symbols-outlined text-eth-yellow text-2xl" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<p class="text-2xl md:text-3xl font-ethiopic text-primary font-bold mb-2">መልካም ገና</p>
<p class="text-sm text-[#3E2723]/70 dark:text-[#EFEBE0]/70 font-display italic max-w-xs leading-relaxed">
                            "May the light of His birth shine upon your home and fill your heart with peace."
                        </p>
</div>
</div>
<p class="text-center text-lg font-ethiopic text-accent-brown/80 mb-4">Next ገና </p>
<div class="w-full grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 max-w-4xl mt-4">
<div class="flip-card" id="level1-card" onclick="handleLevel1Click(this)">
<div class="flip-card-inner">
<div class="flip-card-front">
<div class="glass-panel relative overflow-hidden rounded-2xl p-6 flex flex-col items-center justify-center shadow-card hover:-translate-y-1 transition-transform duration-300 group h-full">
<div class="absolute top-0 w-full h-1.5 bg-eth-green"></div>
<span id="days-count" class="text-6xl md:text-7xl font-black text-eth-green font-ethiopic tracking-tighter">00</span>
<span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 mt-2">Days</span>
<span class="text-sm font-ethiopic text-gray-400">ቀናት</span>
</div>
</div>
<div class="flip-card-back shadow-card" id="level1-back">
<div class="absolute top-0 w-full h-1.5 bg-eth-green"></div>
<div id="level1-gift-content">
<img src="/icons/gift1.png" alt="Gift" class="w-16 h-16 mb-2 mx-auto">
<span class="text-lg font-bold text-eth-green">Level 1</span>
<p class="text-xs text-gray-500 mt-2">Click to open challenge</p>
</div>
<div id="level1-number-content" class="hidden">
<span class="level-complete-number">1</span>
<span class="text-lg font-bold text-eth-green">Complete!</span>
</div>
</div>
</div>
</div>
<div class="flip-card" id="level2-card" onclick="handleLevel2Click(this)">
<div class="flip-card-inner">
<div class="flip-card-front">
<div class="glass-panel relative overflow-hidden rounded-2xl p-6 flex flex-col items-center justify-center shadow-card hover:-translate-y-1 transition-transform duration-300 group h-full">
<div class="absolute top-0 w-full h-1.5 bg-eth-yellow"></div>
<span id="hours-count" class="text-6xl md:text-7xl font-black text-eth-yellow font-ethiopic tracking-tighter">00</span>
<span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 mt-2">Hours</span>
<span class="text-sm font-ethiopic text-gray-400">ሰዓታት</span>
</div>
</div>
<div class="flip-card-back shadow-card" id="level2-back">
<div class="absolute top-0 w-full h-1.5 bg-eth-yellow"></div>
<div id="level2-gift-content">
<img src="/icons/gift2.jpg" alt="Gift" class="w-16 h-16 mb-2 mx-auto">
<span class="text-lg font-bold text-eth-yellow">Level 2</span>
<p class="text-xs text-gray-500 mt-2">Click to play word scramble</p>
</div>
<div id="level2-number-content" class="hidden">
<span class="level-complete-number yellow">2</span>
<span class="text-lg font-bold text-eth-yellow">Complete!</span>
</div>
</div>
</div>
</div>
<div class="flip-card" id="level3-card" onclick="handleLevel3Click(this)">
<div class="flip-card-inner">
<div class="flip-card-front">
<div class="glass-panel relative overflow-hidden rounded-2xl p-6 flex flex-col items-center justify-center shadow-card hover:-translate-y-1 transition-transform duration-300 group h-full">
<div class="absolute top-0 w-full h-1.5 bg-primary"></div>
<span id="minutes-count" class="text-6xl md:text-7xl font-black text-primary font-ethiopic tracking-tighter">00</span>
<span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 mt-2">Minutes</span>
<span class="text-sm font-ethiopic text-gray-400">ደቂቃዎች</span>
</div>
</div>
<div class="flip-card-back shadow-card" id="level3-back">
<div class="absolute top-0 w-full h-1.5 bg-primary"></div>
<div id="level3-gift-content">
<img src="/icons/gift3.jpg" alt="Gift" class="w-16 h-16 mb-2 mx-auto">
<span class="text-lg font-bold text-primary">Level 3</span>
<p class="text-xs text-gray-500 mt-2">Click to get hint</p>
</div>
<div id="level3-number-content" class="hidden">
<span class="level-complete-number" style="color: #D92323;">1</span>
<span class="text-lg font-bold text-primary">Complete!</span>
</div>
</div>
</div>
</div>
<div class="flip-card" id="level4-card" onclick="handleLevel4Click(this)">
<div class="flip-card-inner">
<div class="flip-card-front">
<div class="glass-panel relative overflow-hidden rounded-2xl p-6 flex flex-col items-center justify-center shadow-card bg-white dark:bg-neutral-800 border-accent-brown/20 ring-1 ring-accent-brown/5 h-full">
<div class="absolute top-0 w-full h-1.5 bg-accent-brown"></div>
<div class="absolute -top-6 right-1/2 translate-x-1/2 w-12 h-12 bg-eth-yellow/10 rounded-full blur-xl candle-flame pointer-events-none"></div>
<span id="seconds-count" class="text-6xl md:text-7xl font-black text-accent-brown dark:text-eth-yellow font-ethiopic tracking-tighter relative z-10">00</span>
<span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 mt-2">Seconds</span>
<span class="text-sm font-ethiopic text-gray-400">ሰከንዶች</span>
</div>
</div>
<div class="flip-card-back shadow-card" id="level4-back" style="background: #000000; border: 1px solid #E50914;">
<div class="absolute top-0 w-full h-1.5 bg-gradient-to-r from-red-600 to-red-700"></div>
<div id="level4-gift-content">
<img src="/icons/gift4.webp" alt="Gift" class="w-16 h-16 mb-2 mx-auto">
<span class="text-lg font-bold text-red-600">Level 4</span>
<p class="text-xs text-red-400 mt-2">Click to get code</p>
</div>
<div id="level4-number-content" class="hidden">
<span class="level-complete-number stranger">24</span>
<span class="text-lg font-bold text-red-600">Complete!</span>
</div>
</div>
</div>
</div>
</div>

</div>
</main>

<div class="h-3 w-full bg-tibeb-pattern shadow-inner z-50"></div>
</div>

<!-- Mobile Navigation -->
@include('components.mobile-nav')

<!-- PWA Install Prompt -->
<div id="pwa-install-prompt" class="fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:w-96 bg-gray-900 rounded-xl shadow-2xl p-4 z-50 hidden transform transition-all duration-300 border border-gray-700" style="display: none !important;">
    <div class="flex items-start gap-3">
        <div class="shrink-0 w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-2xl">download</span>
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="font-bold text-white text-sm">Install Genna Countdown</h3>
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

<!-- Bottom Up Expandable Question Section for Level 1 -->
<div id="question-section" class="question-section">
    <div class="question-handle" onclick="toggleQuestionSection()"></div>
    <div class="question-container">
        <div class="question-header">
            <h2 class="text-2xl font-bold text-eth-green font-ethiopic">Level 1 Challenge</h2>
            <button onclick="closeQuestionSection()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <p class="text-sm text-gray-600 mb-4">Answer all questions correctly to complete Level 1!</p>
        
        <div id="questions-list">
            <!-- Question 1 -->
            <div class="question-item" id="q1-container">
                <p class="text-lg font-semibold text-accent-brown">Question 1:</p>
                <p class="question-text">ለኢየሱስ የቀረቡት የስጦታ አይነቶች ስንት ነበሩ?</p>
                <input type="number" id="q1-answer" class="answer-input" placeholder="መልስዎን ያስገቡ">
                <button onclick="checkAnswer(1, 3)" class="submit-btn" id="q1-btn">Submit</button>
                <p id="q1-feedback" class="feedback-msg"></p>
                <p class="question-reference">(ማቴዎስ 2፥11)</p>
            </div>
            
            <!-- Question 2 -->
            <div class="question-item" id="q2-container">
                <p class="text-lg font-semibold text-accent-brown">Question 2:</p>
                <p class="question-text">ኢየሱስ ከተወለደ በኋላ በቤተመቅደስ ለመቅረብ ስንት ቀን አለፈ?</p>
                <input type="number" id="q2-answer" class="answer-input" placeholder="መልስዎን ያስገቡ">
                <button onclick="checkAnswer(2, 40)" class="submit-btn" id="q2-btn">Submit</button>
                <p id="q2-feedback" class="feedback-msg"></p>
                <p class="question-reference">(ሉቃስ 2፥22)</p>
            </div>
            
            <!-- Question 3 -->
            <div class="question-item" id="q3-container">
                <p class="text-lg font-semibold text-accent-brown">Question 3:</p>
                <p class="question-text">በሉቃስና በማቴዎስ ወንጌል ውስጥ ስለ ልደቱ በሚተረከው ታሪክ ላይ፣ ስማቸው የተጠቀሰ መላእክት ስንት ናቸው?</p>
                <input type="number" id="q3-answer" class="answer-input" placeholder="መልስዎን ያስገቡ">
                <button onclick="checkAnswer(3, 1)" class="submit-btn" id="q3-btn">Submit</button>
                <p id="q3-feedback" class="feedback-msg"></p>
                <p class="question-reference">(ሉቃስ 1፥19፣ 1፥26)</p>
            </div>
            
            <!-- Question 4 -->
            <div class="question-item" id="q4-container">
                <p class="text-lg font-semibold text-accent-brown">Question 4:</p>
                <p class="question-text">ማርያም ከመልአኩ ገብርኤል መልክት ከተቀበለች በኋላ ኤልሳቤጥን ለመጎብኘት ስንት ወር በእሷ ቆየች?</p>
                <input type="number" id="q4-answer" class="answer-input" placeholder="መልስዎን ያስገቡ">
                <button onclick="checkAnswer(4, 3)" class="submit-btn" id="q4-btn">Submit</button>
                <p id="q4-feedback" class="feedback-msg"></p>
                <p class="question-reference">(ሉቃስ 1፥56)</p>
            </div>
            
            <!-- Question 5 -->
            <div class="question-item" id="q5-container">
                <p class="text-lg font-semibold text-accent-brown">Question 5:</p>
                <p class="question-text">ከአብርሃም እስከ ኢየሱስ የማቴዎስ ወንጌል ትውልድ ትክክል ስንት ነበሩ?</p>
                <input type="number" id="q5-answer" class="answer-input" placeholder="መልስዎን ያስገቡ">
                <button onclick="checkAnswer(5, 42)" class="submit-btn" id="q5-btn">Submit</button>
                <p id="q5-feedback" class="feedback-msg"></p>
                <p class="question-reference">(ማቴዎስ 1፥17)</p>
            </div>
        </div>
        
        <div id="all-correct-msg" class="hidden text-center mt-6 p-4 bg-eth-green/10 rounded-xl border border-eth-green">
            <span class="material-symbols-outlined text-4xl text-eth-green" style="font-variation-settings: 'FILL' 1;">celebration</span>
            <p class="text-xl font-bold text-eth-green mt-2">Congratulations!</p>
            <p class="text-gray-600">You've completed Level 1!</p>
            <button onclick="completeLevel1()" class="submit-btn mt-4">Claim Your Reward</button>
        </div>
    </div>
</div>

<!-- Bottom Up Expandable Word Scramble Section for Level 2 -->
<div id="scramble-section" class="scramble-section">
    <div class="question-handle" onclick="toggleScrambleSection()"></div>
    <div class="question-container">
        <div class="question-header">
            <h2 class="text-2xl font-bold text-eth-yellow font-ethiopic">Level 2: Word Scramble</h2>
            <button onclick="closeScrambleSection()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <!-- Game Start Screen -->
        <div id="scramble-start" class="text-center">
            <p class="text-gray-600 mb-4">Unscramble 10 words in 60 seconds!</p>
            <p class="text-sm text-gray-500 mb-4">You need at least 8 correct to win.</p>
            <button onclick="startScrambleGame()" class="scramble-btn text-lg px-8 py-3">Start Game</button>
        </div>
        
        <!-- Game Play Screen -->
        <div id="scramble-game" class="hidden">
            <div class="flex justify-between items-center mb-4">
                <div class="scramble-timer" id="scramble-timer">60</div>
                <div class="scramble-score" id="scramble-score">Score: 0/10</div>
            </div>
            
            <div class="scramble-progress" id="scramble-progress">
                <!-- Progress dots will be generated by JS -->
            </div>
            
            <div class="scramble-word" id="scramble-word">LOADING</div>
            
            <div class="text-center mb-3">
                <p class="text-sm text-gray-600 italic" id="scramble-hint">Hint: Loading...</p>
            </div>
            
            <input type="text" id="scramble-input" class="scramble-input" placeholder="Type your answer" autocomplete="off">
            
            <div class="flex gap-3 mt-4">
                <button onclick="submitScrambleAnswer()" class="scramble-btn flex-1">Submit</button>
                <button onclick="skipScrambleWord()" class="scramble-btn flex-1" style="background: linear-gradient(135deg, #8B4513, #6B3410); color: white;">Skip</button>
            </div>
            
            <p id="scramble-feedback" class="feedback-msg mt-3"></p>
        </div>
        
        <!-- Game Result Screen -->
        <div id="scramble-result" class="hidden">
            <div id="scramble-result-content"></div>
        </div>
    </div>
</div>

<!-- Bottom Up Expandable Contact Section for Level 3 -->
<div id="contact-section" class="contact-section">
    <div class="question-handle" onclick="toggleContactSection()"></div>
    <div class="question-container">
        <div class="question-header">
            <h2 class="text-2xl font-bold text-primary font-ethiopic">Level 3: Get Hint</h2>
            <button onclick="closeContactSection()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="text-center space-y-6">
            <div class="p-6 bg-white/50 rounded-xl border border-primary/20">
                <span class="material-symbols-outlined text-4xl text-primary mb-3" style="font-variation-settings: 'FILL' 1;">help</span>
                <p class="text-xl font-semibold text-gray-800 mb-2">Get the hint from this person</p>
                <p class="text-gray-600">Contact for special hints and assistance!</p>
            </div>
            
            <div class="flex justify-center">
                <a href="https://t.me/Yohawi2" target="_blank" class="telegram-btn">
                    <div class="telegram-icon">T</div>
                    <span>Open Telegram Chat</span>
                </a>
            </div>
            
            <div class="text-sm text-gray-500">
                <p>Click the button above to open Telegram and get your hint!</p>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Up Expandable Code Section for Level 4 -->
<div id="code-section" class="code-section">
    <div class="question-handle" onclick="toggleCodeSection()"></div>
    <div class="question-container">
        <div class="question-header">
            <h2 class="text-2xl font-bold text-red-600 font-ethiopic stranger-outline" style="font-family: 'Newsreader', serif;">Level 4: Get Code</h2>
            <button onclick="closeCodeSection()" class="text-red-400 hover:text-red-300 text-2xl">&times;</button>
        </div>
        
        <div class="text-center space-y-6">
            <div class="p-6 bg-black/80 rounded-xl border border-red-600/50">
                <span class="material-symbols-outlined text-4xl text-red-600 mb-3" style="font-variation-settings: 'FILL' 1; text-shadow: 0 0 10px rgba(229, 9, 20, 0.5);">code</span>
                <p class="text-xl font-semibold text-white mb-2" style="font-family: 'Newsreader', serif;">Get the clue in the Upsidedown</p>
                <p class="text-red-300">Everything you see in the page is a hint towards the same number!</p>
            </div>
            
            <div class="flex justify-center">
                <a href="{{ route('landing.original') }}" class="code-btn">
                    <div class="code-icon">C</div>
                    <span>Open the Upsidedown</span>
                </a>
            </div>
            
            <div class="text-sm text-red-400 max-w-md mx-auto">
                <p>Look for the hidden number pattern in the Stranger Life page!</p>
            </div>
        </div>
    </div>
</div>

<script>
// Level 1 state tracking
let level1Flipped = false;
let level1Completed = false;
let level1ShowingNumber = false;
let correctAnswers = { 1: false, 2: false, 3: false, 4: false, 5: false };

// Level 2 state tracking
let level2Flipped = false;
let level2Completed = false;
let level2ShowingNumber = false;

// Level 3 state tracking
let level3Flipped = false;
let level3Completed = false;
let level3ShowingNumber = false;

// Level 4 state tracking
let level4Flipped = false;
let level4Completed = false;
let level4ShowingNumber = false;

// Word Scramble Game State
const scrambleWords = [
    { word: 'GENNA', scrambled: 'ANNEG', hint: 'Ethiopian Christmas celebration' },
    { word: 'CHRISTMAS', scrambled: 'STHCMRASI', hint: 'The birth of Jesus celebration' },
    { word: 'JESUS', scrambled: 'SUSEJ', hint: 'The central figure of Christianity' },
    { word: 'BETHLEHEM', scrambled: 'MEHLHETEB', hint: 'City where Jesus was born' },
    { word: 'ANGEL', scrambled: 'LEGNA', hint: 'Heavenly messenger who announced Jesus birth' },
    { word: 'STAR', scrambled: 'RATS', hint: 'Guided the wise men to baby Jesus' },
    { word: 'MARY', scrambled: 'YRAM', hint: 'Mother of Jesus' },
    { word: 'JOSEPH', scrambled: 'HPESOJ', hint: 'Earthly father of Jesus' },
    { word: 'SHEPHERD', scrambled: 'DREHPEHS', hint: 'First visitors to see baby Jesus' },
    { word: 'MANGER', scrambled: 'REGNAM', hint: 'Where baby Jesus was placed after birth' }
];
let currentWordIndex = 0;
let scrambleScore = 0;
let scrambleTimer = 60;
let scrambleInterval = null;
let wordResults = [];

// Flip card functionality
function flipCard(card) {
    card.classList.toggle('flipped');
}

// Handle Level 1 card click
function handleLevel1Click(card) {
    if (level1Completed) {
        // Toggle between showing number and countdown
        if (level1ShowingNumber) {
            // Flip back to show countdown
            card.classList.remove('flipped');
            level1ShowingNumber = false;
        } else {
            // Flip to show the number 7
            card.classList.add('flipped');
            level1ShowingNumber = true;
        }
    } else if (!level1Flipped) {
        // First flip - show gift/level indicator
        card.classList.add('flipped');
        level1Flipped = true;
    } else {
        // Already flipped, open question section
        openQuestionSection();
    }
}

// Open question section
function openQuestionSection() {
    document.getElementById('question-section').classList.add('active');
}

// Close question section
function closeQuestionSection() {
    document.getElementById('question-section').classList.remove('active');
}

// Toggle question section
function toggleQuestionSection() {
    const section = document.getElementById('question-section');
    if (section.classList.contains('active')) {
        closeQuestionSection();
    } else {
        openQuestionSection();
    }
}

// Check answer for a question
function checkAnswer(questionNum, correctAnswer) {
    const input = document.getElementById(`q${questionNum}-answer`);
    const feedback = document.getElementById(`q${questionNum}-feedback`);
    const container = document.getElementById(`q${questionNum}-container`);
    const btn = document.getElementById(`q${questionNum}-btn`);
    const userAnswer = parseInt(input.value);
    
    if (isNaN(userAnswer)) {
        feedback.textContent = 'Please enter a number!';
        feedback.className = 'feedback-msg incorrect';
        return;
    }
    
    if (userAnswer === correctAnswer) {
        feedback.textContent = `✓ Correct! The answer is ${correctAnswer}`;
        feedback.className = 'feedback-msg correct';
        container.classList.add('correct');
        container.classList.remove('incorrect');
        input.disabled = true;
        btn.disabled = true;
        correctAnswers[questionNum] = true;
        
        // Check if all answers are correct
        checkAllCorrect();
    } else {
        feedback.textContent = `✗ Incorrect. Try again!`;
        feedback.className = 'feedback-msg incorrect';
        container.classList.add('incorrect');
        container.classList.remove('correct');
    }
}

// Check if all questions are answered correctly
function checkAllCorrect() {
    const allCorrect = Object.values(correctAnswers).every(v => v === true);
    if (allCorrect) {
        document.getElementById('all-correct-msg').classList.remove('hidden');
    }
}

// Complete Level 1 and update card
function completeLevel1() {
    level1Completed = true;
    level1ShowingNumber = true;
    
    // Update the card back to show number 7
    document.getElementById('level1-gift-content').classList.add('hidden');
    document.getElementById('level1-number-content').classList.remove('hidden');
    
    // Close question section
    closeQuestionSection();
    
    // Ensure card is flipped to show the number
    document.getElementById('level1-card').classList.add('flipped');
}

// ==================== LEVEL 2: WORD SCRAMBLE ====================

// Handle Level 2 card click
function handleLevel2Click(card) {
    if (level2Completed) {
        // Toggle between showing number and countdown
        if (level2ShowingNumber) {
            card.classList.remove('flipped');
            level2ShowingNumber = false;
        } else {
            card.classList.add('flipped');
            level2ShowingNumber = true;
        }
    } else if (!level2Flipped) {
        // First flip - show gift/level indicator
        card.classList.add('flipped');
        level2Flipped = true;
    } else {
        // Already flipped, open scramble section
        openScrambleSection();
    }
}

// Open scramble section
function openScrambleSection() {
    document.getElementById('scramble-section').classList.add('active');
}

// Close scramble section
function closeScrambleSection() {
    document.getElementById('scramble-section').classList.remove('active');
}

// Toggle scramble section
function toggleScrambleSection() {
    const section = document.getElementById('scramble-section');
    if (section.classList.contains('active')) {
        closeScrambleSection();
    } else {
        openScrambleSection();
    }
}

// Start the word scramble game
function startScrambleGame() {
    // Reset game state
    currentWordIndex = 0;
    scrambleScore = 0;
    scrambleTimer = 60;
    wordResults = [];
    
    // Hide start screen, show game screen
    document.getElementById('scramble-start').classList.add('hidden');
    document.getElementById('scramble-game').classList.remove('hidden');
    document.getElementById('scramble-result').classList.add('hidden');
    
    // Generate progress dots
    const progressContainer = document.getElementById('scramble-progress');
    progressContainer.innerHTML = '';
    for (let i = 0; i < 10; i++) {
        const dot = document.createElement('div');
        dot.className = 'progress-dot' + (i === 0 ? ' current' : '');
        dot.id = `progress-dot-${i}`;
        progressContainer.appendChild(dot);
    }
    
    // Show first word
    showCurrentWord();
    
    // Start timer
    updateTimerDisplay();
    scrambleInterval = setInterval(() => {
        scrambleTimer--;
        updateTimerDisplay();
        
        if (scrambleTimer <= 0) {
            autoAdvanceWord();
        }
    }, 1000);
    
    // Focus input
    document.getElementById('scramble-input').focus();
}

// Update timer display
function updateTimerDisplay() {
    const timerEl = document.getElementById('scramble-timer');
    timerEl.textContent = scrambleTimer;
    
    if (scrambleTimer <= 10) {
        timerEl.classList.add('warning');
    } else {
        timerEl.classList.remove('warning');
    }
}

// Show current scrambled word
function showCurrentWord() {
    if (currentWordIndex < scrambleWords.length) {
        document.getElementById('scramble-word').textContent = scrambleWords[currentWordIndex].scrambled;
        document.getElementById('scramble-hint').textContent = `Hint: ${scrambleWords[currentWordIndex].hint}`;
        document.getElementById('scramble-input').value = '';
        document.getElementById('scramble-feedback').textContent = '';
        updateScoreDisplay();
    }
}

// Update score display
function updateScoreDisplay() {
    document.getElementById('scramble-score').textContent = `Score: ${scrambleScore}/10`;
}

// Update progress dots
function updateProgressDots() {
    for (let i = 0; i < 10; i++) {
        const dot = document.getElementById(`progress-dot-${i}`);
        if (dot) {
            dot.classList.remove('current', 'correct', 'incorrect');
            if (i < wordResults.length) {
                dot.classList.add(wordResults[i] ? 'correct' : 'incorrect');
            } else if (i === currentWordIndex) {
                dot.classList.add('current');
            }
        }
    }
}

// Submit scramble answer
function submitScrambleAnswer() {
    const input = document.getElementById('scramble-input');
    const feedback = document.getElementById('scramble-feedback');
    const userAnswer = input.value.trim().toUpperCase();
    const correctAnswer = scrambleWords[currentWordIndex].word;
    
    if (!userAnswer) {
        feedback.textContent = 'Please type an answer!';
        feedback.className = 'feedback-msg incorrect';
        return;
    }
    
    if (userAnswer === correctAnswer) {
        feedback.textContent = '✓ Correct!';
        feedback.className = 'feedback-msg correct';
        scrambleScore++;
        wordResults.push(true);
    } else {
        feedback.textContent = `✗ It was: ${correctAnswer}`;
        feedback.className = 'feedback-msg incorrect';
        wordResults.push(false);
    }
    
    updateProgressDots();
    
    // Move to next word after brief delay
    setTimeout(() => {
        currentWordIndex++;
        if (currentWordIndex >= scrambleWords.length) {
            endScrambleGame();
        } else {
            showCurrentWord();
            updateProgressDots();
        }
    }, 500);
}

// Skip current word
function skipScrambleWord() {
    const feedback = document.getElementById('scramble-feedback');
    feedback.textContent = `Skipped! It was: ${scrambleWords[currentWordIndex].word}`;
    feedback.className = 'feedback-msg incorrect';
    wordResults.push(false);
    updateProgressDots();
    
    setTimeout(() => {
        currentWordIndex++;
        if (currentWordIndex >= scrambleWords.length) {
            endScrambleGame();
        } else {
            showCurrentWord();
            updateProgressDots();
        }
    }, 500);
}

// Auto-advance to next word when timer expires
function autoAdvanceWord() {
    const feedback = document.getElementById('scramble-feedback');
    feedback.textContent = `Time's up! It was: ${scrambleWords[currentWordIndex].word}`;
    feedback.className = 'feedback-msg incorrect';
    wordResults.push(false);
    updateProgressDots();
    
    setTimeout(() => {
        currentWordIndex++;
        if (currentWordIndex >= scrambleWords.length) {
            endScrambleGame();
        } else {
            showCurrentWord();
            updateProgressDots();
        }
    }, 500);
}

// End the scramble game
function endScrambleGame() {
    clearInterval(scrambleInterval);
    
    // Hide game screen, show result
    document.getElementById('scramble-game').classList.add('hidden');
    document.getElementById('scramble-result').classList.remove('hidden');
    
    const resultContent = document.getElementById('scramble-result-content');
    const won = scrambleScore >= 8;
    
    if (won) {
        resultContent.innerHTML = `
            <div class="scramble-result success">
                <span class="material-symbols-outlined text-5xl text-eth-green" style="font-variation-settings: 'FILL' 1;">celebration</span>
                <h3 class="text-2xl font-bold text-eth-green mt-3">Congratulations!</h3>
                <p class="text-lg text-gray-700 mt-2">You got ${scrambleScore}/10 correct!</p>
                <p class="text-gray-600 mt-1">You've completed Level 2!</p>
                <button onclick="completeLevel2()" class="scramble-btn mt-4">Claim Your Reward</button>
            </div>
        `;
    } else {
        resultContent.innerHTML = `
            <div class="scramble-result fail">
                <span class="material-symbols-outlined text-5xl text-primary" style="font-variation-settings: 'FILL' 1;">sentiment_dissatisfied</span>
                <h3 class="text-2xl font-bold text-primary mt-3">Try Again!</h3>
                <p class="text-lg text-gray-700 mt-2">You got ${scrambleScore}/10 correct.</p>
                <p class="text-gray-600 mt-1">You need at least 8 to win.</p>
                <button onclick="resetScrambleGame()" class="scramble-btn mt-4">Play Again</button>
            </div>
        `;
    }
}

// Reset scramble game to start screen
function resetScrambleGame() {
    document.getElementById('scramble-start').classList.remove('hidden');
    document.getElementById('scramble-game').classList.add('hidden');
    document.getElementById('scramble-result').classList.add('hidden');
}

// Complete Level 2 and update card
function completeLevel2() {
    level2Completed = true;
    level2ShowingNumber = true;
    
    // Update the card back to show number 4
    document.getElementById('level2-gift-content').classList.add('hidden');
    document.getElementById('level2-number-content').classList.remove('hidden');
    
    // Close scramble section
    closeScrambleSection();
    
    // Ensure card is flipped to show the number
    document.getElementById('level2-card').classList.add('flipped');
}

// ==================== LEVEL 3: CONTACT ====================

// Handle Level 3 card click
function handleLevel3Click(card) {
    if (level3Completed) {
        // Toggle between showing number and countdown
        if (level3ShowingNumber) {
            card.classList.remove('flipped');
            level3ShowingNumber = false;
        } else {
            card.classList.add('flipped');
            level3ShowingNumber = true;
        }
    } else if (!level3Flipped) {
        // First flip - show gift/level indicator
        card.classList.add('flipped');
        level3Flipped = true;
    } else {
        // Already flipped, open contact section
        openContactSection();
    }
}

// Open contact section
function openContactSection() {
    document.getElementById('contact-section').classList.add('active');
}

// Close contact section
function closeContactSection() {
    document.getElementById('contact-section').classList.remove('active');
}

// Toggle contact section
function toggleContactSection() {
    const section = document.getElementById('contact-section');
    if (section.classList.contains('active')) {
        closeContactSection();
    } else {
        openContactSection();
    }
}

// Complete Level 3 and update card
function completeLevel3() {
    level3Completed = true;
    level3ShowingNumber = true;
    
    // Update the card back to show number 1
    document.getElementById('level3-gift-content').classList.add('hidden');
    document.getElementById('level3-number-content').classList.remove('hidden');
    
    // Close contact section
    closeContactSection();
    
    // Ensure card is flipped to show the number
    document.getElementById('level3-card').classList.add('flipped');
}

// ==================== LEVEL 4: CODE PAGE ====================

// Handle Level 4 card click
function handleLevel4Click(card) {
    if (level4Completed) {
        // Toggle between showing number and countdown
        if (level4ShowingNumber) {
            card.classList.remove('flipped');
            level4ShowingNumber = false;
        } else {
            card.classList.add('flipped');
            level4ShowingNumber = true;
        }
    } else if (!level4Flipped) {
        // First flip - show gift/level indicator
        card.classList.add('flipped');
        level4Flipped = true;
    } else {
        // Already flipped, open code section
        openCodeSection();
    }
}

// Open code section
function openCodeSection() {
    document.getElementById('code-section').classList.add('active');
}

// Close code section
function closeCodeSection() {
    document.getElementById('code-section').classList.remove('active');
}

// Toggle code section
function toggleCodeSection() {
    const section = document.getElementById('code-section');
    if (section.classList.contains('active')) {
        closeCodeSection();
    } else {
        openCodeSection();
    }
}

// Complete Level 4 and update card
function completeLevel4() {
    level4Completed = true;
    level4ShowingNumber = true;
    
    // Update the card back to show number 24
    document.getElementById('level4-gift-content').classList.add('hidden');
    document.getElementById('level4-number-content').classList.remove('hidden');
    
    // Close code section
    closeCodeSection();
    
    // Ensure card is flipped to show the number
    document.getElementById('level4-card').classList.add('flipped');
}

// Add enter key support for scramble input
document.addEventListener('DOMContentLoaded', function() {
    const scrambleInput = document.getElementById('scramble-input');
    if (scrambleInput) {
        scrambleInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                submitScrambleAnswer();
            }
        });
    }
});

// Countdown functionality
function updateCountdown() {
    // Set target date to Ethiopian Christmas (January 7th) at midnight
    const now = new Date();
    const currentYear = now.getFullYear();
    let targetYear = currentYear;
    
    // If we've passed January 7th this year, count down to next year's
    const targetDate = new Date(targetYear, 0, 7); // Month 0 = January
    
    if (now > targetDate) {
        targetYear++;
        targetDate.setFullYear(targetYear);
    }
    
    const timeRemaining = targetDate - now;
    
    // Calculate time units
    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
    
    // Update the display elements
    const daysElement = document.getElementById('days-count');
    const hoursElement = document.getElementById('hours-count');
    const minutesElement = document.getElementById('minutes-count');
    const secondsElement = document.getElementById('seconds-count');
    
    if (daysElement) {
        daysElement.textContent = String(days).padStart(2, '0');
    }
    if (hoursElement) {
        hoursElement.textContent = String(hours).padStart(2, '0');
    }
    if (minutesElement) {
        minutesElement.textContent = String(minutes).padStart(2, '0');
    }
    if (secondsElement) {
        secondsElement.textContent = String(seconds).padStart(2, '0');
    }
    
    // Check if countdown is complete
    if (timeRemaining <= 0) {
        // Show celebration message
        const countdownDisplay = document.querySelector('.grid.grid-cols-2');
        if (countdownDisplay) {
            countdownDisplay.innerHTML = `
                <div class="col-span-2 md:col-span-4 text-center">
                    <h2 class="text-4xl md:text-6xl font-black text-primary font-ethiopic mb-4">
                        Melkam Genna! መልካም ገና!
                    </h2>
                    <p class="text-xl text-[#3E2723] dark:text-[#EFEBE0]">
                        Ethiopian Christmas is here!
                    </p>
                </div>
            `;
        }
        clearInterval(countdownInterval);
    }
}

// Update countdown immediately and then every second
updateCountdown();
const countdownInterval = setInterval(updateCountdown, 1000);

// ==================== PWA FUNCTIONALITY ====================

// Service Worker Registration
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(err => console.log('SW Error:', err));
}

// PWA Install Functionality
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

// Check if running as PWA
let isPWA = false;
function checkPWAMode() {
    isPWA = window.matchMedia('(display-mode: standalone)').matches || 
           window.navigator.standalone === true ||
           document.referrer.includes('android-app://');
    return isPWA;
}

// Initialize PWA check on load
document.addEventListener('DOMContentLoaded', function() {
    checkPWAMode();
    console.log('PWA mode:', isPWA);
});
</script>

</body></html>
