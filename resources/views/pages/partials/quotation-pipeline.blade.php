{{-- Quotations list with a "New Quotation" button. Expects $rows and $createUrl. --}}
<div class="toolbar full-bleed sheet-aligned">
    <strong>{{ __('Quotations') }}</strong>
    <a href="{{ $createUrl }}" class="btn-brand"><i class="bi bi-plus-lg"></i>{{ __('New Quotation') }}</a>
</div>
<div class="full-bleed">
    <div class="sheet-frame">
        <div class="table-wrap">
            <table class="data sheet">
                <thead><tr>
                    <th style="width:46px">#</th>
                    <th>{{ __('Quotation No.') }}</th>
                    <th>{{ __('Project / Exhibition') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th style="width:110px">{{ __('Actions') }}</th>
                </tr></thead>
                <tbody>
                @forelse ($rows as $q)
                    <tr class="row-link" data-title="{{ $q['no'] }} {{ $q['name'] }}" onclick="window.location='{{ route('quotations.show', $q['no']) }}'">
                        <td class="cell-muted">{{ $loop->iteration }}</td>
                        <td class="cell-strong">{{ $q['no'] }}</td>
                        <td class="cell-muted">{{ $q['name'] ?: '—' }}</td>
                        <td class="cell-strong">{{ $q['amount'] }}</td>
                        <td class="cell-muted">{{ $q['date'] ?: '—' }}</td>
                        <td>@include('partials.status', ['status' => $q['status']])</td>
                        <td><div class="row-actions" onclick="event.stopPropagation()">
                            <a href="{{ route('quotations.show', $q['no']) }}" title="{{ __('View') }}"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('quotations.edit', $q['id']) }}" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('quotations.destroy', $q['id']) }}" onsubmit="return confirm('{{ __('Delete this quotation?') }}')" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="danger" style="background:none;border:0;padding:0;cursor:pointer;color:inherit" title="{{ __('Delete') }}"><i class="bi bi-trash3"></i></button>
                            </form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="cell-muted" style="text-align:center;padding:20px">{{ __('No quotations yet.') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
