@extends('layouts.app')
@section('title', $isEdit ? __('Edit Quotation') : __('Create Quotation'))

@php $cur = $quotation['currency'] ?? 'ر.ع'; @endphp

@section('content')
    {{-- Editor action bar --}}
    <div class="editor-bar full-bleed">
        <div class="editor-bar-start">
            <a href="{{ $backUrl }}" class="btn-icon" title="{{ __('Close') }}"><i class="bi bi-x-lg"></i></a>
            <strong>{{ $isEdit ? __('Edit Quotation') : __('Create Quotation') }}</strong>
        </div>
        <div class="editor-bar-end">
            <button type="submit" form="docForm" name="intent" value="draft" class="chip"><i class="bi bi-floppy"></i>{{ __('Save as Draft') }}</button>
            <button type="submit" form="docForm" name="intent" value="send" class="btn-brand"><i class="bi bi-check2"></i>{{ __('Save & Preview') }}</button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger full-bleed" style="margin:0 0 1rem;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="docForm" method="POST" action="{{ $action }}" class="invoice-doc">
        @csrf
        @if ($isEdit) @method('PUT') @endif
        <input type="hidden" name="project_id" value="{{ $quotation['projectId'] }}">
        <input type="hidden" name="target_type" value="{{ $quotation['targetType'] }}">

        <div class="inv-head">
            <h2 class="inv-title">{{ __('Quotation') }}</h2>
            <span class="section-link"><i class="bi bi-hash me-1"></i>{{ $quotation['number'] }}</span>
        </div>

        <div class="row g-4 inv-top">
            <div class="col-lg-7 order-2 order-lg-1">
                {{-- Recipient client: type-to-search + quick add --}}
                <div class="inv-field">
                    <label>{{ __('Recipient (Client)') }}</label>
                    <div class="combo" id="clientCombo"
                         data-options='@json($clients)'
                         data-empty="{{ __('No matching customers') }}">
                        <input type="hidden" name="client_id" value="{{ $quotation['clientId'] }}">
                        <input type="text" class="form-control combo-input" autocomplete="off" placeholder="{{ __('Type customer name to search…') }}">
                        <div class="combo-pop">
                            <ul class="combo-list"></ul>
                            <button type="button" class="combo-add" data-modal="addClientModal"><i class="bi bi-plus-lg"></i>{{ __('Add new customer') }}</button>
                        </div>
                    </div>
                    <div class="cell-muted" style="font-size:12px;margin-top:5px">{{ __('Selecting a customer fills the “Sent to” name below.') }}</div>
                </div>

                <div class="inv-field">
                    <label>{{ __('Sent to (name shown on the quote)') }}</label>
                    <input type="text" name="recipient" id="recipientInput" class="form-control" value="{{ old('recipient', $quotation['recipient']) }}" placeholder="{{ __('e.g. Sunna Makers Co.') }}">
                </div>

                <div class="inv-field">
                    <label>{{ __('Quotation Number') }} <span class="req">*</span></label>
                    <input type="text" name="number" class="form-control" value="{{ old('number', $quotation['number']) }}">
                </div>

                <div class="inv-field">
                    <label>{{ __('Project Name') }}</label>
                    <input type="text" name="project_name" class="form-control" value="{{ old('project_name', $quotation['projectName']) }}" placeholder="{{ __('e.g. Company Exhibition (Salalah)') }}">
                </div>

                {{-- Exhibition: type-to-search + quick add --}}
                <div class="inv-field">
                    <label>{{ __('Exhibition') }}</label>
                    <div class="combo" id="exhibitionCombo"
                         data-options='@json($exhibitions)'
                         data-empty="{{ __('No matching exhibitions') }}">
                        <input type="hidden" name="exhibition_id" value="{{ $quotation['exhibitionId'] }}">
                        <input type="text" class="form-control combo-input" autocomplete="off" placeholder="{{ __('Type exhibition name to search…') }}">
                        <div class="combo-pop">
                            <ul class="combo-list"></ul>
                            <button type="button" class="combo-add" data-modal="addExhibitionModal"><i class="bi bi-plus-lg"></i>{{ __('Add new exhibition') }}</button>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-4 inv-field">
                        <label>{{ __('Currency') }} <span class="req">*</span></label>
                        <select name="currency" class="form-select">
                            <option value="ر.ع" selected>{{ __('Omani Rial') }} ر.ع</option>
                        </select>
                    </div>
                    <div class="col-md-4 inv-field">
                        <label>{{ __('Issue Date') }}</label>
                        <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date', $quotation['issueDate']) }}">
                    </div>
                    <div class="col-md-4 inv-field">
                        <label>{{ __('Accent Color') }}</label>
                        <select name="accent_color" id="accentSelect" class="form-select">
                            @foreach ($accents as $c)
                                <option value="{{ $c }}" @selected(old('accent_color', $quotation['accent']) === $c)>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Exhibition date range (تاريخ المعرض) --}}
                <div class="inv-field">
                    <label>{{ __('Exhibition Date') }}</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <span class="period-sub">{{ __('From') }}</span>
                            <input type="date" name="event_from" id="eventFrom" class="form-control" value="{{ old('event_from', $quotation['eventFrom']) }}">
                        </div>
                        <div class="col-6">
                            <span class="period-sub">{{ __('To') }}</span>
                            <input type="date" name="event_to" id="eventTo" class="form-control" value="{{ old('event_to', $quotation['eventTo']) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2">
                <div class="inv-company">
                    <span class="inv-logo">{{ $company['logo'] }}</span>
                    <div class="inv-company-info">
                        <strong>{{ $company['name'] }}</strong>
                        <div class="cell-muted">{{ $company['address'] }}</div>
                        <div class="cell-muted">{{ $company['country'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Timeline — الوقت --}}
        <div class="doc-sec">
            <div class="doc-sec-head"><span class="doc-sec-bar"></span><h3>{{ __('Timeline') }}</h3></div>
            <div class="table-wrap">
                <table class="doc-sec-table">
                    <thead><tr>
                        <th>{{ __('Item') }}</th>
                        <th style="width:38%">{{ __('Duration') }}</th>
                        <th style="width:44px"></th>
                    </tr></thead>
                    <tbody id="timelineBody"></tbody>
                </table>
            </div>
            <button type="button" class="chip inv-addline" id="addTimelineBtn"><i class="bi bi-plus-lg"></i>{{ __('Add Row') }}</button>
        </div>

        {{-- Products & Services — المنتجات والخدمات (linked to stock) --}}
        <div class="doc-sec">
            <div class="doc-sec-head"><span class="doc-sec-bar"></span><h3>{{ __('Products & Services') }}</h3></div>
            <datalist id="stockList">
                @foreach ($stock as $s)<option value="{{ $s['name'] }}">{{ $s['type'] === 'service' ? __('Service') : __('Product') }}</option>@endforeach
            </datalist>
            <div class="table-wrap">
                <table class="doc-sec-table">
                    <thead><tr>
                        <th>{{ __('Product / Service') }}</th>
                        <th style="width:16%">{{ __('Quantity / Count') }}</th>
                        <th style="width:24%">{{ __('Price') }}</th>
                        <th style="width:18%">{{ __('Total') }}</th>
                        <th style="width:44px"></th>
                    </tr></thead>
                    <tbody id="costBody"></tbody>
                    <tfoot>
                        <tr class="doc-sec-grand">
                            <td colspan="3">{{ __('Grand Total') }}</td>
                            <td colspan="2"><span id="sumTotal">0.00</span> {{ $cur }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <button type="button" class="chip inv-addline" id="addCostBtn"><i class="bi bi-plus-lg"></i>{{ __('Add Row') }}</button>
            <div class="cell-muted" style="font-size:12px;margin-top:6px">{{ __('Quantity auto-fills with the exhibition days; replace it with a count for devices. Picking a stock item fills its price and shows the available count.') }}</div>
            <div class="text-danger" id="stockWarn" style="font-size:12px;margin-top:4px;display:none"><i class="bi bi-exclamation-triangle"></i> {{ __('Some items exceed the available stock count.') }}</div>
        </div>

        {{-- Notices — تنويه --}}
        <div class="doc-sec">
            <div class="doc-sec-head"><span class="doc-sec-bar"></span><h3>{{ __('Notices') }}</h3></div>
            <div class="table-wrap">
                <table class="doc-sec-table">
                    <thead><tr>
                        <th style="width:26%">{{ __('Title') }}</th>
                        <th>{{ __('Text') }}</th>
                        <th style="width:44px"></th>
                    </tr></thead>
                    <tbody id="noticeBody"></tbody>
                </table>
            </div>
            <button type="button" class="chip inv-addline" id="addNoticeBtn"><i class="bi bi-plus-lg"></i>{{ __('Add Notice') }}</button>
        </div>
    </form>

    {{-- Quick-add: Customer --}}
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add new customer') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">{{ __('Name') }} <span class="req">*</span></label><input type="text" class="form-control" id="ac-name"></div>
                    <div class="mb-3"><label class="form-label">{{ __('Phone') }}</label><input type="text" class="form-control" id="ac-phone"></div>
                    <div class="mb-3"><label class="form-label">{{ __('Email') }}</label><input type="email" class="form-control" id="ac-email"></div>
                    <div class="text-danger small" id="ac-err"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="chip" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn-brand" id="ac-save"><i class="bi bi-check2"></i>{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick-add: Exhibition --}}
    <div class="modal fade" id="addExhibitionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add new exhibition') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">{{ __('Exhibition Name') }} <span class="req">*</span></label><input type="text" class="form-control" id="ae-title"></div>
                    <div class="mb-3"><label class="form-label">{{ __('Location') }}</label><input type="text" class="form-control" id="ae-location"></div>
                    <div class="row g-2">
                        <div class="col-6 mb-1"><label class="form-label">{{ __('Start Date') }}</label><input type="date" class="form-control" id="ae-start"></div>
                        <div class="col-6 mb-1"><label class="form-label">{{ __('End Date') }}</label><input type="date" class="form-control" id="ae-end"></div>
                    </div>
                    <div class="text-danger small" id="ae-err"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="chip" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn-brand" id="ae-save"><i class="bi bi-check2"></i>{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    .combo{position:relative}
    .combo-pop{position:absolute;inset-inline:0;top:calc(100% + 4px);z-index:1055;background:var(--panel,#fff);border:1px solid var(--line);border-radius:var(--radius-sm,9px);box-shadow:0 10px 28px rgba(20,20,40,.12);padding:8px;display:none}
    .combo.open .combo-pop{display:block}
    .combo-list{list-style:none;margin:0;padding:0;max-height:220px;overflow:auto}
    .combo-list li{padding:8px 10px;border-radius:8px;cursor:pointer;font-size:13px}
    .combo-list li:hover{background:var(--hover)}
    .combo-list li.empty{color:var(--muted);cursor:default}
    .combo-list li.empty:hover{background:transparent}
    .combo-add{width:100%;margin-top:8px;border:1px dashed var(--line);background:var(--brand-soft);color:var(--brand);border-radius:8px;padding:9px;font-size:13px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px}
    .combo-add:hover{filter:brightness(.97)}
    .combo-add i{font-size:14px}
    .period-sub{display:block;font-size:12px;color:var(--muted);margin-bottom:3px}
    .doc-sec{margin-top:26px}
    .doc-sec-head{display:flex;align-items:center;gap:10px;margin-bottom:10px}
    .doc-sec-head .doc-sec-bar{width:4px;height:20px;background:var(--muted-2,#aab0ba);border-radius:2px}
    .doc-sec-head h3{font-size:16px;font-weight:700;color:var(--ink,#1f2a37);margin:0}
    .doc-sec-table{width:100%;border-collapse:collapse;border:1px solid var(--line);border-radius:10px;overflow:hidden}
    .doc-sec-table thead th{background:#f2f4f6;color:#1f2a37;font-weight:600;font-size:13px;padding:11px 14px;text-align:start}
    .doc-sec-table tbody td{padding:5px 8px;border-top:1px solid #eef0f3;vertical-align:middle}
    .doc-sec-table tbody tr:nth-child(even){background:#fafbfc}
    .doc-sec-table .form-control{border:1px solid transparent;background:transparent;box-shadow:none}
    .doc-sec-table .form-control:focus{border-color:var(--line);background:#fff}
    .doc-sec-table .li-actions{width:44px;text-align:center}
    .doc-sec-table .li-del{border:0;background:transparent;color:var(--muted);cursor:pointer}
    .doc-sec-table .li-del:hover{color:#d6455d}
    .doc-sec-table tfoot .doc-sec-grand td{background:#f2f4f6;font-weight:700;color:#1f2a37;padding:12px 14px;border-top:1px solid var(--line)}
    .doc-sec-table tfoot .doc-sec-grand td:first-child{text-align:start}
    .doc-sec-table input.over-stock{border-color:#e0a800 !important;background:#fff8e6 !important}
</style>
<script>
    window.qtI18n = {
        required: @json(__('Required')),
        delete: @json(__('Delete')),
        currency: @json($cur),
        avail: @json(__('Available in stock')),
    };
    (function () {
        const t = window.qtI18n;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const esc = (s) => (s == null ? '' : String(s).replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c])));

        /* ---------- Type-to-search combo boxes ---------- */
        function initCombo(root, onSelect) {
            const hidden = root.querySelector('input[type="hidden"]');
            const input = root.querySelector('.combo-input');
            const list = root.querySelector('.combo-list');
            const emptyMsg = root.dataset.empty || 'لا نتائج';
            let options = JSON.parse(root.dataset.options || '[]');

            function render(filter) {
                const f = (filter || '').trim().toLowerCase();
                const items = f ? options.filter(o => String(o.name).toLowerCase().includes(f)) : options;
                list.innerHTML = items.length
                    ? items.slice(0, 50).map(o => `<li data-id="${o.id}">${esc(o.name)}</li>`).join('')
                    : `<li class="empty">${esc(emptyMsg)}</li>`;
            }
            function open() { root.classList.add('open'); render(input.value); }
            function close() { root.classList.remove('open'); }
            function select(id, name, fire) { hidden.value = id; input.value = name; close(); if (fire !== false && onSelect) onSelect(id, name); }

            input.addEventListener('focus', open);
            input.addEventListener('input', () => {
                const exact = options.find(o => String(o.name).toLowerCase() === input.value.trim().toLowerCase());
                hidden.value = exact ? exact.id : '';
                open();
            });
            list.addEventListener('click', (e) => {
                const li = e.target.closest('li[data-id]');
                if (!li) return;
                select(li.dataset.id, li.textContent);
            });
            document.addEventListener('click', (e) => { if (!root.contains(e.target)) close(); });

            const sel = hidden.value ? options.find(o => String(o.id) === String(hidden.value)) : null;
            if (sel) input.value = sel.name;

            root._combo = {
                addOption(o) { options.push(o); select(o.id, o.name); },
                set(id) { const o = options.find(x => String(x.id) === String(id)); if (o) { select(o.id, o.name, false); return true; } return false; },
                typedText() { return input.value.trim(); },
            };
        }
        const clientCombo = document.getElementById('clientCombo');
        const exhibitionCombo = document.getElementById('exhibitionCombo');
        const recipientInput = document.getElementById('recipientInput');
        // Picking a client fills the "Sent to" name unless the user already typed one.
        initCombo(clientCombo, (id, name) => { if (!recipientInput.value.trim()) recipientInput.value = name; });
        initCombo(exhibitionCombo);

        /* ---------- Quick-add modals ---------- */
        document.querySelectorAll('.combo-add').forEach(btn => {
            btn.addEventListener('click', () => {
                const combo = btn.closest('.combo');
                combo.classList.remove('open');
                const typed = combo._combo.typedText();
                if (btn.dataset.modal === 'addClientModal') document.getElementById('ac-name').value = typed;
                if (btn.dataset.modal === 'addExhibitionModal') document.getElementById('ae-title').value = typed;
                bootstrap.Modal.getOrCreateInstance(document.getElementById(btn.dataset.modal)).show();
            });
        });
        async function postJson(url, body) {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify(body),
            });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error(Object.values(data.errors || { e: [data.message || 'خطأ'] }).flat()[0]);
            return data;
        }
        function wireQuickAdd(saveBtnId, errId, url, gather, combo, modalId) {
            const btn = document.getElementById(saveBtnId);
            const err = document.getElementById(errId);
            btn.addEventListener('click', async () => {
                err.textContent = '';
                const body = gather();
                if (!body.__ok) { err.textContent = t.required; return; }
                delete body.__ok;
                btn.disabled = true;
                try {
                    const created = await postJson(url, body);
                    combo._combo.addOption(created);
                    bootstrap.Modal.getInstance(document.getElementById(modalId)).hide();
                } catch (e) { err.textContent = e.message; }
                finally { btn.disabled = false; }
            });
        }
        wireQuickAdd('ac-save', 'ac-err', @json(route('invoices.quickClient')), () => {
            const name = document.getElementById('ac-name').value.trim();
            return { __ok: !!name, name, phone: document.getElementById('ac-phone').value.trim(), email: document.getElementById('ac-email').value.trim() };
        }, clientCombo, 'addClientModal');
        wireQuickAdd('ae-save', 'ae-err', @json(route('invoices.quickExhibition')), () => {
            const title = document.getElementById('ae-title').value.trim();
            return { __ok: !!title, title, location: document.getElementById('ae-location').value.trim(), start_date: document.getElementById('ae-start').value, end_date: document.getElementById('ae-end').value };
        }, exhibitionCombo, 'addExhibitionModal');
        ['addClientModal', 'addExhibitionModal'].forEach(id => {
            document.getElementById(id).addEventListener('hidden.bs.modal', function () {
                this.querySelectorAll('input').forEach(i => i.value = '');
                this.querySelectorAll('.text-danger').forEach(e => e.textContent = '');
            });
        });

        /* ---------- Grand total ---------- */
        const fmt = (n) => n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        function recalc() {
            let subtotal = 0;
            document.querySelectorAll('#costBody .cost-total').forEach((i) => {
                subtotal += parseFloat(String(i.value).replace(/[^\d.\-]/g, '')) || 0;
            });
            document.getElementById('sumTotal').textContent = fmt(subtotal);
        }

        /* ---------- Editable row tables ---------- */
        function initRowTable(bodyId, addBtnId, name, cols, placeholders, seed, onChange) {
            const body = document.getElementById(bodyId);
            let idx = 0;
            const rowHtml = (d, i) => {
                d = d || {};
                const cells = cols.map((c) => {
                    const cls = 'form-control' + (c.cls ? ' ' + c.cls : '');
                    const listAttr = c.list ? ` list="${c.list}"` : '';
                    return `<td><input type="${c.type || 'text'}"${listAttr} name="${name}[${i}][${c.key}]" class="${cls}" value="${esc(d[c.key])}" placeholder="${esc(placeholders[c.key] || '')}"></td>`;
                }).join('');
                return `<tr>${cells}<td class="li-actions"><button type="button" class="li-del" title="${t.delete}"><i class="bi bi-trash3"></i></button></td></tr>`;
            };
            const add = (d) => { body.insertAdjacentHTML('beforeend', rowHtml(d, idx)); idx++; if (onChange) onChange(); };
            (seed && seed.length ? seed : [{}]).forEach(add);
            document.getElementById(addBtnId).addEventListener('click', () => add());
            body.addEventListener('click', (e) => {
                const del = e.target.closest('.li-del');
                if (del) { e.preventDefault(); if (body.querySelectorAll('tr').length > 1) del.closest('tr').remove(); if (onChange) onChange(); }
            });
            if (onChange) body.addEventListener('input', onChange);
            return { add };
        }

        initRowTable('timelineBody', 'addTimelineBtn', 'timeline',
            [{ key: 'item' }, { key: 'duration' }],
            { item: @json(__('Item')), duration: @json(__('Duration')) },
            @json($timeline));

        initRowTable('costBody', 'addCostBtn', 'costs',
            [{ key: 'item', list: 'stockList' }, { key: 'qty' }, { key: 'price' }, { key: 'total', type: 'text', cls: 'cost-total' }],
            { item: @json(__('Choose or type a product / service')), qty: @json(__('e.g. 10 days')), price: @json(__('e.g. 150 ر.ع / day')), total: @json(__('Number only')) },
            @json($costItems), recalc);

        // Link the product/service column to stock: fill price, auto-fill quantity with the
        // exhibition days, and flag rows whose count exceeds the available stock (soft).
        const stockMap = {};
        @json($stock).forEach((s) => { stockMap[s.name] = s; });
        const evFrom = document.getElementById('eventFrom');
        const evTo = document.getElementById('eventTo');
        const costBody = document.getElementById('costBody');
        const stockWarn = document.getElementById('stockWarn');
        function eventDays() {
            const a = evFrom && evFrom.value ? new Date(evFrom.value) : null;
            const b = evTo && evTo.value ? new Date(evTo.value) : null;
            if (a && b && b >= a) return Math.round((b - a) / 86400000) + 1;
            return 0;
        }
        function checkStock() {
            let over = false;
            costBody.querySelectorAll('input[name$="[item]"]').forEach((itemInp) => {
                const qtyInp = itemInp.closest('tr').querySelector('input[name$="[qty]"]');
                const s = stockMap[itemInp.value.trim()];
                if (s && s.avail > 0) {
                    qtyInp.title = t.avail + ': ' + s.avail;
                    const n = parseFloat(String(qtyInp.value).replace(/[^\d.\-]/g, ''));
                    const bad = n > s.avail;
                    qtyInp.classList.toggle('over-stock', bad);
                    if (bad) over = true;
                } else {
                    qtyInp.classList.remove('over-stock');
                    qtyInp.removeAttribute('title');
                }
            });
            stockWarn.style.display = over ? '' : 'none';
        }
        costBody.addEventListener('input', (e) => {
            const inp = e.target;
            if (inp.name && inp.name.endsWith('[item]')) {
                const s = stockMap[inp.value.trim()];
                if (s) {
                    const row = inp.closest('tr');
                    const qtyInp = row.querySelector('input[name$="[qty]"]');
                    const days = eventDays();
                    if (!qtyInp.value.trim()) qtyInp.value = days > 0 ? days : 1;
                    const qn = parseFloat(String(qtyInp.value).replace(/[^\d.\-]/g, '')) || 1;
                    row.querySelector('input[name$="[price]"]').value = s.price + ' ' + t.currency;
                    row.querySelector('input[name$="[total]"]').value = +(s.price * qn).toFixed(2);
                }
            }
            checkStock();
            recalc();
        });
        // Quantity is date-linked: filling the exhibition dates fills empty quantities with the day count.
        [evFrom, evTo].forEach((el) => el && el.addEventListener('change', () => {
            const days = eventDays();
            if (days > 0) costBody.querySelectorAll('input[name$="[qty]"]').forEach((q) => { if (!q.value.trim()) q.value = days; });
            checkStock();
        }));
        checkStock();

        initRowTable('noticeBody', 'addNoticeBtn', 'notices',
            [{ key: 'title' }, { key: 'body' }],
            { title: @json(__('Title')), body: @json(__('Notice text')) },
            @json($notices));

        recalc();
    })();
</script>
@endpush
