@extends('layouts.app')
@section('title', $project['name'])

@section('content')
    <div class="page-head head-bar full-bleed sheet-aligned" style="align-items:flex-start;">
        <div>
            <a href="{{ route('projects') }}" class="section-link"><i class="bi bi-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}-short"></i> {{ __('Projects') }}</a>
            <h1 class="mt-1">{{ $project['name'] }}</h1>
            <p class="subtitle">
                @if ($project['client'])<i class="bi bi-person"></i> {{ $project['client'] }} · @endif
                @if ($project['location'])<i class="bi bi-geo-alt"></i> {{ $project['location'] }} · @endif
                {{ $project['start'] }} → {{ $project['end'] }}
                · @include('partials.status', ['status' => $project['status']])
            </p>
        </div>
    </div>

    <div class="toolbar full-bleed sheet-aligned" style="padding-block:0;">
        <div class="tabs">
            <a href="{{ route('projects.show', [$project['id'], 'tab' => 'summary']) }}" class="tab {{ $active === 'summary' ? 'active' : '' }}">
                <i class="bi bi-clipboard-data"></i>{{ __('Summary') }}
            </a>
            <a href="{{ route('projects.show', [$project['id'], 'tab' => 'documents']) }}" class="tab {{ $active === 'documents' ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i>{{ __('Documents') }}
            </a>
        </div>
    </div>

    @if ($active === 'summary')
        <div class="full-bleed sheet-aligned" style="padding-block:16px;">
            <div class="stat-row" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-bottom:16px;">
                @foreach ($summary as $s)
                    <div class="card" style="padding:16px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span class="act-icon {{ $s['color'] }}"><i class="bi {{ $s['icon'] }}"></i></span>
                            <div>
                                <div class="cell-muted" style="font-size:12px;">{{ __($s['key']) }}</div>
                                <div class="cell-strong" style="font-size:18px;">{{ $s['value'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card">
                <div class="card-head"><h2>{{ __('Project Details') }}</h2></div>
                <div class="card-body">
                    <ul class="info-list">
                        <li><span class="k">{{ __('Project Name') }}</span><span class="v">{{ $project['name'] }}</span></li>
                        <li><span class="k">{{ __('Client') }}</span><span class="v">{{ $project['client'] ?: '—' }}</span></li>
                        <li><span class="k">{{ __('Location') }}</span><span class="v">{{ $project['location'] ?: '—' }}</span></li>
                        <li><span class="k">{{ __('Start Date') }}</span><span class="v">{{ $project['start'] ?: '—' }}</span></li>
                        <li><span class="k">{{ __('End Date') }}</span><span class="v">{{ $project['end'] ?: '—' }}</span></li>
                        <li><span class="k">{{ __('Status') }}</span><span class="v">{{ __($project['status']) }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($active === 'documents')
        {{-- Contracts --}}
        @include('pages.partials.project-doc-table', [
            'title' => __('Contracts'),
            'createUrl' => route('contracts.create', ['project' => $project['id']]),
            'createLabel' => __('Create Contract'),
            'showRoute' => 'contracts.show',
            'editRoute' => 'contracts.edit',
            'destroyRoute' => 'contracts.destroy',
            'amountLabel' => __('Value'),
            'rows' => $contracts,
            'empty' => __('No contracts yet.'),
        ])

        {{-- Quotations --}}
        @include('pages.partials.project-doc-table', [
            'title' => __('Quotations'),
            'createUrl' => route('quotations.create', ['project' => $project['id']]),
            'createLabel' => __('Create Quotation'),
            'showRoute' => 'quotations.show',
            'editRoute' => 'quotations.edit',
            'destroyRoute' => 'quotations.destroy',
            'amountLabel' => __('Total'),
            'rows' => $quotations,
            'empty' => __('No quotations yet.'),
        ])

        {{-- Invoices --}}
        @include('pages.partials.project-doc-table', [
            'title' => __('Invoices'),
            'createUrl' => route('invoices.create', ['project' => $project['id']]),
            'createLabel' => __('Create Invoice'),
            'showRoute' => 'invoices.show',
            'editRoute' => 'invoices.edit',
            'destroyRoute' => 'invoices.destroy',
            'amountLabel' => __('Amount'),
            'rows' => $invoices,
            'empty' => __('No invoices yet.'),
        ])
    @endif
@endsection
