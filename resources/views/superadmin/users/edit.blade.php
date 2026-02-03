@extends('superadmin.layouts.app')

@section('title', 'Edit User')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.users.index') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg font-bold tracking-tight text-slate-900">Edit User</h1>
                <p class="text-xs text-slate-500">{{ $user->email }}</p>
            </div>
        </div>
        <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center justify-center size-10 rounded-xl bg-red-50 hover:bg-red-100 text-red-500 transition-colors">
                <span class="material-symbols-outlined text-[22px]">delete</span>
            </button>
        </form>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28">
    <div class="max-w-lg mx-auto px-4 py-6">
        
        <!-- User Avatar Card -->
        <div class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 p-6 mb-6 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-violet-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-violet-500/30">
                <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
            </div>
            <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>
            <p class="text-sm text-slate-500">{{ $user->email }}</p>
            <p class="text-xs text-slate-400 mt-2">Member since {{ $user->created_at->format('M d, Y') }}</p>
        </div>

        <form method="POST" action="{{ route('superadmin.users.update', $user) }}" class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="p-4 border-b border-violet-100">
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">edit</span>
                    Update Information
                </h3>
            </div>
            
            <div class="p-4 space-y-5">
                @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-red-500">error</span>
                        <span class="font-medium">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Full Name</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm @error('name') border-red-300 @enderror"
                            placeholder="John Doe">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm @error('email') border-red-300 @enderror"
                            placeholder="user@example.com">
                    </div>
                </div>
                
                <div class="pt-4 border-t border-violet-100">
                    <p class="text-xs text-slate-500 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-lg">info</span>
                        Leave password fields empty to keep current password
                    </p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                                <input type="password" name="password"
                                    class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm @error('password') border-red-300 @enderror"
                                    placeholder="••••••••">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Confirm New Password</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                                <input type="password" name="password_confirmation"
                                    class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-violet-50/50 border-t border-violet-100">
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold rounded-xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Update User
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
