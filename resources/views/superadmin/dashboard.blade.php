@extends('superadmin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <div class="relative lg:hidden">
                <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-full size-10 flex items-center justify-center shadow-lg shadow-violet-500/30">
                    <span class="material-symbols-outlined text-white text-xl">shield_person</span>
                </div>
                <div class="absolute bottom-0 right-0 size-3 bg-green-500 rounded-full border-2 border-white ring-2 ring-green-500/20"></div>
            </div>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-900">Dashboard Overview</h1>
                <p class="text-xs lg:text-sm text-slate-500">Welcome back, {{ Auth::guard('superadmin')->user()->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.users.create') }}" class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 transition-all text-sm font-semibold">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>Add User</span>
            </a>
            <a href="{{ route('superadmin.users.create') }}" class="lg:hidden flex items-center justify-center size-10 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 transition-all">
                <span class="material-symbols-outlined text-[22px]">person_add</span>
            </a>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6 space-y-8">
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <div class="bg-white rounded-3xl p-4 lg:p-6 shadow-lg shadow-violet-500/5 border border-violet-100 hover:border-violet-200 transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-500/30 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl lg:text-3xl">group</span>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-black text-slate-900">{{ $totalUsers }}</p>
                        <p class="text-xs lg:text-sm font-medium text-slate-500">Total Users</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl p-4 lg:p-6 shadow-lg shadow-violet-500/5 border border-violet-100 hover:border-violet-200 transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl lg:text-3xl">verified_user</span>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-black text-slate-900">Active</p>
                        <p class="text-xs lg:text-sm font-medium text-slate-500">System Status</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-4 lg:p-6 shadow-lg shadow-violet-500/5 border border-violet-100 hover:border-violet-200 transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl lg:text-3xl">monitoring</span>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-black text-slate-900">99.9%</p>
                        <p class="text-xs lg:text-sm font-medium text-slate-500">Uptime</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-4 lg:p-6 shadow-lg shadow-violet-500/5 border border-violet-100 hover:border-violet-200 transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl lg:text-3xl">security</span>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-black text-slate-900">Secure</p>
                        <p class="text-xs lg:text-sm font-medium text-slate-500">Environment</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Recent Users (Left/Center Column) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-3xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
                    <div class="p-6 border-b border-violet-100 flex items-center justify-between">
                        <h3 class="font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">history</span>
                            Recent Registered Users
                        </h3>
                        <a href="{{ route('superadmin.users.index') }}" class="text-sm text-primary font-bold hover:underline flex items-center gap-1">
                            View All <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                    <div class="divide-y divide-violet-50">
                        @forelse($users->take(5) as $user)
                        <div class="p-4 lg:p-6 flex items-center justify-between hover:bg-violet-50/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center shadow-sm">
                                    <span class="text-sm font-bold text-slate-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="hidden lg:block text-xs text-slate-400 mr-4">Joined {{ $user->created_at->diffForHumans() }}</span>
                                <a href="{{ route('superadmin.users.edit', $user) }}" class="p-2 rounded-xl hover:bg-violet-100 text-slate-400 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-5xl text-slate-200 mb-2">group_off</span>
                            <p class="text-slate-500">No users found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions (Right Column) -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-6 shadow-lg shadow-violet-500/5 border border-violet-100">
                    <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">bolt</span>
                        Quick Operations
                    </h3>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('superadmin.users.create') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-violet-50 hover:bg-violet-100 transition-all group">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-primary shadow-sm group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined">person_add</span>
                            </div>
                            <span class="font-bold text-slate-700">Add New User</span>
                        </a>
                        <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-blue-50 hover:bg-blue-100 transition-all group">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined">manage_accounts</span>
                            </div>
                            <span class="font-bold text-slate-700">Manage Users</span>
                        </a>
                        <a href="{{ route('superadmin.settings') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-50 hover:bg-emerald-100 transition-all group">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined">settings</span>
                            </div>
                            <span class="font-bold text-slate-700">System Settings</span>
                        </a>
                        <form action="{{ route('superadmin.logout') }}" method="POST" class="contents">
                            @csrf
                            <button type="submit" class="flex items-center gap-4 p-4 rounded-2xl bg-red-50 hover:bg-red-100 transition-all group text-left">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-red-500 shadow-sm group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined">logout</span>
                                </div>
                                <span class="font-bold text-slate-700">Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- System Info Card -->
                <div class="bg-gradient-to-br from-violet-600 to-purple-700 rounded-3xl p-6 text-white shadow-xl shadow-violet-500/20">
                    <h3 class="text-lg font-bold mb-2">System Health</h3>
                    <p class="text-violet-100 text-sm mb-4">All systems are operational. No critical issues detected in the last 24 hours.</p>
                    <div class="flex items-center gap-2 text-xs font-bold bg-white/20 w-fit px-3 py-1.5 rounded-full">
                        <span class="size-2 bg-green-400 rounded-full animate-pulse"></span>
                        LIVE STATUS
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
