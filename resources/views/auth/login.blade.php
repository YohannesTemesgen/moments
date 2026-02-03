<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "background-dark": "#111921",
                        "surface-dark": "#1c2126",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
</head>
<body class="bg-slate-50 font-display text-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-2xl mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">admin_panel_settings</span>
            </div>
            <h1 class="text-2xl font-bold">Admin Login</h1>
            <p class="text-slate-500 mt-2 text-sm">Sign in to access the dashboard</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="bg-white rounded-2xl p-6 shadow-xl border border-slate-200">
            @csrf
            
            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
                {{ $errors->first() }}
            </div>
            @endif
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all"
                            placeholder="admin@example.com">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-xl">lock</span>
                        </span>
                        <input type="password" name="password" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all"
                            placeholder="••••••••">
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 bg-white text-primary focus:ring-primary/50">
                        <span class="text-sm text-slate-500">Remember me</span>
                    </label>
                </div>
                
                <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <span>Sign In</span>
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </button>
            </div>
        </form>
        
        <p class="text-center text-slate-500 text-xs mt-6">
            <a href="{{ route('landing') }}" class="hover:text-primary transition-colors">← Back to Landing Page</a>
        </p>
    </div>
</body>
</html>
