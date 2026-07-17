{{-- A titled document list (contracts / quotations / invoices) with a create button. --}}
<div class="toolbar full-bleed sheet-aligned">
    <strong>{{ $title }}</strong>
    <a href="{{ $createUrl }}" class="btn-brand"><i class="bi bi-plus-lg"></i>{{ $createLabel }}</a>
</div>
<div class="full-bleed" style="margin-bottom:8px;">
    <div class="sheet-frame">
        <div class="table-wrap">
            <table class="data sheet">
                <thead><tr>
                    <th style="width:46px">#</th>
                    <th>{{ __('No.') }}</th>
                    <th>{{ $amountLabel }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th style="width:110px">{{ __('Actions') }}</th>
                </tr></thead>
                <tbody>
                @forelse ($rows as $row)
                    <tr class="row-link" onclick="window.location='{{ route($showRoute, $row['no']) }}'">
                        <td class="cell-muted">{{ $loop->iteration }}</td>
                        <td class="cell-strong">{{ $row['no'] }}</td>
                        <td class="cell-strong">{{ $row['amount'] ?? $row['value'] ?? '—' }}</td>
                        <td class="cell-muted">{{ $row['date'] ?: '—' }}</td>
                        <td>@include('partials.status', ['status' => $row['status']])</td>
                        <td><div class="row-actions" onclick="event.stopPropagation()">
                            <a href="{{ route($showRoute, $row['no']) }}" title="{{ __('View') }}"><i class="bi bi-eye"></i></a>
                            <a href="{{ route($editRoute, $row['id']) }}" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route($destroyRoute, $row['id']) }}" onsubmit="return confirm('{{ __('Delete this record?') }}')" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="danger" style="background:none;border:0;padding:0;cursor:pointer;color:inherit" title="{{ __('Delete') }}"><i class="bi bi-trash3"></i></button>
                            </form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="cell-muted" style="text-align:center;padding:18px">{{ $empty }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
