@extends('layouts.admin')

@section('title', 'Navigation Management')

@section('content')
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Header -->
    <header class="bg-white dark:bg-surface-dark border-b border-slate-200 dark:border-slate-800 px-6 lg:px-8 py-4 lg:py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white">Navigation Management</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Control the order and visibility of bottom navigation items</p>
            </div>
            <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2 lg:px-6 lg:py-3 bg-primary text-white rounded-lg lg:rounded-xl hover:bg-blue-600 transition-all shadow-lg shadow-primary/20 font-bold">
                <span class="material-symbols-outlined text-lg">add</span>
                Add Item
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-hidden p-6 lg:p-8">
        <div class="h-full flex flex-col lg:flex-row gap-8 max-w-[1600px] mx-auto">
            
            <!-- Navigation Items List (Left Side on Desktop) -->
            <div class="flex-1 flex flex-col min-w-0">
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col h-full overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Navigation Items</h2>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Drag to reorder</span>
                    </div>
                    <div id="nav-items-container" class="flex-1 overflow-y-auto p-4 lg:p-6 space-y-3 no-scrollbar">
                        @foreach($navItems as $item)
                        <div class="nav-item flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700/50 hover:border-primary/50 transition-all group" data-id="{{ $item->id }}">
                            <!-- Drag Handle -->
                            <div class="drag-handle cursor-move text-slate-400 hover:text-primary transition-colors">
                                <span class="material-symbols-outlined">drag_indicator</span>
                            </div>

                            <!-- Icon -->
                            <div class="flex-shrink-0 size-12 rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center text-primary shadow-sm">
                                <span class="material-symbols-outlined text-2xl">{{ $item->icon }}</span>
                            </div>

                            <!-- Item Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <h3 class="font-bold text-slate-900 dark:text-white truncate">{{ $item->label }}</h3>
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md 
                                        {{ $item->type === 'link' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 
                                           ($item->type === 'button' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 
                                            'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400') }}">
                                        {{ $item->type }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                    {{ $item->route ? "Route: {$item->route}" : ($item->attributes ? json_encode($item->attributes) : 'No route') }}
                                </p>
                            </div>

                            <!-- Visibility Toggle -->
                            <div class="flex items-center gap-3 pr-4 border-r border-slate-200 dark:border-slate-700">
                                <span class="hidden sm:block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Visible</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer visibility-toggle" 
                                           data-id="{{ $item->id }}" 
                                           {{ $item->is_visible ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-primary"></div>
                                </label>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-1">
                                <button onclick="editItem({{ $item->id }})" class="p-2 rounded-lg text-slate-400 hover:text-primary hover:bg-primary/10 transition-all">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button onclick="deleteItem({{ $item->id }})" class="p-2 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-500/10 transition-all">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Navigation Preview (Right Side on Desktop) -->
            <div class="lg:w-[400px] shrink-0">
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-8 sticky top-0">
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Live Preview</h2>
                        <p class="text-sm text-slate-500">How it looks on mobile devices</p>
                    </div>
                    
                    <!-- Mobile Mockup -->
                    <div class="relative mx-auto w-64 h-[450px] bg-slate-900 rounded-[3rem] border-8 border-slate-800 shadow-2xl overflow-hidden">
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-6 bg-slate-800 rounded-b-2xl z-20"></div>
                        <div class="h-full bg-slate-100 dark:bg-slate-900 flex flex-col">
                            <div class="flex-1"></div>
                            <!-- Preview Bottom Nav -->
                            <div id="nav-preview" class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 h-16 flex items-center justify-around px-2">
                                <!-- Preview items populated by JS -->
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="p-4 bg-primary/5 rounded-xl border border-primary/10">
                            <h4 class="text-sm font-bold text-primary mb-1 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">info</span>
                                Pro Tip
                            </h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Use high-contrast icons for better visibility. Most users prefer 4-5 items in the bottom navigation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add/Edit Modal -->
<div id="itemModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="absolute inset-x-4 top-1/2 -translate-y-1/2 max-w-md mx-auto bg-white dark:bg-surface-dark rounded-xl shadow-xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modal-title" class="text-lg font-semibold text-slate-900 dark:text-white">Add Navigation Item</h3>
                <button onclick="closeModal()" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-slate-500">close</span>
                </button>
            </div>

            <form id="itemForm" class="space-y-4">
                <input type="hidden" id="item-id">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Name</label>
                    <input type="text" id="item-name" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Label</label>
                    <input type="text" id="item-label" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Icon</label>
                    <input type="text" id="item-icon" placeholder="e.g., home, settings, star" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Type</label>
                    <select id="item-type" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="link">Link</option>
                        <option value="button">Button</option>
                        <option value="divider">Divider</option>
                    </select>
                </div>

                <div id="route-field">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Route</label>
                    <input type="text" id="item-route" placeholder="e.g., landing, genacountdown" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div id="onclick-field" class="hidden">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">OnClick Function</label>
                    <input type="text" id="item-onclick" placeholder="e.g., toggleSettings()" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
let navItems = @json($navItems);

// Initialize sortable
const sortable = Sortable.create(document.getElementById('nav-items-container'), {
    handle: '.drag-handle',
    animation: 150,
    onEnd: function(evt) {
        updateOrder();
    }
});

// Update preview
    function updatePreview() {
        const preview = document.getElementById('nav-preview');
        const visibleItems = navItems.filter(item => item.is_visible).sort((a, b) => a.order - b.order);
        
        preview.innerHTML = visibleItems.map(item => `
            <div class="flex flex-col items-center justify-center p-1 text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-[20px] mb-0.5">${item.icon}</span>
                <span class="text-[8px] font-bold uppercase tracking-tighter scale-90">${item.label}</span>
            </div>
        `).join('');
    }

// Update order
function updateOrder() {
    const items = Array.from(document.querySelectorAll('.nav-item')).map(el => parseInt(el.dataset.id));
    
    fetch('/admin/navigation/order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ items })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update local navItems order
            items.forEach((id, index) => {
                const item = navItems.find(item => item.id === id);
                if (item) item.order = index + 1;
            });
            updatePreview();
        }
    });
}

// Toggle visibility
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('visibility-toggle')) {
        const itemId = parseInt(e.target.dataset.id);
        const isVisible = e.target.checked;
        
        fetch(`/admin/navigation/${itemId}/visibility`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ is_visible: isVisible })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = navItems.find(item => item.id === itemId);
                if (item) item.is_visible = isVisible;
                updatePreview();
            }
        });
    }
});

// Modal functions
function openAddModal() {
    document.getElementById('modal-title').textContent = 'Add Navigation Item';
    document.getElementById('itemForm').reset();
    document.getElementById('item-id').value = '';
    document.getElementById('itemModal').classList.remove('hidden');
}

function editItem(id) {
    const item = navItems.find(item => item.id === id);
    if (!item) return;
    
    document.getElementById('modal-title').textContent = 'Edit Navigation Item';
    document.getElementById('item-id').value = item.id;
    document.getElementById('item-name').value = item.name;
    document.getElementById('item-label').value = item.label;
    document.getElementById('item-icon').value = item.icon;
    document.getElementById('item-type').value = item.type;
    document.getElementById('item-route').value = item.route || '';
    
    if (item.attributes && item.attributes.onclick) {
        document.getElementById('item-onclick').value = item.attributes.onclick;
    }
    
    toggleTypeFields();
    document.getElementById('itemModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('itemModal').classList.add('hidden');
}

function deleteItem(id) {
    if (!confirm('Are you sure you want to delete this navigation item?')) return;
    
    fetch(`/admin/navigation/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Toggle type-specific fields
function toggleTypeFields() {
    const type = document.getElementById('item-type').value;
    const routeField = document.getElementById('route-field');
    const onclickField = document.getElementById('onclick-field');
    
    if (type === 'button') {
        routeField.classList.add('hidden');
        onclickField.classList.remove('hidden');
    } else {
        routeField.classList.remove('hidden');
        onclickField.classList.add('hidden');
    }
}

document.getElementById('item-type').addEventListener('change', toggleTypeFields);

// Form submission
document.getElementById('itemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const itemId = document.getElementById('item-id').value;
    const formData = {
        name: document.getElementById('item-name').value,
        label: document.getElementById('item-label').value,
        icon: document.getElementById('item-icon').value,
        type: document.getElementById('item-type').value,
        route: document.getElementById('item-route').value,
        attributes: {}
    };
    
    if (formData.type === 'button') {
        const onclick = document.getElementById('item-onclick').value;
        if (onclick) {
            formData.attributes.onclick = onclick;
        }
    }
    
    const url = itemId ? `/admin/navigation/${itemId}` : '/admin/navigation';
    const method = itemId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
});

// Initialize preview
updatePreview();
</script>
@endsection
