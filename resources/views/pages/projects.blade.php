@extends('layouts.app')
@section('title', __('Projects'))

@php $items = collect($projects); @endphp

@section('content')
    <div class="page-head head-bar full-bleed sheet-aligned">
        <div>
            <h1>{{ __('Projects') }}</h1>
            <p class="subtitle">{{ $items->count() }} {{ __('Projects') }}</p>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="{{ route('quotations.create', ['type' => 'project']) }}" class="chip"><i class="bi bi-file-earmark-ruled"></i>{{ __('New Quotation') }}</a>
            <button class="btn-brand" id="addProjectBtn"><i class="bi bi-plus-lg"></i>{{ __('Add Project') }}</button>
        </div>
    </div>

    <div class="toolbar full-bleed sheet-aligned" style="padding-block:0;">
        <div class="tabs">
            <a href="{{ route('projects', ['tab' => 'projects']) }}" class="tab {{ $tab === 'projects' ? 'active' : '' }}"><i class="bi bi-briefcase"></i>{{ __('Projects') }}</a>
            <a href="{{ route('projects', ['tab' => 'quotations']) }}" class="tab {{ $tab === 'quotations' ? 'active' : '' }}"><i class="bi bi-file-earmark-ruled"></i>{{ __('Quotations') }}</a>
        </div>
    </div>

    @if ($tab === 'quotations')
        @include('pages.partials.quotation-pipeline', ['rows' => $quotations, 'createUrl' => route('quotations.create', ['type' => 'project'])])
    @else
    <div class="toolbar full-bleed sheet-aligned">
        <div class="toolbar-start">
            <label class="search-input">
                <i class="bi bi-search"></i>
                <input type="text" id="prSearch" placeholder="{{ __('Search projects...') }}">
            </label>
        </div>
    </div>

    <div class="full-bleed">
        <div class="sheet-frame">
            <div class="table-wrap">
                <table class="data sheet">
                    <thead><tr>
                        <th style="width:46px">#</th>
                        <th>{{ __('Project Name') }}</th>
                        <th>{{ __('Client') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Start Date') }}</th>
                        <th>{{ __('End Date') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th style="width:120px">{{ __('Actions') }}</th>
                    </tr></thead>
                    <tbody>
                    @forelse ($projects as $p)
                        <tr class="row-link" data-title="{{ $p['name'] }} {{ $p['client'] }}" data-project="{{ json_encode($p, JSON_UNESCAPED_UNICODE) }}"
                            onclick="window.location='{{ route('projects.show', $p['id']) }}'">
                            <td class="cell-muted">{{ $loop->iteration }}</td>
                            <td class="cell-strong">{{ $p['name'] }}</td>
                            <td class="cell-muted">{{ $p['client'] ?: '—' }}</td>
                            <td class="cell-muted">{{ $p['location'] ?: '—' }}</td>
                            <td class="cell-muted">{{ $p['start'] ?: '—' }}</td>
                            <td class="cell-muted">{{ $p['end'] ?: '—' }}</td>
                            <td>@include('partials.status', ['status' => $p['status']])</td>
                            <td><div class="row-actions" onclick="event.stopPropagation()">
                                <a href="{{ route('projects.show', $p['id']) }}" title="{{ __('View') }}"><i class="bi bi-eye"></i></a>
                                <button type="button" class="edit-project" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></button>
                                <form method="POST" action="{{ route('projects.destroy', $p['id']) }}" onsubmit="return confirm('{{ __('Delete this record?') }}')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="danger" title="{{ __('Delete') }}"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="cell-muted" style="text-align:center;padding:24px">{{ __('No projects yet.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Add / Edit Project modal --}}
    <div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border:1px solid var(--line); border-radius:16px;">
                <form method="POST" id="projectForm" action="{{ route('projects.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="prMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prModalTitle" style="font-size:16px; font-weight:700;">{{ __('Add Project') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Project Name') }} <span class="req">*</span></label>
                            <input type="text" name="name" id="prName" class="form-control w-100" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Client') }}</label>
                            <select name="client_id" id="prClient" class="form-select w-100">
                                <option value="">—</option>
                                @foreach ($clients as $c)
                                    <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Location') }}</label>
                            <input type="text" name="location" id="prLocation" class="form-control w-100">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label class="form-label">{{ __('Start Date') }}</label>
                                <input type="date" name="start_date" id="prStart" class="form-control w-100">
                            </div>
                            <div class="col">
                                <label class="form-label">{{ __('End Date') }}</label>
                                <input type="date" name="end_date" id="prEnd" class="form-control w-100">
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="status" id="prStatus" class="form-select w-100">
                                <option value="Upcoming">{{ __('Upcoming') }}</option>
                                <option value="Active">{{ __('Active') }}</option>
                                <option value="Completed">{{ __('Completed') }}</option>
                                <option value="Cancelled">{{ __('Cancelled') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="page-btn" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn-brand"><i class="bi bi-check-lg"></i>{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const search = document.getElementById('prSearch');
        if (search) search.addEventListener('input', () => {
            const q = search.value.trim().toLowerCase();
            document.querySelectorAll('tr[data-title]').forEach(el => {
                el.classList.toggle('is-hidden', !el.dataset.title.toLowerCase().includes(q));
            });
        });

        const modal = new bootstrap.Modal(document.getElementById('projectModal'));
        const form = document.getElementById('projectForm');
        const storeAction = @json(route('projects.store'));
        const updateBase = @json(url('projects'));
        const setVal = (id, v) => { document.getElementById(id).value = (v ?? ''); };

        document.getElementById('addProjectBtn').addEventListener('click', () => {
            form.reset();
            form.action = storeAction;
            document.getElementById('prMethod').value = 'POST';
            document.getElementById('prModalTitle').textContent = @json(__('Add Project'));
            modal.show();
        });

        document.querySelectorAll('.edit-project').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const d = JSON.parse(btn.closest('tr').dataset.project);
                form.reset();
                form.action = updateBase + '/' + d.id;
                document.getElementById('prMethod').value = 'PUT';
                document.getElementById('prModalTitle').textContent = @json(__('Edit Project'));
                setVal('prName', d.name);
                setVal('prClient', d.clientId);
                setVal('prLocation', d.location);
                setVal('prStart', d.start);
                setVal('prEnd', d.end);
                setVal('prStatus', d.status);
                modal.show();
            });
        });
    })();
</script>
@endpush
