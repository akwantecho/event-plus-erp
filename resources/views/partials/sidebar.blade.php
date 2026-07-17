<?php
    $links = [
        ['route' => 'tasks',       'label' => 'Tasks',       'icon' => 'bi-list-check'],
        ['route' => 'exhibitions', 'label' => 'Exhibitions', 'icon' => 'bi-easel2'],
        ['route' => 'projects',    'label' => 'Projects',    'icon' => 'bi-briefcase'],
        ['route' => 'contacts',    'label' => 'Contacts',    'icon' => 'bi-person-rolodex'],
        ['route' => 'finance',     'label' => 'Finance',     'icon' => 'bi-wallet2'],
        ['route' => 'stock',       'label' => 'Products',    'icon' => 'bi-box-seam'],
        ['route' => 'settings',    'label' => 'Settings',    'icon' => 'bi-gear'],
    ];
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/logo.svg') }}" alt="{{ __('Event Puls') }}" class="brand-logo">
    </div>

    <nav class="sidebar-nav">
        @foreach ($links as $item)
            @php
                $isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*');
                // Archive & Reports now live under Settings — keep it highlighted there.
                if ($item['route'] === 'settings') {
                    $isActive = $isActive || request()->routeIs('archive') || request()->routeIs('reports');
                }
            @endphp
            <a href="{{ route($item['route']) }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>
                <span>{{ __($item['label']) }}</span>
            </a>
        @endforeach
    </nav>
</aside>
