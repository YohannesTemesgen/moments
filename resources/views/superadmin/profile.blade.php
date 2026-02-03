@extends('superadmin.layouts.app')

@section('title', 'Profile Settings')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg font-bold tracking-tight text-slate-900">Profile</h1>
                <p class="text-xs text-slate-500">Manage your account</p>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28">
    <div class="max-w-lg mx-auto px-4 py-6 space-y-6">
        
        <!-- Profile Avatar Card -->
        <div class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 p-6 text-center">
            <div class="w-24 h-24 bg-gradient-to-br from-violet-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl shadow-violet-500/30">
                <span class="material-symbols-outlined text-white text-4xl">shield_person</span>
            </div>
            <h2 class="text-xl font-bold text-slate-900">{{ $superadmin->name }}</h2>
            <p class="text-sm text-slate-500">{{ $superadmin->email }}</p>
            <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 bg-violet-100 text-primary rounded-full text-xs font-medium">
                <span class="material-symbols-outlined text-sm">verified</span>
                Super Admin
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Update Profile Form -->
        <form method="POST" action="{{ route('superadmin.profile.update') }}" class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
            @csrf
            
            <div class="p-4 border-b border-violet-100">
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                    Profile Information
                </h3>
            </div>
            
            <div class="p-4 space-y-5">
                @if ($errors->has('name') || $errors->has('email') || $errors->has('phone'))
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        @foreach ($errors->get('name') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        @foreach ($errors->get('email') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        @foreach ($errors->get('phone') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Full Name</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                        <input type="text" name="name" value="{{ old('name', $superadmin->name) }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input type="email" name="email" value="{{ old('email', $superadmin->email) }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Phone Number</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">phone</span>
                        <input type="tel" name="phone" value="{{ old('phone', $superadmin->phone) }}"
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm"
                            placeholder="+1 234 567 8900">
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-violet-50/50 border-t border-violet-100">
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold rounded-xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 hover:shadow-violet-500/40 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Update Profile
                </button>
            </div>
        </form>

        <!-- Change Password Form -->
        <form method="POST" action="{{ route('superadmin.profile.password') }}" class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
            @csrf
            
            <div class="p-4 border-b border-violet-100">
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">lock</span>
                    Change Password
                </h3>
            </div>
            
            <div class="p-4 space-y-5">
                @if ($errors->has('current_password') || $errors->has('password'))
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        @foreach ($errors->get('current_password') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        @foreach ($errors->get('password') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Current Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input type="password" name="current_password" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm"
                            placeholder="••••••••">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input type="password" name="password" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all text-sm"
                            placeholder="••••••••">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Minimum 8 characters</p>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Confirm New Password</label>
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
                    <span class="material-symbols-outlined text-xl">key</span>
                    Change Password
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
