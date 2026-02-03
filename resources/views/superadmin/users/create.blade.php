@extends('superadmin.layouts.app')

@section('title', 'Create User')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.users.index') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg font-bold tracking-tight text-slate-900">Create User</h1>
                <p class="text-xs text-slate-500">Add a new admin user</p>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28">
    <div class="max-w-lg mx-auto px-4 py-6">
        
        <form method="POST" action="{{ route('superadmin.users.store') }}" class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
            @csrf
            
            <div class="p-4 border-b border-violet-100">
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">person_add</span>
                    User Information
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

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Full Name</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm @error('name') border-red-300 @enderror"
                            placeholder="John Doe">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm @error('email') border-red-300 @enderror"
                            placeholder="user@example.com">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input type="password" name="password" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm @error('password') border-red-300 @enderror"
                            placeholder="••••••••">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Minimum 8 characters</p>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Confirm Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input type="password" name="password_confirmation" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-violet-50/50 border-t border-violet-100">
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold rounded-xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">person_add</span>
                    Create User
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
