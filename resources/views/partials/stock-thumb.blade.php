@php($icon = $icon ?? 'bi-box-seam')
@if (!empty($image))
    <span class="stock-thumb"><img src="{{ asset($image) }}" alt=""></span>
@else
    <span class="stock-thumb stock-thumb--empty"><i class="bi {{ $icon }}"></i></span>
@endif
