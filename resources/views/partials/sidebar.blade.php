<?php
    $groups = [
        'Main' => [
            ['route' => 'dashboard',   'label' => 'Dashboard',   'icon' => 'bi-house'],
            ['route' => 'tasks',       'label' => 'Tasks',       'icon' => 'bi-list-check'],
            ['route' => 'exhibitions', 'label' => 'Exhibitions', 'icon' => 'bi-easel2'],
            ['route' => 'contacts',    'label' => 'Contacts',    'icon' => 'bi-person-rolodex'],
        ],
        'Finance & Inventory' => [
            ['route' => 'finance',   'label' => 'Finance',              'icon' => 'bi-wallet2'],
            ['route' => 'contracts', 'label' => 'Contracts & Invoices', 'icon' => 'bi-file-earmark-text'],
            ['route' => 'stock',     'label' => 'Stock',                'icon' => 'bi-box-seam'],
        ],
        'Utility' => [
            ['route' => 'oman',     'label' => 'This is Oman', 'icon' => 'bi-camera-reels'],
            ['route' => 'archive',  'label' => 'Archive',  'icon' => 'bi-archive'],
            ['route' => 'data',     'label' => 'Data',     'icon' => 'bi-database'],
            ['route' => 'settings', 'label' => 'Settings', 'icon' => 'bi-gear'],
        ],
    ];
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <span class="brand-mark"><i class="bi bi-broadcast-pin"></i></span>
        <span class="brand-text">{{ __('Event Puls') }}</span>
    </div>

    <div class="sidebar-search">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="{{ __('Search...') }}">
    </div>

    <nav class="sidebar-nav">
        @foreach ($groups as $label => $items)
            <div class="nav-group-label">{{ __($label) }}</div>
            @foreach ($items as $item)
                <a href="{{ route($item['route']) }}"
                   class="nav-link {{ request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*') ? 'active' : '' }}">
                    <i class="bi {{ $item['icon'] }}"></i>
                    <span>{{ __($item['label']) }}</span>
                </a>
            @endforeach
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <div class="user-chip">
            <span class="avatar">SA</span>
            <div class="user-meta">
                <strong>Admin</strong>
                <small>{{ Auth::user()->email ?? 'admin@eventpuls.sa' }}</small>
            </div>
            <i class="bi bi-three-dots"></i>
        </div>
    </div>
</aside>
