@extends('superadmin.layouts.app')

@section('title', 'Settings')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3 max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600 lg:hidden">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-900">System Settings</h1>
                <p class="text-xs lg:text-sm text-slate-500">Configure global system parameters</p>
            </div>
        </div>
    </div>
</header>

<main class="flex-1 w-full overflow-y-auto no-scrollbar pb-32 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6 space-y-8">
        @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-600 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            {{ $errors->first() }}
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Admin Profile Quick Access -->
            <div class="lg:col-span-1">
                <section class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden sticky top-0">
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-500/30 mx-auto mb-4">
                            <span class="material-symbols-outlined text-white text-4xl">shield_person</span>
                        </div>
                        <h2 class="text-xl font-black text-slate-900 truncate">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-500 truncate mb-4">{{ $user->email }}</p>
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black bg-violet-100 text-violet-600 border border-violet-200 uppercase tracking-widest">Moment creator</span>
                    </div>
                    <div class="border-t border-violet-50 bg-slate-50/50 p-4">
                        <a href="{{ route('superadmin.profile') }}" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-violet-100 hover:border-violet-300 hover:shadow-md transition-all group">
                            <span class="text-sm font-bold text-slate-700">Edit Profile</span>
                            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors">chevron_right</span>
                        </a>
                    </div>
                </section>
            </div>

            <!-- Configuration Sections -->
            <div class="lg:col-span-2 space-y-8">
                <!-- General Section -->
                <section>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4 px-2">General Management</h3>
                    <div class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden divide-y divide-violet-50">
                        <a href="{{ route('superadmin.users.index') }}" class="w-full flex items-center gap-4 p-6 hover:bg-violet-50/50 transition-all text-left group">
                            <div class="p-3 rounded-2xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform shadow-sm">
                                <span class="material-symbols-outlined">group</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-base font-bold block text-slate-900">User Management</span>
                                <span class="text-sm text-slate-500">Add, edit, or remove system users and administrators</span>
                            </div>
                            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors">chevron_right</span>
                        </a>
                    </div>
                </section>

                <!-- Countdown Section -->
                <section>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4 px-2">Feature Configuration</h3>
                    <div class="bg-white rounded-3xl shadow-xl shadow-violet-500/5 border border-violet-100 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="p-3 rounded-2xl bg-red-50 text-red-600 shadow-sm">
                                    <span class="material-symbols-outlined">timer</span>
                                </div>
                                <div>
                                    <span class="text-base font-bold block text-slate-900">Landing Page Countdown</span>
                                    <span class="text-sm text-slate-500">Set the target release date for the public landing page</span>
                                </div>
                            </div>
                            
                            <div class="space-y-6 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Target Date & Time</label>
                                    <div class="relative">
                                        <input type="datetime-local" id="countdown-date" 
                                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-4 text-sm font-medium focus:ring-4 focus:ring-violet-500/10 focus:border-violet-500 outline-none transition-all">
                                    </div>
                                </div>
                                <button onclick="updateCountdownDate()" class="w-full bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-violet-500/30 flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">update</span>
                                    Apply Target Date
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- App Version & Info -->
                <div class="text-center pt-8 border-t border-violet-50">
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-6">Version 1.0.0 Build 2024</p>
                    <form method="POST" action="{{ route('superadmin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-bold text-sm transition-all group">
                            <span class="material-symbols-outlined text-lg group-hover:rotate-12 transition-transform">logout</span>
                            Terminate Session
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Load current countdown date
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route("superadmin.settings.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ action: 'get_countdown_date' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.countdown_date) {
            // Convert to datetime-local format (YYYY-MM-DDTHH:MM)
            const date = new Date(data.countdown_date);
            const dateStr = date.toISOString().slice(0, 16);
            document.getElementById('countdown-date').value = dateStr;
        }
    })
    .catch(error => console.log('Error loading countdown date:', error));
});

function updateCountdownDate() {
    const dateInput = document.getElementById('countdown-date');
    const dateValue = dateInput.value;
    
    if (!dateValue) {
        alert('Please select a date and time');
        return;
    }
    
    // Convert datetime-local to full datetime string
    const date = new Date(dateValue);
    const dateTimeStr = date.toISOString().slice(0, 19).replace('T', ' ');
    
    fetch('{{ route("superadmin.settings.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: `key=countdown_target_date&value=${encodeURIComponent(dateTimeStr)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const successDiv = document.createElement('div');
            successDiv.className = 'bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm mb-4';
            successDiv.textContent = 'Countdown date updated successfully!';
            
            const main = document.querySelector('main > div');
            main.insertBefore(successDiv, main.firstChild);
            
            // Remove message after 3 seconds
            setTimeout(() => successDiv.remove(), 3000);
        }
    })
    .catch(error => {
        console.log('Error updating countdown date:', error);
        alert('Error updating countdown date');
    });
}
</script>
@endsection
