@extends('superadmin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <div class="relative">
                <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-full size-10 flex items-center justify-center shadow-lg shadow-violet-500/30">
                    <span class="material-symbols-outlined text-white text-xl">shield_person</span>
                </div>
                <div class="absolute bottom-0 right-0 size-3 bg-green-500 rounded-full border-2 border-white ring-2 ring-green-500/20"></div>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight text-slate-900">Dashboard</h1>
                <p class="text-xs text-slate-500">Welcome, {{ Auth::guard('superadmin')->user()->name }}</p>
            </div>
        </div>
        <a href="{{ route('superadmin.users.create') }}" class="flex items-center justify-center size-10 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 transition-all">
            <span class="material-symbols-outlined text-[22px]">person_add</span>
        </a>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28">
    <div class="max-w-lg mx-auto px-4 py-6 space-y-6">
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl p-4 shadow-lg shadow-violet-500/5 border border-violet-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-violet-500/30">
                        <span class="material-symbols-outlined text-white text-2xl">group</span>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</p>
                        <p class="text-xs text-slate-500">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-lg shadow-violet-500/5 border border-violet-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <span class="material-symbols-outlined text-white text-2xl">verified_user</span>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">Active</p>
                        <p class="text-xs text-slate-500">System Status</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-4 shadow-lg shadow-violet-500/5 border border-violet-100">
            <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-lg">bolt</span>
                Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('superadmin.users.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors">
                    <span class="material-symbols-outlined text-primary">person_add</span>
                    <span class="text-sm font-medium text-slate-700">Add User</span>
                </a>
                <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors">
                    <span class="material-symbols-outlined text-primary">manage_accounts</span>
                    <span class="text-sm font-medium text-slate-700">Manage Users</span>
                </a>
                <a href="{{ route('superadmin.settings') }}" class="flex items-center gap-3 p-3 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors">
                    <span class="material-symbols-outlined text-primary">settings</span>
                    <span class="text-sm font-medium text-slate-700">Settings</span>
                </a>
                <form action="{{ route('superadmin.logout') }}" method="POST" class="contents">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 p-3 rounded-xl bg-red-50 hover:bg-red-100 transition-colors text-left">
                        <span class="material-symbols-outlined text-red-500">logout</span>
                        <span class="text-sm font-medium text-slate-700">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
            <div class="p-4 border-b border-violet-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">history</span>
                    Recent Users
                </h3>
                <a href="{{ route('superadmin.users.index') }}" class="text-xs text-primary font-medium hover:underline">View All</a>
            </div>
            <div class="divide-y divide-violet-50">
                @forelse($users->take(5) as $user)
                <div class="p-4 flex items-center justify-between hover:bg-violet-50/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold text-slate-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('superadmin.users.edit', $user) }}" class="p-2 rounded-lg hover:bg-violet-100 text-slate-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl">edit</span>
                    </a>
                </div>
                @empty
                <div class="p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">group_off</span>
                    <p class="text-sm text-slate-500">No users found</p>
                    <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-1 mt-3 text-sm text-primary font-medium hover:underline">
                        <span class="material-symbols-outlined text-lg">add</span>
                        Add your first user
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection
