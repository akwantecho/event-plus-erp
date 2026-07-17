@php $stab = $stab ?? 'general'; @endphp
<div class="page-head head-bar full-bleed sheet-aligned">
    <div>
        <h1>{{ __('Settings') }}</h1>
        <p class="subtitle">{{ __('System settings, archive and reports') }}</p>
    </div>
</div>

<div class="toolbar full-bleed sheet-aligned" style="padding-block:0;">
    <div class="tabs">
        <a href="{{ route('settings', ['tab' => 'general']) }}" class="tab {{ $stab === 'general' ? 'active' : '' }}"><i class="bi bi-sliders"></i>{{ __('General Settings') }}</a>
        <a href="{{ route('settings', ['tab' => 'users']) }}" class="tab {{ $stab === 'users' ? 'active' : '' }}"><i class="bi bi-people"></i>{{ __('Roles & Users') }}</a>
        <a href="{{ route('settings', ['tab' => 'finance']) }}" class="tab {{ $stab === 'finance' ? 'active' : '' }}"><i class="bi bi-wallet2"></i>{{ __('Finance Settings') }}</a>
        <a href="{{ route('archive') }}" class="tab {{ $stab === 'archive' ? 'active' : '' }}"><i class="bi bi-archive"></i>{{ __('Archive') }}</a>
        <a href="{{ route('reports') }}" class="tab {{ $stab === 'reports' ? 'active' : '' }}"><i class="bi bi-bar-chart"></i>{{ __('Reports') }}</a>
    </div>
</div>
