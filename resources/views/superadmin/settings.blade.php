@extends('superadmin.layouts.app')

@section('title', 'Settings')

@section('content')
<!-- Sticky Header -->
<header class="shrink-0 z-20 bg-white/95 backdrop-blur-xl border-b border-violet-100 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center justify-center size-10 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors text-slate-600">
                <span class="material-symbols-outlined text-[22px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg font-bold tracking-tight text-slate-900">Settings</h1>
                <p class="text-xs text-slate-500">System configuration</p>
            </div>
        </div>
    </div>
</header>

<main class="flex-1 w-full overflow-y-auto no-scrollbar pb-32">
    <div class="max-w-lg mx-auto px-4 py-6 space-y-6">
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

        <!-- Profile Link Section -->
        <section class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
            <div class="p-4 flex items-center gap-4">
                <div class="relative shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-br from-violet-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg shadow-violet-500/30">
                        <span class="material-symbols-outlined text-white text-3xl">shield_person</span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-bold text-slate-900 truncate">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500 truncate">{{ $user->email }}</p>
                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-violet-100 text-violet-600 border border-violet-200">Super Admin</span>
                </div>
            </div>
            <div class="border-t border-violet-100">
                <a href="{{ route('superadmin.profile') }}" class="w-full flex items-center justify-between p-4 hover:bg-violet-50 transition-colors text-left">
                    <span class="text-sm font-medium text-slate-700">Manage Profile</span>
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                </a>
            </div>
        </section>

        <!-- General Section -->
        <section>
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 px-1">General</h3>
            <div class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden divide-y divide-violet-100">
                <a href="{{ route('superadmin.users.index') }}" class="w-full flex items-center gap-3 p-4 hover:bg-violet-50 transition-colors text-left group">
                    <div class="p-2 rounded-lg bg-blue-50 text-blue-600 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <div class="flex-1">
                        <span class="text-sm font-medium block text-slate-900">User Management</span>
                        <span class="text-xs text-slate-500">Manage access and roles</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                </a>
            </div>
        </section>

        <!-- Countdown Section -->
        <section>
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 px-1">Countdown Settings</h3>
            <div class="bg-white rounded-2xl shadow-lg shadow-violet-500/5 border border-violet-100 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 rounded-lg bg-red-50 text-red-600">
                            <span class="material-symbols-outlined">timer</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium block text-slate-900">Countdown Target Date</span>
                            <span class="text-xs text-slate-500">Set the target date for the landing page countdown</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Target Date & Time</label>
                            <input type="datetime-local" id="countdown-date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500 outline-none">
                        </div>
                        <button onclick="updateCountdownDate()" class="w-full bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-violet-500/30">
                            Update Countdown Date
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center pt-4 pb-8">
            <p class="text-xs text-slate-400">Version 1.0.0</p>
            <form method="POST" action="{{ route('superadmin.logout') }}" class="inline">
                @csrf
                <button type="submit" class="mt-4 text-red-500 hover:text-red-600 text-sm font-medium transition-colors px-4 py-2 rounded-lg hover:bg-red-50">
                    Log Out
                </button>
            </form>
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
