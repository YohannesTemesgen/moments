<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Moments | Capture and Countdown Your Life's Milestones</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Moments is the ultimate countdown and memory tracker. Capture, store, and countdown to your most important life events with ease.">
    <meta name="keywords" content="countdown, memory tracker, milestones, event tracker, personal organizer">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#ea2a33">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192x192.png">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                        "secondary": "#1a1a1a",
                        "accent": "#f8f6f6",
                    },
                    fontFamily: {
                        "sans": ["Inter", "sans-serif"],
                        "display": ["Lexend", "sans-serif"]
                    },
                },
            },
        }
    </script>
    
    <!-- Animation Library (AOS) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        [data-aos] {
            pointer-events: none;
        }
        .aos-animate {
            pointer-events: auto;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(234, 42, 51, 0.05), transparent),
                        radial-gradient(circle at bottom left, rgba(234, 42, 51, 0.05), transparent);
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans selection:bg-primary selection:text-white">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-nav border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-3xl font-bold">movie_filter</span>
                    <span class="text-xl sm:text-2xl font-display font-bold tracking-tight text-secondary">Moments</span>
                </div>
                
                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">Features</a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">Testimonials</a>
                    <a href="#pricing" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">Pricing</a>
                    <a href="#contact" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">Contact</a>
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-primary text-white rounded-full text-sm font-bold hover:bg-red-700 transition-all transform hover:scale-105 shadow-lg shadow-primary/20">Get Started</a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-600">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>
            </div>
        </div>
        
        <!-- Mobile Nav -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 animate-fade-in-down">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#features" class="block px-3 py-4 text-base font-medium text-gray-600 border-b border-gray-50">Features</a>
                <a href="#testimonials" class="block px-3 py-4 text-base font-medium text-gray-600 border-b border-gray-50">Testimonials</a>
                <a href="#pricing" class="block px-3 py-4 text-base font-medium text-gray-600 border-b border-gray-50">Pricing</a>
                <a href="#contact" class="block px-3 py-4 text-base font-medium text-gray-600">Contact</a>
                <div class="pt-4 px-3">
                    <a href="{{ route('login') }}" class="block w-full text-center px-5 py-3 bg-primary text-white rounded-xl text-base font-bold">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 sm:pt-48 sm:pb-32 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-widest uppercase text-primary bg-red-50 rounded-full">Coming Soon: Version 2.0</span>
                <h1 class="text-4xl sm:text-6xl md:text-7xl font-display font-extrabold text-secondary leading-[1.1] mb-8">
                    Capture Every <span class="text-primary italic">Moment</span> <br class="hidden sm:block"> Before It's Gone
                </h1>
                <p class="max-w-2xl mx-auto text-lg sm:text-xl text-gray-500 mb-10 leading-relaxed">
                    The ultimate countdown and memory tracker for your life's most important events. Store memories, set goals, and celebrate milestones.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-white rounded-full text-lg font-bold hover:bg-red-700 transition-all transform hover:scale-105 shadow-xl shadow-primary/30 flex items-center justify-center gap-2">
                        Start Your Journey <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white text-secondary border-2 border-gray-100 rounded-full text-lg font-bold hover:border-primary/20 transition-all flex items-center justify-center">
                        See Features
                    </a>
                </div>
            </div>
            
            <!-- Hero Image/Mockup Placeholder -->
            <div class="mt-16 sm:mt-24 relative" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200">
                <div class="max-w-5xl mx-auto bg-gray-900 rounded-2xl sm:rounded-[2rem] shadow-2xl overflow-hidden border-8 border-gray-800 aspect-video flex items-center justify-center relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-transparent"></div>
                    <span class="material-symbols-outlined text-white/10 text-9xl sm:text-[12rem]">timer</span>
                    <div class="absolute bottom-8 left-8 right-8 text-white">
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-sm font-bold tracking-widest uppercase text-primary mb-2">Next Milestone</p>
                                <h3 class="text-2xl sm:text-4xl font-display font-bold">World Tour 2026</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl sm:text-5xl font-mono font-bold">142:08:12:45</p>
                                <p class="text-xs tracking-widest uppercase opacity-60">D : H : M : S</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 sm:py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 sm:mb-24" data-aos="fade-up">
                <h2 class="text-3xl sm:text-5xl font-display font-bold text-secondary mb-4">Built for Your Best Days</h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">Powerful tools to help you track what matters most.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <span class="material-symbols-outlined text-primary text-3xl group-hover:text-white">history_toggle_off</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Smart Countdowns</h3>
                    <p class="text-gray-500 leading-relaxed">High-precision timers for every event. From seconds to years, never miss a beat.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <span class="material-symbols-outlined text-primary text-3xl group-hover:text-white">photo_library</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Media Vault</h3>
                    <p class="text-gray-500 leading-relaxed">Attach photos, videos, and notes to your countdowns. Relive the journey later.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <span class="material-symbols-outlined text-primary text-3xl group-hover:text-white">devices</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Seamless Sync</h3>
                    <p class="text-gray-500 leading-relaxed">Your moments follow you everywhere. iOS, Android, and Web — all perfectly synced.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <span class="material-symbols-outlined text-primary text-3xl group-hover:text-white">notifications_active</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Smart Alerts</h3>
                    <p class="text-gray-500 leading-relaxed">Custom notifications that adapt to your schedule. Stay informed, not overwhelmed.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 sm:py-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                <div class="lg:w-1/2" data-aos="fade-right">
                    <span class="text-primary font-bold tracking-widest uppercase text-sm">Testimonials</span>
                    <h2 class="text-3xl sm:text-5xl font-display font-bold text-secondary mt-4 mb-6 leading-tight">Trusted by Thousands of Memory Keepers</h2>
                    <p class="text-lg text-gray-500 mb-8">Join over 50,000+ users who are capturing their life stories with Moments.</p>
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-2">
                            <img src="https://i.pravatar.cc/100?u=1" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://i.pravatar.cc/100?u=2" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://i.pravatar.cc/100?u=3" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://i.pravatar.cc/100?u=4" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                        </div>
                        <span class="text-sm font-medium text-gray-600">4.9/5 Rating on App Store</span>
                    </div>
                </div>
                
                <div class="lg:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-6" data-aos="fade-left">
                    <!-- Testimonial 1 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm sm:mt-8">
                        <div class="flex text-yellow-400 mb-4">
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                        </div>
                        <p class="text-gray-600 italic mb-6">"Moments helped me stay organized for my wedding. The photo feature is a game changer!"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-full overflow-hidden">
                                <img src="https://i.pravatar.cc/100?u=jane" alt="Jane Doe">
                            </div>
                            <div>
                                <h4 class="font-bold text-secondary text-sm">Sarah Jenkins</h4>
                                <p class="text-xs text-gray-400">Bride-to-be</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex text-yellow-400 mb-4">
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                        </div>
                        <p class="text-gray-600 italic mb-6">"The best countdown app I've ever used. Simple, beautiful, and the sync is flawless."</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-full overflow-hidden">
                                <img src="https://i.pravatar.cc/100?u=john" alt="John Smith">
                            </div>
                            <div>
                                <h4 class="font-bold text-secondary text-sm">Marcus Chen</h4>
                                <p class="text-xs text-gray-400">Travel Blogger</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 sm:py-32 bg-secondary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 sm:mb-24" data-aos="fade-up">
                <h2 class="text-3xl sm:text-5xl font-display font-bold mb-4">Simple, Transparent Pricing</h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">Choose the plan that fits your journey.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Free Plan -->
                <div class="bg-white/5 p-8 sm:p-10 rounded-3xl border border-white/10 flex flex-col hover:bg-white/10 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl font-bold mb-2">Explorer</h3>
                    <p class="text-gray-400 mb-6 text-sm">Perfect for getting started.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-bold">$0</span>
                        <span class="text-gray-400">/forever</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            3 Active Countdowns
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            Basic Media Uploads
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            Web Access
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-4 bg-white/10 text-white rounded-xl font-bold hover:bg-white/20 transition-all text-center">Get Started</a>
                </div>
                
                <!-- Pro Plan -->
                <div class="bg-primary p-8 sm:p-10 rounded-3xl shadow-2xl shadow-primary/20 flex flex-col transform md:scale-105 relative z-10" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 right-10 transform -translate-y-1/2 px-4 py-1 bg-white text-primary text-xs font-bold rounded-full uppercase tracking-widest shadow-lg">Most Popular</div>
                    <h3 class="text-xl font-bold mb-2">Memory Keeper</h3>
                    <p class="text-red-100 mb-6 text-sm">For those who want it all.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-bold">$9.99</span>
                        <span class="text-red-100">/month</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-white">check_circle</span>
                            Unlimited Countdowns
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-white">check_circle</span>
                            HD Media & Video Support
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-white">check_circle</span>
                            All Devices & App Sync
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-white">check_circle</span>
                            Priority Support
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-4 bg-white text-primary rounded-xl font-bold hover:bg-gray-50 transition-all text-center">Go Pro</a>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="bg-white/5 p-8 sm:p-10 rounded-3xl border border-white/10 flex flex-col hover:bg-white/10 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-xl font-bold mb-2">Legacy</h3>
                    <p class="text-gray-400 mb-6 text-sm">For teams and large events.</p>
                    <div class="mb-8">
                        <span class="text-4xl font-bold">Custom</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            Everything in Pro
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            Custom Branding
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            API Access
                        </li>
                    </ul>
                    <a href="#contact" class="w-full py-4 bg-white/10 text-white rounded-xl font-bold hover:bg-white/20 transition-all text-center">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 sm:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-[2.5rem] p-8 sm:p-16 lg:p-24 overflow-hidden relative">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 relative z-10">
                    <div data-aos="fade-right">
                        <h2 class="text-3xl sm:text-5xl font-display font-bold text-secondary mb-6 leading-tight">Let's Talk About Your <span class="text-primary">Moments</span></h2>
                        <p class="text-lg text-gray-500 mb-10">Have questions? Our team is here to help you get the most out of your memories.</p>
                        
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary">mail</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Email Us</p>
                                    <p class="text-secondary font-bold">hello@moments.app</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary">location_on</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Office</p>
                                    <p class="text-secondary font-bold">San Francisco, CA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-gray-200/50" data-aos="fade-left">
                        <form id="contactForm" class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-secondary mb-2">Name</label>
                                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-xl border-gray-100 focus:border-primary focus:ring-primary transition-all" placeholder="John Doe">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-bold text-secondary mb-2">Email</label>
                                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-xl border-gray-100 focus:border-primary focus:ring-primary transition-all" placeholder="john@example.com">
                                </div>
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-bold text-secondary mb-2">Subject</label>
                                <select id="subject" name="subject" class="w-full px-4 py-3 rounded-xl border-gray-100 focus:border-primary focus:ring-primary transition-all">
                                    <option>General Inquiry</option>
                                    <option>Technical Support</option>
                                    <option>Sales & Pricing</option>
                                    <option>Partnership</option>
                                </select>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-bold text-secondary mb-2">Message</label>
                                <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3 rounded-xl border-gray-100 focus:border-primary focus:ring-primary transition-all" placeholder="How can we help?"></textarea>
                            </div>
                            <button type="submit" class="w-full py-4 bg-primary text-white rounded-xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-primary/20">Send Message</button>
                            <div id="form-message" class="hidden text-center text-sm font-medium mt-4"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-primary text-3xl font-bold">movie_filter</span>
                        <span class="text-2xl font-display font-bold tracking-tight text-secondary">Moments</span>
                    </div>
                    <p class="text-gray-500 max-w-sm mb-8 leading-relaxed">
                        Making every second count. Moments helps you track, celebrate, and remember the milestones that define your life.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-secondary mb-6">Product</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#features" class="hover:text-primary transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-primary transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Mobile App</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">What's New</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-secondary mb-6">Company</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-primary transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">© 2026 Moments App. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <span class="text-xs text-gray-300 uppercase tracking-widest font-bold">Made with Love in SF</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 100,
            });

            // Mobile Menu Toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const icon = mobileMenuBtn.querySelector('.material-symbols-outlined');
                icon.textContent = mobileMenu.classList.contains('hidden') ? 'menu' : 'close';
            });

            // Close mobile menu on link click
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.querySelector('.material-symbols-outlined').textContent = 'menu';
                });
            });

            // Navbar background on scroll
            window.addEventListener('scroll', () => {
                const nav = document.querySelector('nav');
                if (window.scrollY > 50) {
                    nav.classList.add('shadow-md');
                } else {
                    nav.classList.remove('shadow-md');
                }
            });

            // Form Validation and Submission
            const contactForm = document.getElementById('contactForm');
            const formMessage = document.getElementById('form-message');

            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = contactForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                submitBtn.disabled = true;
                submitBtn.textContent = 'Sending...';
                
                // Simulate form submission
                setTimeout(() => {
                    contactForm.reset();
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    
                    formMessage.textContent = 'Thank you! Your message has been sent successfully.';
                    formMessage.classList.remove('hidden', 'text-red-500');
                    formMessage.classList.add('text-green-500');
                    
                    setTimeout(() => {
                        formMessage.classList.add('hidden');
                    }, 5000);
                }, 1500);
            });
        });
    </script>
</body>
</html>
