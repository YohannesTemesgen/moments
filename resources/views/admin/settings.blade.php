@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<header class="sticky top-0 left-0 right-0 z-30 pt-safe transition-colors duration-300 bg-white/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="pb-3 pt-3 px-4 lg:px-8 flex items-center justify-between">
        <div>
            <h1 class="text-xl lg:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Settings</h1>
            <p class="hidden lg:block text-sm text-slate-500">Manage your profile and application preferences</p>
        </div>
        <div class="lg:hidden relative group cursor-pointer">
            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-9 ring-2 ring-white dark:ring-slate-700 shadow-sm" style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=197fe6&color=fff");'></div>
        </div>
    </div>
</header>

<main class="flex-1 w-full overflow-y-auto no-scrollbar pb-32 lg:pb-8">
    <div class="px-4 lg:px-8 py-6 lg:py-10 max-w-6xl mx-auto space-y-6 lg:space-y-10">
        @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            {{ $errors->first() }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-10">
            <!-- Sidebar / Profile Card -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Section -->
                <section class="bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden group">
                    <div class="p-6 text-center">
                        <div class="relative inline-block mb-4">
                            <div class="size-24 rounded-full bg-cover bg-center ring-4 ring-primary/10 group-hover:ring-primary/20 transition-all shadow-xl" style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=197fe6&color=fff&size=128");'></div>
                            <button onclick="document.getElementById('profile-modal').classList.remove('hidden')" class="absolute bottom-0 right-0 p-2 bg-primary text-white rounded-full border-4 border-white dark:border-surface-dark shadow-lg hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white truncate mb-1">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 truncate mb-4">{{ $user->email }}</p>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">
                            <span class="size-1.5 rounded-full bg-primary"></span>
                            Administrator
                        </span>
                    </div>
                    <div class="border-t border-slate-100 dark:border-slate-800 p-2">
                        <button onclick="document.getElementById('profile-modal').classList.remove('hidden')" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-all text-left group/btn">
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-300 group-hover/btn:text-primary">Edit Profile</span>
                            <span class="material-symbols-outlined text-slate-400 group-hover/btn:translate-x-1 transition-transform">chevron_right</span>
                        </button>
                    </div>
                </section>

                <div class="hidden lg:block p-6 bg-slate-50 dark:bg-surface-dark/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
                    <h4 class="text-sm font-bold mb-2">Need help?</h4>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">Check our help center or contact support if you have any issues with your account settings.</p>
                    <a href="#" class="text-xs font-bold text-primary hover:underline">Go to Help Center</a>
                </div>
            </div>

            <!-- Main Settings Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- General Section -->
                <section>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4 px-1">General Account</h3>
                    <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                        <button class="w-full flex items-center gap-4 p-5 lg:p-6 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-all text-left group">
                            <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined">notifications</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-base font-bold block text-slate-900 dark:text-white">Notification Settings</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Configure how you receive push and email alerts</span>
                            </div>
                            <span class="material-symbols-outlined text-slate-400 group-hover:translate-x-1 transition-transform">chevron_right</span>
                        </button>
                        
                        <button onclick="document.getElementById('password-modal').classList.remove('hidden')" class="w-full flex items-center gap-4 p-5 lg:p-6 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-all text-left group">
                            <div class="p-3 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined">shield</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-base font-bold block text-slate-900 dark:text-white">Privacy & Security</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Manage your password and security preferences</span>
                            </div>
                            <span class="material-symbols-outlined text-slate-400 group-hover:translate-x-1 transition-transform">chevron_right</span>
                        </button>
                    </div>
                </section>

                <!-- Preferences Section -->
                <section>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4 px-1">Preferences</h3>
                    <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                        <div class="p-5 lg:p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                    <span class="material-symbols-outlined">dark_mode</span>
                                </div>
                                <div>
                                    <span class="text-base font-bold text-slate-900 dark:text-white block">Dark Mode</span>
                                    <span class="text-xs text-slate-500">Enable high-contrast dark theme</span>
                                </div>
                            </div>
                            <div class="relative inline-block w-14 h-7 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" id="toggle-dark" class="peer absolute block w-7 h-7 rounded-full bg-white border-4 border-slate-200 dark:border-slate-700 appearance-none cursor-pointer transition-all duration-300 checked:translate-x-full checked:border-primary z-10" checked>
                                <label for="toggle-dark" class="block overflow-hidden h-7 rounded-full bg-slate-200 dark:bg-slate-700 cursor-pointer transition-colors duration-300 peer-checked:bg-primary"></label>
                            </div>
                        </div>
                        
                        <div class="p-5 lg:p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                    <span class="material-symbols-outlined">location_on</span>
                                </div>
                                <div>
                                    <span class="text-base font-bold text-slate-900 dark:text-white block">Location Services</span>
                                    <span class="text-xs text-slate-500">Allow app to access your GPS data</span>
                                </div>
                            </div>
                            <div class="relative inline-block w-14 h-7 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" id="toggle-location" class="peer absolute block w-7 h-7 rounded-full bg-white border-4 border-slate-200 dark:border-slate-700 appearance-none cursor-pointer transition-all duration-300 checked:translate-x-full checked:border-primary z-10" checked>
                                <label for="toggle-location" class="block overflow-hidden h-7 rounded-full bg-slate-200 dark:bg-slate-700 cursor-pointer transition-colors duration-300 peer-checked:bg-primary"></label>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Support Section -->
                <section>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4 px-1">Support & Legal</h3>
                    <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                        <button class="w-full flex items-center gap-4 p-5 lg:p-6 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-all text-left group">
                            <span class="text-base font-bold flex-1 text-slate-900 dark:text-white">Help Center</span>
                            <span class="material-symbols-outlined text-slate-400">open_in_new</span>
                        </button>
                        <button class="w-full flex items-center gap-4 p-5 lg:p-6 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-all text-left group">
                            <span class="text-base font-bold flex-1 text-slate-900 dark:text-white">Terms of Service</span>
                            <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                        </button>
                        <button class="w-full flex items-center gap-4 p-5 lg:p-6 hover:bg-slate-50 dark:hover:bg-surface-dark-highlight transition-all text-left group">
                            <span class="text-base font-bold flex-1 text-slate-900 dark:text-white">Privacy Policy</span>
                            <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                        </button>
                    </div>
                </section>

                @if(auth()->user()->isFullAdmin())
                <!-- Team Management Section -->
                <section>
                    <div class="flex items-center justify-between mb-4 px-1">
                        <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Team & Collaboration</h3>
                        <button onclick="document.getElementById('add-user-modal').classList.remove('hidden')" class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">person_add</span>
                            Add Member
                        </button>
                    </div>
                    <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach($users as $teamMember)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                        <td class="p-4 lg:p-6">
                                            <div class="flex items-center gap-3">
                                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                                                    {{ substr($teamMember->name, 0, 1) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $teamMember->name }}</div>
                                                    <div class="text-[10px] text-slate-500 truncate">{{ $teamMember->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 lg:p-6">
                                            <form action="{{ route('admin.users.role', $teamMember) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" onchange="this.form.submit()" class="bg-slate-100 dark:bg-slate-800 border-none rounded-lg text-[10px] font-bold px-2 py-1 focus:ring-2 focus:ring-primary/50 cursor-pointer">
                                                    <option value="view-only" {{ $teamMember->role === 'view-only' ? 'selected' : '' }}>View Only</option>
                                                    <option value="create" {{ $teamMember->role === 'create' ? 'selected' : '' }}>Create Only</option>
                                                    <option value="full" {{ $teamMember->role === 'full' ? 'selected' : '' }}>Full Access</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="p-4 lg:p-6 text-right">
                                            @if($teamMember->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $teamMember) }}" method="POST" class="inline" onsubmit="return confirm('Remove this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($users->hasPages())
                        <div class="p-3 border-t border-slate-100 dark:border-slate-800">
                            {{ $users->links() }}
                        </div>
                        @endif
                    </div>
                </section>

                <!-- Activity Logs Section -->
                <section>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4 px-1">Recent Activity</h3>
                    <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($auditLogs as $log)
                        <div class="p-4 flex items-start gap-3">
                            <div class="p-1.5 rounded-lg {{ $log->action === 'user_created' ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : ($log->action === 'permission_modified' ? 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400' : 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400') }}">
                                <span class="material-symbols-outlined text-[16px]">
                                    @if($log->action === 'user_created') person_add @elseif($log->action === 'permission_modified') rule @else delete_forever @endif
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-900 dark:text-white leading-tight">
                                    <span class="font-bold">{{ $log->user ? $log->user->name : 'System' }}</span>
                                    {{ $log->description }}
                                </p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center text-slate-500 text-xs italic">No recent activity</div>
                        @endforelse
                    </div>
                </section>
                @endif

                <div class="text-center pt-8 pb-8 lg:pt-0">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Version 1.0.0</p>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="lg:hidden mt-6 text-red-500 hover:text-red-600 text-sm font-bold transition-all px-6 py-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/10 border border-red-100 dark:border-red-900/30">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
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



@if(auth()->user()->isFullAdmin())
<!-- Add User Modal -->
<div id="add-user-modal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-surface-dark rounded-2xl w-full max-w-md shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
            <div class="flex items-center gap-3">
                <div class="size-8 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                </div>
                <h3 class="font-bold text-lg">Add New Team Member</h3>
            </div>
            <button onclick="document.getElementById('add-user-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                <input type="text" name="name" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all" placeholder="Enter user's name">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                <input type="email" name="email" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all" placeholder="user@example.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Temporary Password</label>
                <input type="password" name="password" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition-all" placeholder="Minimum 8 characters">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Permissions</label>
                <div class="grid grid-cols-1 gap-2">
                    <label class="relative flex items-center p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all group">
                        <input type="radio" name="role" value="view-only" checked class="peer sr-only">
                        <div class="size-4 rounded-full border-2 border-slate-300 dark:border-slate-600 peer-checked:border-primary peer-checked:border-[5px] transition-all"></div>
                        <div class="ml-3">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">View Only</div>
                        </div>
                    </label>
                    <label class="relative flex items-center p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all group">
                        <input type="radio" name="role" value="create" class="peer sr-only">
                        <div class="size-4 rounded-full border-2 border-slate-300 dark:border-slate-600 peer-checked:border-primary peer-checked:border-[5px] transition-all"></div>
                        <div class="ml-3">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">Create Permissions</div>
                        </div>
                    </label>
                    <label class="relative flex items-center p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all group">
                        <input type="radio" name="role" value="full" class="peer sr-only">
                        <div class="size-4 rounded-full border-2 border-slate-300 dark:border-slate-600 peer-checked:border-primary peer-checked:border-[5px] transition-all"></div>
                        <div class="ml-3">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">Full Access</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="button" onclick="document.getElementById('add-user-modal').classList.add('hidden')" class="flex-1 px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-sm">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-3 bg-primary text-white font-bold rounded-xl hover:bg-blue-600 transition-all shadow-lg shadow-primary/20 text-sm">Create</button>
            </div>
        </form>
    </div>
</div>
@endif

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const darkModeToggle = document.getElementById('toggle-dark');
        const htmlElement = document.documentElement;

        // Set initial state from localStorage or current class
        const isDark = localStorage.getItem('theme') === 'dark' || 
                      (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        if (isDark) {
            htmlElement.classList.add('dark');
            htmlElement.classList.remove('light');
            if (darkModeToggle) darkModeToggle.checked = true;
        } else {
            htmlElement.classList.remove('dark');
            htmlElement.classList.add('light');
            if (darkModeToggle) darkModeToggle.checked = false;
        }

        if (darkModeToggle) {
            darkModeToggle.addEventListener('change', () => {
                if (darkModeToggle.checked) {
                    htmlElement.classList.add('dark');
                    htmlElement.classList.remove('light');
                    localStorage.setItem('theme', 'dark');
                } else {
                    htmlElement.classList.remove('dark');
                    htmlElement.classList.add('light');
                    localStorage.setItem('theme', 'light');
                }
            });
        }
    });
</script>
@endsection

@endsection
