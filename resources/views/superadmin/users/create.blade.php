@extends('superadmin.layouts.app')

@section('title', 'Create User')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.users.index') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600 lg:hidden">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-900">Create New User</h1>
                <p class="text-xs lg:text-sm text-slate-500">Register a new administrator for the system</p>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28 lg:pb-8">
    <div class="max-w-4xl mx-auto px-4 lg:px-8 py-6 lg:py-10">
        
        <form method="POST" action="{{ route('superadmin.users.store') }}" class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden">
            @csrf
            
            <div class="p-6 border-b border-violet-100 bg-slate-50/50">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person_add</span>
                    Account Credentials
                </h3>
            </div>
            
            <div class="p-8 space-y-8">
                @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-600 text-sm">
                    <div class="flex items-center gap-2 mb-2 font-bold uppercase tracking-wider text-xs">
                        <span class="material-symbols-outlined text-sm">error</span>
                        Registration Errors
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
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                placeholder="Full name of user">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                placeholder="user@moments.com">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Secure Password</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                            <input type="password" name="password" required
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                placeholder="••••••••">
                        </div>
                        <p class="text-[10px] text-slate-400 font-bold ml-1">Must be at least 8 characters</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Confirm Password</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">verified_user</span>
                            <input type="password" name="password_confirmation" required
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-8 bg-slate-50/50 border-t border-violet-100 flex flex-col md:flex-row gap-4 items-center justify-between">
                <a href="{{ route('superadmin.users.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                    Discard and Return
                </a>
                <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-bold rounded-2xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">person_add</span>
                    Register Administrator
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
