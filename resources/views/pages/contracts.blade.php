@extends('layouts.app')
@section('title', __('Contracts & Invoices'))

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ __('Contracts & Invoices') }}</h1>
            <p class="subtitle">{{ __('Create and track contracts and invoices') }}</p>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <button class="chip"><i class="bi bi-file-earmark-plus"></i>{{ __('Create Contract') }}</button>
            <button class="btn-brand"><i class="bi bi-receipt"></i>{{ __('Create Invoice') }}</button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-head"><h2>{{ __('Contracts') }}</h2><span class="section-link">{{ count($contracts) }} {{ __('Contracts') }}</span></div>
        <div class="card-body p-0">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr>
                        <th>{{ __('Contract No.') }}</th><th>{{ __('Client') }}</th><th>{{ __('Exhibition') }}</th>
                        <th>{{ __('Value') }}</th><th>{{ __('Date') }}</th><th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th>
                    </tr></thead>
                    <tbody>
                    @foreach ($contracts as $c)
                        <tr>
                            <td class="cell-strong">{{ $c['no'] }}</td>
                            <td class="cell-muted">{{ $c['client'] }}</td>
                            <td class="cell-muted">{{ $c['exhibition'] }}</td>
                            <td class="cell-strong">{{ $c['value'] }}</td>
                            <td class="cell-muted">{{ $c['date'] }}</td>
                            <td>@include('partials.status', ['status' => $c['status']])</td>
                            <td><div class="row-actions"><a href="#" title="{{ __('View') }}"><i class="bi bi-eye"></i></a><a href="#" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></a></div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head"><h2>{{ __('Invoices') }}</h2><span class="section-link">{{ count($invoices) }} {{ __('Invoices') }}</span></div>
        <div class="card-body p-0">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr>
                        <th>{{ __('Invoice No.') }}</th><th>{{ __('Client') }}</th><th>{{ __('Contract') }}</th>
                        <th>{{ __('Amount') }}</th><th>{{ __('Date') }}</th><th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th>
                    </tr></thead>
                    <tbody>
                    @foreach ($invoices as $inv)
                        <tr>
                            <td class="cell-strong">{{ $inv['no'] }}</td>
                            <td class="cell-muted">{{ $inv['client'] }}</td>
                            <td class="cell-muted">{{ $inv['contract'] }}</td>
                            <td class="cell-strong">{{ $inv['amount'] }}</td>
                            <td class="cell-muted">{{ $inv['date'] }}</td>
                            <td>@include('partials.status', ['status' => $inv['status']])</td>
                            <td><div class="row-actions"><a href="#" title="{{ __('View') }}"><i class="bi bi-eye"></i></a><a href="#" title="{{ __('Download') }}"><i class="bi bi-download"></i></a></div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
