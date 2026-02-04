@extends('superadmin.layouts.app')

@section('title', 'Edit User')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.users.index') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600 lg:hidden">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-900">Edit User Details</h1>
                <p class="text-xs lg:text-sm text-slate-500">Managing {{ $user->name }} ({{ $user->email }})</p>
            </div>
        </div>
        <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center justify-center size-10 lg:size-12 rounded-xl bg-red-50 hover:bg-red-600 text-red-500 hover:text-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[24px]">delete</span>
            </button>
        </form>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6">
        
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column: User Overview -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 p-8 text-center sticky top-0">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-violet-400 to-purple-500 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-violet-500/20 rotate-6 group hover:rotate-0 transition-transform duration-300">
                            <span class="text-3xl font-black text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div class="absolute -bottom-2 -right-2 size-8 bg-violet-100 border-4 border-white rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-sm">badge</span>
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-1">{{ $user->name }}</h2>
                    <p class="text-sm font-medium text-slate-500 mb-6">{{ $user->email }}</p>
                    
                    <div class="grid grid-cols-2 gap-4 text-left border-t border-slate-50 pt-8 mt-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Member Since</p>
                            <p class="text-sm font-bold text-slate-700">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Account Type</p>
                            <p class="text-sm font-bold text-slate-700">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Update Form -->
            <div class="lg:col-span-2 space-y-8">
                @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-sm flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('superadmin.users.update', $user) }}" class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 border-b border-violet-100 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">edit_square</span>
                            Account Information
                        </h3>
                    </div>
                    
                    <div class="p-8 space-y-8">
                        @if ($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-600 text-sm">
                            <div class="flex items-center gap-2 mb-2 font-bold uppercase tracking-wider text-xs">
                                <span class="material-symbols-outlined text-sm">error</span>
                                Update Errors
                            </div>
                            <ul class="list-disc list-inside space-y-1 font-medium">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">person</span>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                        placeholder="Enter name">
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                        placeholder="email@example.com">
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-8 border-t border-violet-50">
                            <div class="flex items-center gap-3 mb-6 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                                <span class="material-symbols-outlined text-amber-500">info</span>
                                <p class="text-xs font-bold text-amber-700 uppercase tracking-wider">Password Security</p>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">New Password</label>
                                    <div class="relative group">
                                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                                        <input type="password" name="password"
                                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                            placeholder="Leave empty to keep current">
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Confirm Password</label>
                                    <div class="relative group">
                                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">verified_user</span>
                                        <input type="password" name="password_confirmation"
                                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                            placeholder="Repeat new password">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8 bg-slate-50/50 border-t border-violet-100 flex flex-col md:flex-row gap-4 items-center justify-between">
                        <a href="{{ route('superadmin.users.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                            Discard Changes
                        </a>
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-bold rounded-2xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            Apply Updates
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
