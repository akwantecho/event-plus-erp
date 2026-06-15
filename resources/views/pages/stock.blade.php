@extends('layouts.app')
@section('title', __('Stock'))

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ __('Stock') }}</h1>
            <p class="subtitle">{{ __('Devices, equipment and services') }}</p>
        </div>
        <button class="btn-brand"><i class="bi bi-plus-lg"></i>{{ $active === 'services' ? __('Add Service') : __('Add Item') }}</button>
    </div>

    <div class="tabs">
        @foreach ($types as $key => $type)
            <a href="{{ route('stock', ['type' => $key]) }}" class="tab {{ $active === $key ? 'active' : '' }}">
                <i class="bi {{ $type['icon'] }}"></i>{{ __($type['label']) }}
            </a>
        @endforeach
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-wrap">
                @if ($active === 'equipment')
                    <table class="data">
                        <thead><tr>
                            <th>{{ __('Name') }}</th><th>{{ __('SKU') }}</th><th>{{ __('Quantity') }}</th>
                            <th>{{ __('Available') }}</th><th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th>
                        </tr></thead>
                        <tbody>
                        @foreach ($equipment as $e)
                            <tr>
                                <td class="cell-strong"><i class="bi bi-box-seam me-1"></i>{{ $e['name'] }}</td>
                                <td class="cell-muted" dir="ltr">{{ $e['sku'] }}</td>
                                <td class="cell-muted">{{ $e['qty'] }}</td>
                                <td class="cell-muted">{{ $e['available'] }}</td>
                                <td>@include('partials.status', ['status' => $e['status']])</td>
                                <td><div class="row-actions"><a href="#" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></a><button class="danger" title="{{ __('Delete') }}"><i class="bi bi-trash3"></i></button></div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <table class="data">
                        <thead><tr>
                            <th>{{ __('Name') }}</th><th>{{ __('Unit') }}</th><th>{{ __('Price') }}</th>
                            <th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th>
                        </tr></thead>
                        <tbody>
                        @foreach ($services as $s)
                            <tr>
                                <td class="cell-strong"><i class="bi bi-tools me-1"></i>{{ $s['name'] }}</td>
                                <td class="cell-muted">{{ $s['unit'] }}</td>
                                <td class="cell-strong">{{ $s['price'] }}</td>
                                <td>@include('partials.status', ['status' => $s['status']])</td>
                                <td><div class="row-actions"><a href="#" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></a><button class="danger" title="{{ __('Delete') }}"><i class="bi bi-trash3"></i></button></div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
