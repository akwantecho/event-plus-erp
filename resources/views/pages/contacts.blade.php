@extends('layouts.app')
@section('title', __('Contacts'))

@php $dir = $directories[$active]; @endphp

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ __('Contacts') }}</h1>
            <p class="subtitle">{{ __('Entities, clients, organizers and suppliers') }}</p>
        </div>
        <button class="btn-brand"><i class="bi bi-plus-lg"></i>{{ __($dir['add']) }}</button>
    </div>

    <div class="tabs">
        @foreach ($types as $key => $type)
            <a href="{{ route('contacts', ['type' => $key]) }}" class="tab {{ $active === $key ? 'active' : '' }}">
                <i class="bi {{ $type['icon'] }}"></i>{{ __($type['label']) }}
            </a>
        @endforeach
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                    <tr>
                        @foreach ($dir['columns'] as $col)
                            <th>{{ __($col) }}</th>
                        @endforeach
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($dir['rows'] as $row)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar sm">{{ mb_substr($row['name'], 0, 1) }}</span>
                                    <span class="cell-strong">{{ $row['name'] }}</span>
                                </div>
                            </td>
                            @if ($active === 'entities')
                                <td class="cell-muted" dir="ltr">{{ $row['phone'] }}</td>
                                <td class="cell-muted" dir="ltr">{{ $row['email'] }}</td>
                                <td class="cell-muted">{{ $row['rep'] }}</td>
                                <td class="cell-muted"><i class="bi bi-people me-1"></i>{{ $row['persons'] }}</td>
                            @elseif ($active === 'clients')
                                <td class="cell-muted" dir="ltr">{{ $row['phone'] }}</td>
                                <td class="cell-muted">{{ $row['entity'] }}</td>
                                <td class="cell-muted" dir="ltr">{{ $row['email'] }}</td>
                                <td class="cell-muted">{{ $row['bookings'] }}</td>
                            @elseif ($active === 'organizers')
                                <td class="cell-muted" dir="ltr">{{ $row['phone'] }}</td>
                                <td class="cell-muted" dir="ltr">{{ $row['email'] }}</td>
                                <td class="cell-muted">{{ $row['events'] }}</td>
                            @else
                                <td class="cell-muted" dir="ltr">{{ $row['phone'] }}</td>
                                <td class="cell-muted" dir="ltr">{{ $row['email'] }}</td>
                                <td class="cell-muted">{{ $row['category'] }}</td>
                            @endif
                            <td>@include('partials.status', ['status' => $row['status']])</td>
                            <td>
                                <div class="row-actions">
                                    <a href="#" title="{{ __('View') }}"><i class="bi bi-eye"></i></a>
                                    <a href="#" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></a>
                                    <button class="danger" title="{{ __('Delete') }}"><i class="bi bi-trash3"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
