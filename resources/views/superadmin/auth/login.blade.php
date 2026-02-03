<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Super Admin Login</title>
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
                        "primary": "#7c3aed",
                        "primary-dark": "#6d28d9",
                        "background-dark": "#111921",
                        "surface-dark": "#1c2126",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
</head>
<body class="bg-gradient-to-br from-violet-50 via-white to-purple-50 font-display text-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-violet-500 to-purple-600 rounded-3xl mb-4 shadow-xl shadow-violet-500/30">
                <span class="material-symbols-outlined text-white text-4xl">shield_person</span>
            </div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">Super Admin</h1>
            <p class="text-slate-500 mt-2 text-sm">Sign in to access the control panel</p>
        </div>
        
        <form method="POST" action="{{ route('superadmin.login.submit') }}" class="bg-white rounded-3xl p-8 shadow-2xl shadow-violet-500/10 border border-violet-100">
            @csrf
            
            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex items-center gap-3">
                <span class="material-symbols-outlined text-red-500">error</span>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif
            
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm"
                            placeholder="admin@example.com">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input type="password" name="password" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm"
                            placeholder="••••••••">
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-violet-600 focus:ring-violet-500">
                        <span class="text-sm text-slate-600">Remember me</span>
                    </label>
                </div>
                
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold rounded-xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">login</span>
                    Sign In
                </button>
            </div>
        </form>
        
        <p class="text-center text-xs text-slate-400 mt-6">
            Protected area • Authorized personnel only
        </p>
    </div>
</body>
</html>
