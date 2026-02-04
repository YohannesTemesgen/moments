@extends('superadmin.layouts.app')

@section('title', 'Profile Settings')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600 lg:hidden">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-900">Profile Settings</h1>
                <p class="text-xs lg:text-sm text-slate-500">Manage your administrative account</p>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 overflow-y-auto no-scrollbar relative w-full pb-28 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6">
        
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile Card -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 p-8 text-center sticky top-0">
                    <div class="relative inline-block mb-6">
                        <div class="w-28 h-28 bg-gradient-to-br from-violet-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-violet-500/30 rotate-3 group hover:rotate-0 transition-transform duration-300">
                            <span class="material-symbols-outlined text-white text-5xl">shield_person</span>
                        </div>
                        <div class="absolute -bottom-2 -right-2 size-8 bg-emerald-500 border-4 border-white rounded-xl shadow-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-lg">verified</span>
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-1">{{ $superadmin->name }}</h2>
                    <p class="text-sm font-medium text-slate-500 mb-6">{{ $superadmin->email }}</p>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-violet-50 text-primary rounded-2xl text-xs font-bold uppercase tracking-widest border border-violet-100">
                        Moment creator Access
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-50 space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">Account Status</span>
                            <span class="text-emerald-500 font-bold">Active</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">Last Login</span>
                            <span class="text-slate-700 font-bold">Today</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Forms -->
            <div class="lg:col-span-2 space-y-8">
                @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-sm flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Update Profile Form -->
                <form method="POST" action="{{ route('superadmin.profile.update') }}" class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden">
                    @csrf
                    
                    <div class="p-6 border-b border-violet-100 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">person</span>
                            Personal Information
                        </h3>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        @if ($errors->has('name') || $errors->has('email') || $errors->has('phone'))
                        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-600 text-sm">
                            <ul class="list-disc list-inside space-y-1 font-medium">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">person</span>
                                    <input type="text" name="name" value="{{ old('name', $superadmin->name) }}" required
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                        placeholder="Enter your name">
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                                    <input type="email" name="email" value="{{ old('email', $superadmin->email) }}" required
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                        placeholder="email@example.com">
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Phone Number</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">phone</span>
                                <input type="tel" name="phone" value="{{ old('phone', $superadmin->phone) }}"
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                    placeholder="+1 234 567 8900">
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-slate-50/50 border-t border-violet-100 flex justify-end">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-bold rounded-2xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            Save Changes
                        </button>
                    </div>
                </form>

                <!-- Change Password Form -->
                <form method="POST" action="{{ route('superadmin.profile.password') }}" class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden">
                    @csrf
                    
                    <div class="p-6 border-b border-violet-100 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">lock</span>
                            Security & Password
                        </h3>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        @if ($errors->has('current_password') || $errors->has('password'))
                        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-600 text-sm">
                            <ul class="list-disc list-inside space-y-1 font-medium">
                                @foreach ($errors->get('current_password') as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                                @foreach ($errors->get('password') as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Current Password</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                                <input type="password" name="current_password" required
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                    placeholder="••••••••">
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">New Password</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">key</span>
                                    <input type="password" name="password" required
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                        placeholder="Min 8 characters">
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Confirm New Password</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock_reset</span>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all text-sm font-medium outline-none"
                                        placeholder="Repeat new password">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-slate-50/50 border-t border-violet-100 flex justify-end">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-bold rounded-2xl hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg shadow-violet-500/30 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">key</span>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
