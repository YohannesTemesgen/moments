@php
    // Direct definition of nav items as requested
    $navItems = collect([
        (object)[
            'type' => 'link',
            'route' => 'landing.original',
            'icon' => 'home',
            'label' => 'Home',
            'attributes' => null
        ],
        (object)[
            'type' => 'link',
            'route' => 'genacountdown',
            'icon' => 'church',
            'label' => 'Genna',
            'attributes' => null
        ],
        (object)[
            'type' => 'link',
            'route' => 'manual_add', // Special marker for dynamic Add button
            'icon' => 'add_circle',
            'label' => 'Add',
            'attributes' => null
        ],
        (object)[
            'type' => 'link',
            'route' => 'admin.calendar',
            'icon' => 'event',
            'label' => 'Event',
            'attributes' => null
        ],
        (object)[
            'type' => 'button',
            'route' => null,
            'icon' => 'settings',
            'label' => 'Settings',
            'attributes' => ['onclick' => 'toggleSettings()']
        ]
    ]);
    
    // Check if current page should hide mobile nav
    $currentRoute = request()->path();
    // Enable navbar on genacountdown and landing pages
    $shouldHideNav = false; 
@endphp

<!-- Mobile Bottom Navigation -->
@if(!$shouldHideNav)
<nav id="mobileNav" class="fixed bottom-0 left-0 right-0 z-50 bg-white/20 dark:bg-black/20 backdrop-blur-lg border-t border-white/20 dark:border-white/10 md:hidden transition-transform duration-300 ease-in-out">
    <div class="flex items-center justify-around px-4 py-1 safe-area-pb">
        @foreach($navItems as $item)
            @if($item->route === 'manual_add')
                <a href="{{ auth()->check() ? route('admin.timeline') : route('login') }}" class="flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-primary hover:bg-primary/5">
                    <span class="material-symbols-outlined text-lg mb-0.5">{{ $item->icon }}</span>
                    <span class="text-xs font-medium">{{ $item->label }}</span>
                </a>
            @elseif($item->type === 'link')
                <a href="{{ $item->route ? route($item->route) : '#' }}" class="flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-200 {{ $item->route && request()->routeIs($item->route) ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400 hover:text-primary hover:bg-primary/5' }}">
                    <span class="material-symbols-outlined text-lg mb-0.5" style="font-variation-settings: 'FILL' {{ $item->route && request()->routeIs($item->route) ? '1' : '0' }};">{{ $item->icon }}</span>
                    <span class="text-xs font-medium">{{ $item->label }}</span>
                </a>
            @elseif($item->type === 'button')
                <button 
                    @if($item->attributes && isset($item->attributes['onclick']))
                        onclick="{{ $item->attributes['onclick'] }}"
                    @endif
                    class="flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-primary hover:bg-primary/5">
                    <span class="material-symbols-outlined text-lg mb-0.5">{{ $item->icon }}</span>
                    <span class="text-xs font-medium">{{ $item->label }}</span>
                </button>
            @elseif($item->type === 'divider')
                <div class="w-px h-8 bg-gray-300 dark:bg-gray-600"></div>
            @endif
        @endforeach
    </div>
</nav>
@endif

<!-- Settings Modal -->
@if(!$shouldHideNav)
<div id="settingsModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="toggleSettings()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white dark:bg-gray-900 rounded-t-2xl p-6 transform translate-y-full transition-transform duration-300" id="settingsPanel">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Settings</h3>
            <button onclick="toggleSettings()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="material-symbols-outlined text-gray-500">close</span>
            </button>
        </div>
        
        <div class="space-y-4">
            <!-- Dark Mode Toggle -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">dark_mode</span>
                    <span class="text-gray-900 dark:text-white">Dark Mode</span>
                </div>
                <button onclick="toggleDarkMode()" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 dark:bg-primary transition-colors">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform dark:translate-x-6 translate-x-1"></span>
                </button>
            </div>
            
            <!-- Notifications -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">notifications</span>
                    <span class="text-gray-900 dark:text-white">Notifications</span>
                </div>
                <button onclick="toggleNotifications()" class="relative inline-flex h-6 w-11 items-center rounded-full bg-primary transition-colors">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6"></span>
                </button>
            </div>
            
            <!-- Language -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">language</span>
                    <span class="text-gray-900 dark:text-white">Language</span>
                </div>
                <select class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg px-3 py-1 text-sm border-0">
                    <option value="en">English</option>
                    <option value="am">አማርኛ</option>
                </select>
            </div>
        </div>
    </div>
</div>
@endif

@if(!$shouldHideNav)
<script>
function toggleSettings() {
    const modal = document.getElementById('settingsModal');
    const panel = document.getElementById('settingsPanel');
    
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            panel.style.transform = 'translateY(0)';
        }, 10);
    } else {
        panel.style.transform = 'translateY(100%)';
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
}

function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
}

function toggleNotifications() {
    // Add notification toggle logic here
    console.log('Notifications toggled');
}

// Initialize dark mode from localStorage
if (localStorage.getItem('darkMode') === 'true') {
    document.documentElement.classList.add('dark');
}
</script>
@endif

@if(!$shouldHideNav)
<style>
.safe-area-pb {
    padding-bottom: env(safe-area-inset-bottom);
}
</style>
@endif
