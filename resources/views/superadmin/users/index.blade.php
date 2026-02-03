@extends('superadmin.layouts.app')

@section('title', 'Manage Users')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg font-bold tracking-tight text-slate-900">Users</h1>
                <p class="text-xs text-slate-500">{{ $users->total() }} total users</p>
            </div>
        </div>
        <a href="{{ route('superadmin.users.create') }}" class="flex items-center justify-center size-10 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 transition-all">
            <span class="material-symbols-outlined text-[22px]">add</span>
        </a>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28">
    <div class="max-w-lg mx-auto px-4 py-4">
        
        @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Users List -->
        <div class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
            <div class="divide-y divide-violet-50">
                @forelse($users as $user)
                <div class="p-4 hover:bg-violet-50/50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-sm font-bold text-slate-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                                <p class="text-xs text-slate-400 mt-1">Joined {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('superadmin.users.edit', $user) }}" class="p-2.5 rounded-xl bg-violet-50 hover:bg-violet-100 text-primary transition-colors">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl text-violet-300">group_off</span>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-1">No users yet</h3>
                    <p class="text-sm text-slate-500 mb-4">Get started by creating your first user</p>
                    <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white font-medium shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 transition-all">
                        <span class="material-symbols-outlined text-xl">person_add</span>
                        Add User
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-4 flex justify-center">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</main>
@endsection
