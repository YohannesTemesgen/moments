<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin Dashboard')</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#7c3aed">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
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
                        "primary": "#7c3aed",
                        "primary-dark": "#6d28d9",
                        "background-light": "#f5f3ff",
                        "background-dark": "#111921",
                        "surface-dark": "#1c2126",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .material-symbols-outlined.filled { font-variation-settings: 'FILL' 1; }
    </style>
    @yield('styles')
</head>
<body class="bg-gradient-to-br from-violet-50 via-white to-purple-50 font-display text-slate-900 overflow-hidden h-screen w-full flex flex-col">
    @yield('content')
    
    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 w-full z-40 bg-white/95 backdrop-blur-lg border-t border-violet-100 pb-safe shadow-lg shadow-violet-500/5">
        <div class="flex items-center justify-around h-16 max-w-md mx-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full {{ request()->routeIs('superadmin.dashboard') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }} transition-colors">
                <span class="material-symbols-outlined {{ request()->routeIs('superadmin.dashboard') ? 'filled' : '' }} text-[24px]">dashboard</span>
                <span class="text-[10px] font-medium">Dashboard</span>
            </a>
            <a href="{{ route('superadmin.users.index') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full {{ request()->routeIs('superadmin.users.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }} transition-colors">
                <span class="material-symbols-outlined {{ request()->routeIs('superadmin.users.*') ? 'filled' : '' }} text-[24px]">group</span>
                <span class="text-[10px] font-medium">Users</span>
            </a>
            <a href="{{ route('superadmin.users.create') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full relative">
                <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-violet-600 to-purple-600 text-white rounded-2xl shadow-lg shadow-violet-500/40 -mt-2">
                    <span class="material-symbols-outlined text-[28px]">person_add</span>
                </div>
                <span class="text-[10px] font-medium text-primary">Add User</span>
            </a>
            <a href="{{ route('superadmin.profile') }}" class="flex flex-col items-center justify-center gap-1 w-full h-full {{ request()->routeIs('superadmin.profile') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }} transition-colors">
                <span class="material-symbols-outlined {{ request()->routeIs('superadmin.profile') ? 'filled' : '' }} text-[24px]">person</span>
                <span class="text-[10px] font-medium">Profile</span>
            </a>
            <form action="{{ route('superadmin.logout') }}" method="POST" class="w-full h-full">
                @csrf
                <button type="submit" class="flex flex-col items-center justify-center gap-1 w-full h-full text-slate-400 hover:text-red-500 transition-colors">
                    <span class="material-symbols-outlined text-[24px]">logout</span>
                    <span class="text-[10px] font-medium">Logout</span>
                </button>
            </form>
        </div>
        <div class="h-[env(safe-area-inset-bottom)] w-full"></div>
    </nav>
    
    @yield('scripts')
</body>
</html>
