@extends('superadmin.layouts.app')

@section('title', 'Manage Users')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600 lg:hidden">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-900">User Management</h1>
                <p class="text-xs lg:text-sm text-slate-500">{{ $users->total() }} total users registered</p>
            </div>
        </div>
        <a href="{{ route('superadmin.users.create') }}" class="flex items-center justify-center lg:px-5 lg:py-2.5 size-10 lg:w-auto lg:h-auto rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 transition-all">
            <span class="material-symbols-outlined text-[22px] lg:mr-2">add</span>
            <span class="hidden lg:inline font-semibold">Add User</span>
        </a>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 lg:py-8">
        
        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-sm flex items-center gap-3 shadow-sm">
            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Users List/Table -->
        <div class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden">
            <!-- Mobile List (hidden on lg) -->
            <div class="divide-y divide-violet-50 lg:hidden">
                @forelse($users as $user)
                <div class="p-4 hover:bg-violet-50/50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center shrink-0">
                                <span class="text-sm font-bold text-slate-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
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
                    <span class="material-symbols-outlined text-4xl text-slate-300">group_off</span>
                    <p class="text-slate-500 mt-2">No users found</p>
                </div>
                @endforelse
            </div>

            <!-- Desktop Table (hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-violet-100">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Joined Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-violet-50">
                        @foreach($users as $user)
                        <tr class="hover:bg-violet-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                        <span class="text-xs font-bold text-slate-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                    <span class="font-bold text-slate-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superadmin.users.edit', $user) }}" class="p-2 rounded-xl bg-violet-50 hover:bg-violet-600 text-primary hover:text-white transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-red-50 hover:bg-red-600 text-red-500 hover:text-white transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</main>
@endsection
