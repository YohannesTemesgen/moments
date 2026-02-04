<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Moment creator Dashboard')</title>
    
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
<body class="bg-gradient-to-br from-violet-50 via-white to-purple-50 font-display text-slate-900 overflow-hidden h-screen w-full">
    <div class="flex h-full w-full overflow-hidden">
        <!-- Sidebar Navigation (Desktop) -->
        <aside class="hidden lg:flex flex-col w-72 bg-white border-r border-violet-100 shadow-xl shadow-violet-500/5 z-30">
            <div class="p-6 border-b border-violet-100">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl size-12 flex items-center justify-center shadow-lg shadow-violet-500/30">
                        <span class="material-symbols-outlined text-white text-2xl">shield_person</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold tracking-tight text-slate-900">Moment creator</h1>
                        <p class="text-xs text-slate-500">System Control</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-2 no-scrollbar">
                <a href="{{ route('superadmin.dashboard') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.dashboard') ? 'bg-violet-600 text-white shadow-lg shadow-violet-500/30' : 'text-slate-600 hover:bg-violet-50 hover:text-primary' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('superadmin.dashboard') ? 'filled' : '' }}">dashboard</span>
                    <span class="font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('superadmin.users.index') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.users.index') ? 'bg-violet-600 text-white shadow-lg shadow-violet-500/30' : 'text-slate-600 hover:bg-violet-50 hover:text-primary' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('superadmin.users.index') ? 'filled' : '' }}">group</span>
                    <span class="font-semibold">User Management</span>
                </a>

                <a href="{{ route('superadmin.users.create') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.users.create') ? 'bg-violet-600 text-white shadow-lg shadow-violet-500/30' : 'text-slate-600 hover:bg-violet-50 hover:text-primary' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('superadmin.users.create') ? 'filled' : '' }}">person_add</span>
                    <span class="font-semibold">Add New User</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Settings</p>
                </div>

                <a href="{{ route('superadmin.profile') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.profile') ? 'bg-violet-600 text-white shadow-lg shadow-violet-500/30' : 'text-slate-600 hover:bg-violet-50 hover:text-primary' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('superadmin.profile') ? 'filled' : '' }}">person</span>
                    <span class="font-semibold">Profile Settings</span>
                </a>

                <a href="{{ route('superadmin.settings') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.settings') ? 'bg-violet-600 text-white shadow-lg shadow-violet-500/30' : 'text-slate-600 hover:bg-violet-50 hover:text-primary' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('superadmin.settings') ? 'filled' : '' }}">settings</span>
                    <span class="font-semibold">System Settings</span>
                </a>
            </nav>

            <div class="p-4 border-t border-violet-100 bg-slate-50/50">
                <div class="flex items-center gap-3 px-2 mb-4">
                    <div class="size-10 rounded-full bg-violet-100 flex items-center justify-center text-primary font-bold">
                        {{ strtoupper(substr(Auth::guard('superadmin')->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::guard('superadmin')->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 truncate">{{ Auth::guard('superadmin')->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('superadmin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all font-semibold">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 h-full relative overflow-hidden">
            @yield('content')

            <!-- Bottom Navigation (Mobile) -->
            <nav class="lg:hidden fixed bottom-0 w-full z-40 bg-white/95 backdrop-blur-lg border-t border-violet-100 pb-safe shadow-lg shadow-violet-500/5">
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
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
