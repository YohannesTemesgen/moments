<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($type ?? 'login') === 'login' ? 'Sign In' : 'Create Account' }} | Moments</title>
    
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
        .tab-active {
            @apply text-secondary border-b-2 border-primary;
        }
    </style>
</head>
<body class="bg-white font-sans text-gray-900 min-h-screen flex items-center justify-center p-4 hero-gradient">
    <div class="w-full max-w-md" id="auth-container">
        <!-- Logo/Header -->
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 mb-6 group">
                <span class="material-symbols-outlined text-primary text-4xl font-bold group-hover:scale-110 transition-transform">movie_filter</span>
                <span class="text-3xl font-display font-bold tracking-tight text-secondary">Moments</span>
            </a>
            <h1 id="auth-title" class="text-2xl font-display font-bold text-secondary">
                {{ ($type ?? 'login') === 'login' ? 'Moment creator' : 'Join Moments' }}
            </h1>
            <p id="auth-subtitle" class="text-gray-500 mt-2 text-sm">
                {{ ($type ?? 'login') === 'login' ? 'Sign in to manage your moments and milestones' : 'Create an account to start tracking your moments' }}
            </p>
        </div>
        
        <!-- Auth Card -->
        <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-gray-100">
                <button onclick="toggleAuth('login')" id="tab-login" 
                    class="flex-1 py-4 text-sm font-bold transition-all {{ ($type ?? 'login') === 'login' ? 'text-secondary border-b-2 border-primary' : 'text-gray-400 hover:text-gray-600' }}">
                    Sign In
                </button>
                <button onclick="toggleAuth('signup')" id="tab-signup" 
                    class="flex-1 py-4 text-sm font-bold transition-all {{ ($type ?? 'login') === 'register' ? 'text-secondary border-b-2 border-primary' : 'text-gray-400 hover:text-gray-600' }}">
                    Create Account
                </button>
            </div>

            <div class="p-8 sm:p-10">
                <!-- Error Messages -->
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-primary text-sm font-medium flex items-center gap-3 animate-shake">
                    <span class="material-symbols-outlined text-xl">error</span>
                    <div class="flex flex-col">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Login Form -->
                <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-6 {{ ($type ?? 'login') === 'login' ? '' : 'hidden' }}">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label for="login-email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">mail</span>
                                </span>
                                <input type="email" id="login-email" name="email" value="{{ old('email') }}" required
                                    class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-4 py-4 text-secondary placeholder:text-gray-400 focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white outline-none transition-all"
                                    placeholder="name@example.com">
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-2 ml-1">
                                <label for="login-password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Password</label>
                                <a href="#" class="text-xs font-bold text-primary hover:underline">Forgot?</a>
                            </div>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">lock</span>
                                </span>
                                <input type="password" id="login-password" name="password" required
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

                <!-- Signup Form -->
                <form id="signup-form" method="POST" action="{{ route('register') }}" class="space-y-6 {{ ($type ?? 'login') === 'register' ? '' : 'hidden' }}">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label for="signup-name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Username</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">person</span>
                                </span>
                                <input type="text" id="signup-name" name="name" value="{{ old('name') }}" required
                                    class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-4 py-4 text-secondary placeholder:text-gray-400 focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white outline-none transition-all"
                                    placeholder="johndoe">
                            </div>
                        </div>

                        <div>
                            <label for="signup-email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">mail</span>
                                </span>
                                <input type="email" id="signup-email" name="email" value="{{ old('email') }}" required
                                    class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-4 py-4 text-secondary placeholder:text-gray-400 focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white outline-none transition-all"
                                    placeholder="name@example.com">
                            </div>
                        </div>
                        
                        <div>
                            <label for="signup-password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">lock</span>
                                </span>
                                <input type="password" id="signup-password" name="password" required
                                    class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-4 py-4 text-secondary placeholder:text-gray-400 focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white outline-none transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div>
                            <label for="signup-password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Confirm Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">lock_reset</span>
                                </span>
                                <input type="password" id="signup-password_confirmation" name="password_confirmation" required
                                    class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-4 py-4 text-secondary placeholder:text-gray-400 focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white outline-none transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-2xl transition-all transform hover:scale-[1.02] hover:bg-red-700 shadow-xl shadow-primary/20 flex items-center justify-center gap-2 group">
                            <span>Create Account</span>
                            <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">person_add</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Footer Links -->
        <div class="mt-10 text-center space-y-4">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-secondary uppercase tracking-widest transition-colors">
                <span class="material-symbols-outlined text-sm">west</span>
                Back to Moments
            </a>
        </div>
    </div>

    <script>
        function toggleAuth(type) {
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');
            const authTitle = document.getElementById('auth-title');
            const authSubtitle = document.getElementById('auth-subtitle');
            const pageTitle = document.querySelector('title');
            
            const tabLogin = document.getElementById('tab-login');
            const tabSignup = document.getElementById('tab-signup');

            if (type === 'signup') {
                loginForm.classList.add('hidden');
                signupForm.classList.remove('hidden');
                
                tabLogin.classList.remove('text-secondary', 'border-b-2', 'border-primary');
                tabLogin.classList.add('text-gray-400');
                
                tabSignup.classList.add('text-secondary', 'border-b-2', 'border-primary');
                tabSignup.classList.remove('text-gray-400');

                authTitle.innerText = 'Join Moments';
                authSubtitle.innerText = 'Create an account to start tracking your moments';
                pageTitle.innerText = 'Create Account | Moments';
                window.history.pushState({}, '', '{{ route('register') }}');
            } else {
                signupForm.classList.add('hidden');
                loginForm.classList.remove('hidden');

                tabSignup.classList.remove('text-secondary', 'border-b-2', 'border-primary');
                tabSignup.classList.add('text-gray-400');
                
                tabLogin.classList.add('text-secondary', 'border-b-2', 'border-primary');
                tabLogin.classList.remove('text-gray-400');

                authTitle.innerText = 'Moment creator';
                authSubtitle.innerText = 'Sign in to manage your moments and milestones';
                pageTitle.innerText = 'Sign In | Moments';
                window.history.pushState({}, '', '{{ route('login') }}');
            }
        }
    </script>

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
