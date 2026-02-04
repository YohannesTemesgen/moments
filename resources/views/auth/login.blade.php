<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | Moments</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
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
    
    <style>
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(234, 42, 51, 0.05), transparent),
                        radial-gradient(circle at bottom left, rgba(234, 42, 51, 0.05), transparent);
        }
    </style>
</head>
<body class="bg-white font-sans text-gray-900 min-h-screen flex items-center justify-center p-4 hero-gradient">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 mb-6 group">
                <span class="material-symbols-outlined text-primary text-4xl font-bold group-hover:scale-110 transition-transform">movie_filter</span>
                <span class="text-3xl font-display font-bold tracking-tight text-secondary">Moments</span>
            </a>
            <h1 class="text-2xl font-display font-bold text-secondary">Moment creator</h1>
            <p class="text-gray-500 mt-2 text-sm">Sign in to manage your moments and milestones</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-2xl shadow-gray-200/50 border border-gray-100">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-100 rounded-2xl text-primary text-sm font-medium flex items-center gap-3 animate-shake">
                    <span class="material-symbols-outlined text-xl">error</span>
                    {{ $errors->first() }}
                </div>
                @endif
                
                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                <span class="material-symbols-outlined text-xl">mail</span>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-4 py-4 text-secondary placeholder:text-gray-400 focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white outline-none transition-all"
                                placeholder="name@example.com">
                        </div>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                <span class="material-symbols-outlined text-xl">lock</span>
                            </span>
                            <input type="password" id="password" name="password" required
                                class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-4 py-4 text-secondary placeholder:text-gray-400 focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white outline-none transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="remember" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-200 transition-all checked:bg-primary checked:border-primary focus:ring-0 focus:ring-offset-0">
                                <span class="material-symbols-outlined absolute text-white text-sm opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none">check</span>
                            </div>
                            <span class="text-sm font-medium text-gray-500 group-hover:text-secondary transition-colors">Remember me</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-2xl transition-all transform hover:scale-[1.02] hover:bg-red-700 shadow-xl shadow-primary/20 flex items-center justify-center gap-2 group">
                        <span>Sign In</span>
                        <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Footer Links -->
        <div class="mt-10 text-center space-y-4">
            <p class="text-sm text-gray-500">
                Don't have an account? <a href="#" class="text-primary font-bold hover:underline">Get started for free</a>
            </p>
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-secondary uppercase tracking-widest transition-colors">
                <span class="material-symbols-outlined text-sm">west</span>
                Back to Moments
            </a>
        </div>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>
</body>
</html>
