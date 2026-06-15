@php
    $map = [
        'High'   => ['red', 'bi-arrow-up'],
        'Medium' => ['amber', 'bi-dash'],
        'Low'    => ['gray', 'bi-arrow-down'],
    ];
    [$color, $icon] = $map[$priority] ?? ['gray', 'bi-dash'];
@endphp
<span class="tag {{ $color }}"><i class="bi {{ $icon }}"></i> {{ __($priority) }}</span>
