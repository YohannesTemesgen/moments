@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<header class="sticky top-0 left-0 right-0 z-30 pt-safe transition-colors duration-300 bg-white/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="pb-3 pt-3 px-4 flex items-center justify-between">
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Settings</h1>
        <div class="relative group cursor-pointer">
            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-9 ring-2 ring-white dark:ring-slate-700 shadow-sm" style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=197fe6&color=fff");'></div>
        </div>
    </div>
</header>

<main class="flex-1 w-full overflow-y-auto no-scrollbar pb-32">
    <div class="px-4 py-6 space-y-6">
        @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Profile Section -->
        <section class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-4 flex items-center gap-4">
                <div class="relative shrink-0">
                    <div class="size-16 rounded-full bg-cover bg-center" style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=197fe6&color=fff&size=128");'></div>
                    <button class="absolute bottom-0 right-0 p-1 bg-primary text-white rounded-full border-2 border-white dark:border-surface-dark shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">edit</span>
                    </button>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white truncate">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-primary/10 text-primary border border-primary/20">Admin</span>
                </div>
            </div>
            <div class="border-t border-slate-100 dark:border-slate-800">
                <button onclick="document.getElementById('profile-modal').classList.remove('hidden')" class="w-full flex items-center justify-between p-4 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-colors text-left">
                    <span class="text-sm font-medium">Manage Profile</span>
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                </button>
            </div>
        </section>

        <!-- General Section -->
        <section>
            <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 px-1">General</h3>
            <div class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">

                <button class="w-full flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-colors text-left group">
                    <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined">notifications</span>
                    </div>
                    <div class="flex-1">
                        <span class="text-sm font-medium block text-slate-900 dark:text-white">Notification Settings</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Push & email alerts</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                </button>
                <button onclick="document.getElementById('password-modal').classList.remove('hidden')" class="w-full flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-colors text-left group">
                    <div class="p-2 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined">shield</span>
                    </div>
                    <div class="flex-1">
                        <span class="text-sm font-medium block text-slate-900 dark:text-white">Privacy & Security</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Password, Data</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                </button>
            </div>
        </section>



        <!-- Preferences Section -->
        <section>
            <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 px-1">Preferences</h3>
            <div class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                            <span class="material-symbols-outlined">dark_mode</span>
                        </div>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">Dark Mode</span>
                    </div>
                    <div class="relative inline-block w-12 mr-2 align-middle select-none">
                        <input checked type="checkbox" id="toggle-dark" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-slate-200 dark:border-slate-700 appearance-none cursor-pointer transition-all duration-300 translate-x-full">
                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-primary cursor-pointer transition-colors duration-300" for="toggle-dark"></label>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">Location Services</span>
                    </div>
                    <div class="relative inline-block w-12 mr-2 align-middle select-none">
                        <input checked type="checkbox" id="toggle-location" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-slate-200 dark:border-slate-700 appearance-none cursor-pointer transition-all duration-300 translate-x-full">
                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-primary cursor-pointer transition-colors duration-300" for="toggle-location"></label>
                    </div>
                </div>
            </div>
        </section>

        <!-- Support Section -->
        <section>
            <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 px-1">Support</h3>
            <div class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                <button class="w-full flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-colors text-left">
                    <span class="text-sm font-medium flex-1 text-slate-900 dark:text-white">Help Center</span>
                    <span class="material-symbols-outlined text-slate-400">open_in_new</span>
                </button>
                <button class="w-full flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-colors text-left">
                    <span class="text-sm font-medium flex-1 text-slate-900 dark:text-white">Terms of Service</span>
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                </button>
                <button class="w-full flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-colors text-left">
                    <span class="text-sm font-medium flex-1 text-slate-900 dark:text-white">Privacy Policy</span>
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                </button>
            </div>
        </section>

        <div class="text-center pt-4 pb-8">
            <p class="text-xs text-slate-400">Version 1.0.0</p>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="mt-4 text-red-500 hover:text-red-600 text-sm font-medium transition-colors px-4 py-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/10">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</main>

<!-- Profile Modal -->
<div id="profile-modal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-surface-dark rounded-2xl w-full max-w-md shadow-xl">
        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <h3 class="font-bold text-lg">Edit Profile</h3>
            <button onclick="document.getElementById('profile-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.settings.profile') }}" class="p-4 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none">
            </div>

            <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                <h4 class="text-sm font-semibold mb-3">Change Password (Optional)</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Current Password</label>
                        <input type="password" name="current_password" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none" placeholder="Leave blank to keep current password">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
                        <input type="password" name="password" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition-colors">
                Save Changes
            </button>
        </form>
    </div>
</div>

<!-- Password Modal -->
<div id="password-modal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-surface-dark rounded-2xl w-full max-w-md shadow-xl">
        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <h3 class="font-bold text-lg">Change Password</h3>
            <button onclick="document.getElementById('password-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.settings.password') }}" class="p-4 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Current Password</label>
                <input type="password" name="current_password" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
                <input type="password" name="password" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full bg-background-light dark:bg-background-dark border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none">
            </div>
            <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition-colors">
                Update Password
            </button>
        </form>
    </div>
</div>



@endsection
