@extends('layouts.app')
@section('title', __('Quotation').' '.$quotation['number'])

@php
    $accent = $quotation['accent'] ?: '#173B63';
    // Format a numeric money value the way the approved quote does (integers, grouped).
    $fmt = fn ($v) => number_format((float) $v, ((float) $v == floor((float) $v)) ? 0 : 2).' '.$quotation['currency'];
@endphp

@section('content')
    {{-- Top action bar --}}
    <div class="editor-bar full-bleed">
        <div class="editor-bar-start">
            <a href="{{ $quotation['backUrl'] }}" class="btn-icon" title="{{ __('Close') }}"><i class="bi bi-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i></a>
            <strong>{{ $quotation['number'] }}</strong>
            @include('partials.status', ['status' => $quotation['status']])
        </div>
        <div class="editor-bar-end">
            @php $st = $quotation['status']; @endphp
            @if ($st !== 'Approved' && $st !== 'Rejected')
                @if ($st === 'Draft')
                    <form method="POST" action="{{ route('quotations.send', $quotation['id']) }}" style="display:inline">@csrf
                        <button type="submit" class="chip"><i class="bi bi-send"></i>{{ __('Mark as Sent') }}</button>
                    </form>
                @endif
                <button type="button" class="btn-brand" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="bi bi-patch-check"></i>{{ __('Approve') }}</button>
                <form method="POST" action="{{ route('quotations.reject', $quotation['id']) }}" style="display:inline" onsubmit="return confirm('{{ __('Reject this quotation?') }}')">@csrf
                    <button type="submit" class="chip"><i class="bi bi-x-octagon"></i>{{ __('Reject') }}</button>
                </form>
            @endif
            <a href="{{ route('quotations.edit', $quotation['id']) }}" class="chip"><i class="bi bi-pencil"></i>{{ __('Edit') }}</a>
            <button class="chip" onclick="window.print()"><i class="bi bi-printer"></i>{{ __('Print / Download') }}</button>
        </div>
    </div>

    {{-- Approved summary: payment plan + link to generated invoices --}}
    @if ($st === 'Approved')
        <div class="full-bleed" style="padding:0 0 4px;">
            <div class="qt-approved">
                <div class="qt-approved-head">
                    <span><i class="bi bi-patch-check-fill"></i> {{ __('Approved — payment plan') }}</span>
                    @if ($quotation['entityUrl'])
                        <a href="{{ $quotation['entityUrl'] }}" class="chip"><i class="bi bi-receipt"></i>{{ __('View generated invoices') }} <span class="badge-soft gray">{{ $quotation['invoicesCount'] }}</span></a>
                    @endif
                </div>
                <div class="qt-plan-rows">
                    @foreach ($quotation['installments'] as $inst)
                        <div class="qt-plan-row">
                            <span class="qt-plan-label">{{ $inst['label'] ?: __('Payment') }}</span>
                            <span class="qt-plan-pct">{{ rtrim(rtrim(number_format($inst['percent'], 2, '.', ''), '0'), '.') }}%</span>
                            <span class="qt-plan-amt">{{ number_format($inst['amount'], (($inst['amount'] == floor($inst['amount'])) ? 0 : 2)) }} {{ $quotation['currency'] }}</span>
                            <span class="qt-plan-due">{{ $inst['due'] ? __('Due').': '.$inst['due'] : '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="qt-canvas full-bleed">
        <div class="qt-doc" style="--accent: {{ $accent }};">

            {{-- ================= PAGE 1 · COVER ================= --}}
            <section class="qt-sheet">
                <div class="qt-blob" style="top:-80px; inset-inline-start:-70px;"></div>
                <div class="qt-blob" style="bottom:120px; inset-inline-end:-90px; width:220px; height:220px;"></div>

                <div class="qt-cover-top">
                    <img src="{{ asset('images/quote-logo.png') }}" alt="{{ $company['name'] }}" class="qt-logo">
                    <div class="qt-cover-no">QUOTATION · عرض سعر<br>{{ __('No.') }}: {{ $quotation['number'] }}</div>
                </div>
                <div class="qt-cover-tag">
                    منصة متكاملة لإدارة الفعاليات والمؤتمرات
                    <span>An Integrated Platform for Event and Conference Management</span>
                </div>

                <div class="qt-cover-title">
                    <h1>عرض سعر رسمي<br><span>{{ $company['name'] }}</span></h1>
                    <div class="qt-cover-sub">Official Quotation</div>
                    @if ($quotation['projectName'])
                        <div class="qt-cover-pill"><span>{{ $quotation['projectName'] }}</span></div>
                    @endif
                </div>

                <div class="qt-cover-box">
                    <div class="qt-cover-cell qt-cell-divider">
                        <div class="qt-cell-label">المشروع</div>
                        <div class="qt-cell-strong">{{ $quotation['projectName'] ?: ($quotation['exhibition'] ?: '—') }}</div>
                    </div>
                    <div class="qt-cover-cell" style="flex:0 0 190px;">
                        <div class="qt-cell-label">تاريخ المعرض</div>
                        <div class="qt-cell-strong" style="direction:ltr; text-align:start;">{{ $quotation['eventRange'] ?: '—' }}</div>
                    </div>
                </div>

                <div class="qt-cover-box">
                    <div class="qt-cover-cell qt-cell-divider">
                        <div class="qt-cell-label">المرسل إلى</div>
                        <div class="qt-cell-strong">{{ $quotation['recipient'] ?: '—' }}</div>
                    </div>
                    <div class="qt-cover-cell">
                        <div class="qt-cell-label">المرسل من قبل</div>
                        <div class="qt-cell-strong">{{ $company['name'] }}</div>
                    </div>
                </div>

                <div class="qt-spacer"></div>
                @include('pages.partials.quotation-footer', ['company' => $company])
            </section>

            {{-- ================= PAGE 2 · TIMELINE + COSTS ================= --}}
            @if (count($quotation['timeline']) || count($quotation['items']))
            <section class="qt-sheet">
                <div class="qt-blob" style="top:-70px; inset-inline-end:-80px; width:220px; height:220px;"></div>

                @if (count($quotation['timeline']))
                    <div class="qt-sec-head">
                        <div class="qt-sec-eyebrow">01 · TIMELINE</div>
                        <h2>الوقت</h2>
                    </div>
                    <div class="qt-tbl">
                        <div class="qt-tr qt-thead">
                            <div class="qt-td qt-flex1">البند</div>
                            <div class="qt-td" style="flex:0 0 240px;">الوقت</div>
                        </div>
                        @foreach ($quotation['timeline'] as $i => $row)
                            <div class="qt-tr {{ $i % 2 ? 'qt-alt' : '' }}">
                                <div class="qt-td qt-flex1 qt-strong">{{ $row['item'] }}</div>
                                <div class="qt-td qt-muted" style="flex:0 0 240px;">{{ $row['duration'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (count($quotation['items']))
                    <div class="qt-sec-head" style="margin-top:36px;">
                        <div class="qt-sec-eyebrow">02 · COSTS</div>
                        <h2>التكاليف</h2>
                    </div>
                    <div class="qt-tbl">
                        <div class="qt-tr qt-thead">
                            <div class="qt-td qt-flex1">البند</div>
                            <div class="qt-td" style="flex:0 0 92px;">الكمية / العدد</div>
                            <div class="qt-td" style="flex:0 0 168px;">السعر</div>
                            <div class="qt-td" style="flex:0 0 120px;">الإجمالي</div>
                        </div>
                        @foreach ($quotation['items'] as $i => $row)
                            <div class="qt-tr {{ $i % 2 ? 'qt-alt' : '' }}">
                                <div class="qt-td qt-flex1 qt-strong">{{ $row['item'] }}</div>
                                <div class="qt-td qt-muted" style="flex:0 0 92px;">{{ $row['qty'] }}</div>
                                <div class="qt-td qt-muted" style="flex:0 0 168px;">{{ $row['price'] }}</div>
                                <div class="qt-td qt-strong" style="flex:0 0 120px; direction:ltr;">{{ $fmt($row['total']) }}</div>
                            </div>
                        @endforeach
                        <div class="qt-tr qt-grand">
                            <div class="qt-td qt-flex1">الإجمالي الكلي</div>
                            <div class="qt-td" style="flex:0 0 288px; direction:ltr;">{{ $fmt($quotation['grandTotal']) }}</div>
                        </div>
                    </div>
                @endif

                <div class="qt-spacer"></div>
                <div class="qt-ribbon" aria-hidden="true"><span class="r1"></span><span class="r2"></span><span class="r3"></span></div>
            </section>
            @endif

            {{-- ================= PAGE 3 · NOTICES ================= --}}
            @if (count($quotation['notices']))
            <section class="qt-sheet">
                <div class="qt-blob" style="bottom:90px; inset-inline-start:-80px; width:240px; height:240px;"></div>

                <div class="qt-sec-head">
                    <div class="qt-sec-eyebrow">NOTICE</div>
                    <h2 style="font-size:34px;">تنويه</h2>
                </div>

                <div class="qt-notices">
                    @foreach ($quotation['notices'] as $n)
                        <div class="qt-notice">
                            <span class="qt-check">✓</span>
                            <p>@if (!empty($n['title']))<strong>{{ $n['title'] }}:</strong> @endif{{ $n['body'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="qt-stamp">
                    <img src="{{ asset('images/quote-stamp.png') }}" alt="{{ __('Company Stamp') }}">
                </div>

                <div class="qt-spacer"></div>
                @include('pages.partials.quotation-footer', ['company' => $company])
            </section>
            @endif

        </div>
    </div>

    {{-- Approve: payment plan builder --}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border:1px solid var(--line);border-radius:16px;">
                <form method="POST" action="{{ route('quotations.approve', $quotation['id']) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-size:16px;font-weight:700;">{{ __('Approve & set payment plan') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <p class="cell-muted" style="font-size:13px;margin-top:0;">{{ __('On approval the work is confirmed and one invoice is created per payment.') }}</p>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Number of payments') }}</label>
                            <div class="seg" id="payCountSeg">
                                <button type="button" data-n="1" class="active">1</button>
                                <button type="button" data-n="2">2</button>
                                <button type="button" data-n="3">3</button>
                            </div>
                        </div>
                        <div class="table-wrap">
                            <table class="doc-sec-table" style="width:100%">
                                <thead><tr>
                                    <th>{{ __('Payment') }}</th>
                                    <th style="width:84px">%</th>
                                    <th style="width:150px">{{ __('Due Date') }}</th>
                                    <th style="width:120px">{{ __('Amount') }}</th>
                                </tr></thead>
                                <tbody id="payRows"></tbody>
                                <tfoot><tr class="doc-sec-grand">
                                    <td>{{ __('Total') }}</td>
                                    <td id="paySumPct">0%</td>
                                    <td></td>
                                    <td id="paySumAmt">0</td>
                                </tr></tfoot>
                            </table>
                        </div>
                        <div class="text-danger small mt-2 is-hidden" id="payErr">{{ __('Percentages must total 100%.') }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="chip" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn-brand" id="payApproveBtn"><i class="bi bi-check2"></i>{{ __('Approve & generate invoices') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    .qt-canvas{background:#e7e9ec;padding:34px 0 50px;overflow-x:auto;}
    .qt-doc{direction:rtl;}
    .qt-sheet{position:relative;overflow:hidden;width:794px;min-height:1123px;background:#fff;margin:0 auto 34px;padding:66px 68px 52px;box-shadow:0 2px 8px rgba(0,0,0,.06);display:flex;flex-direction:column;
        font-family:'IBM Plex Sans Arabic',sans-serif;color:#1F2937;}
    .qt-spacer{flex:1;}
    .qt-blob{position:absolute;width:260px;height:260px;background:var(--accent);opacity:.035;transform:rotate(45deg);pointer-events:none;}

    /* Cover */
    .qt-cover-top{display:flex;justify-content:space-between;align-items:flex-start;position:relative;}
    .qt-logo{height:52px;width:auto;display:block;}
    .qt-cover-no{text-align:start;font:500 11px/1.7 'Inter';letter-spacing:.16em;color:#9AA6B2;direction:ltr;}
    .qt-cover-tag{margin-top:14px;font:400 12.5px/1.7 'IBM Plex Sans Arabic';color:#5B6672;text-align:start;position:relative;}
    .qt-cover-tag span{display:block;font:400 11px 'Inter';color:#9AA6B2;direction:ltr;text-align:start;}
    .qt-cover-title{margin-top:80px;text-align:center;position:relative;}
    .qt-cover-title h1{margin:0;font:800 52px/1.16 'IBM Plex Sans Arabic';color:#1F2937;letter-spacing:-.01em;}
    .qt-cover-title h1 span{color:var(--accent);}
    .qt-cover-sub{margin-top:18px;font:500 16px 'Inter';letter-spacing:.04em;color:#8A95A1;direction:ltr;}
    .qt-cover-pill{margin-top:20px;}
    .qt-cover-pill span{display:inline-block;font:600 12px 'IBM Plex Sans Arabic';color:#fff;background:var(--accent);padding:8px 18px;border-radius:999px;}
    .qt-cover-box{margin-top:24px;background:#F6F7F9;border:1px solid #D9DDE5;border-radius:16px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,.05);display:flex;gap:24px;position:relative;}
    .qt-cover-box:first-of-type{margin-top:48px;}
    .qt-cover-cell{flex:1;}
    .qt-cell-divider{border-inline-start:1px solid #D9DDE5;padding-inline-start:24px;}
    .qt-cell-label{font:500 10px 'IBM Plex Sans Arabic';letter-spacing:.1em;color:#8A95A1;margin-bottom:8px;}
    .qt-cell-strong{font:700 18px/1.4 'IBM Plex Sans Arabic';color:#1F2937;}

    /* Section heads */
    .qt-sec-head{border-inline-start:4px solid var(--accent);padding-inline-start:18px;text-align:start;margin-bottom:18px;}
    .qt-sec-eyebrow{font:600 11px 'Inter';letter-spacing:.26em;color:#9AA6B2;margin-bottom:10px;direction:ltr;text-align:start;}
    .qt-sec-head h2{margin:0;font:800 28px/1.2 'IBM Plex Sans Arabic';color:#1F2937;}

    /* Tables (flex rows to mirror the source) */
    .qt-tbl{border:1px solid #D9DDE5;border-radius:4px;overflow:hidden;}
    .qt-tr{display:flex;align-items:center;background:#fff;min-height:46px;}
    .qt-tr.qt-alt{background:#F5F6F8;}
    .qt-thead{background:var(--accent);min-height:auto;}
    .qt-thead .qt-td{color:#fff;font:700 12.5px 'IBM Plex Sans Arabic';padding:14px 12px;text-align:center;}
    .qt-thead .qt-td + .qt-td{border-inline-start:1px solid rgba(255,255,255,.15);}
    .qt-td{padding:11px 12px;text-align:center;font-size:12.5px;}
    .qt-flex1{flex:1;}
    .qt-td + .qt-td{border-inline-start:1px solid #D9DDE5;}
    .qt-strong{font-weight:600;color:#1F2937;}
    .qt-muted{color:#5B6672;font-weight:400;}
    .qt-grand{background:var(--accent);min-height:58px;}
    .qt-grand .qt-td{color:#fff;}
    .qt-grand .qt-flex1{font:800 16px 'IBM Plex Sans Arabic';}
    .qt-grand .qt-td:last-child{font:800 20px 'IBM Plex Sans Arabic';border-inline-start:1px solid rgba(255,255,255,.15);}

    /* Notices */
    .qt-notices{display:flex;flex-direction:column;gap:14px;margin-top:16px;}
    .qt-notice{display:flex;gap:14px;align-items:flex-start;}
    .qt-check{flex:0 0 auto;width:22px;height:22px;margin-top:2px;border-radius:999px;background:#eef2f6;border:1px solid #dde5ec;color:var(--accent);display:flex;align-items:center;justify-content:center;font:700 12px 'Inter';}
    .qt-notice p{margin:0;font:400 13.5px/1.7 'IBM Plex Sans Arabic';color:#1F2937;text-align:justify;}
    .qt-notice p strong{color:var(--accent);}
    .qt-stamp{margin-top:34px;display:flex;justify-content:flex-start;}
    .qt-stamp img{width:220px;height:auto;display:block;}

    /* Footer + ribbon */
    .qt-foot{display:flex;border-top:1px solid #D9DDE5;padding-top:20px;position:relative;}
    .qt-foot-col{flex:1;text-align:start;padding:0 18px;}
    .qt-foot-col + .qt-foot-col{}
    .qt-foot-col:not(:last-child){border-inline-start:1px solid #EEF0F2;}
    .qt-foot-eyebrow{font:500 9px 'Inter';letter-spacing:.12em;color:#9AA6B2;margin-bottom:6px;direction:ltr;text-align:start;}
    .qt-foot-val{font:600 12px 'Inter';color:#1F2937;direction:ltr;text-align:start;}
    .qt-foot-val.ar{font-family:'IBM Plex Sans Arabic';direction:rtl;}
    .qt-foot-sub{font:500 10px 'IBM Plex Sans Arabic';color:#8A95A1;}
    .qt-ribbon{margin-top:18px;display:flex;gap:6px;align-items:center;}
    .qt-ribbon .r1{height:4px;flex:1;background:var(--accent);border-radius:4px;}
    .qt-ribbon .r2{width:8px;height:8px;background:var(--accent);transform:rotate(45deg);}
    .qt-ribbon .r3{height:4px;width:60px;background:#D9DDE5;border-radius:4px;}

    /* Approved banner */
    .qt-approved{margin:10px 16px 0;background:var(--panel,#fff);border:1px solid var(--line);border-inline-start:4px solid #1e9e6a;border-radius:12px;padding:14px 16px;}
    .qt-approved-head{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:10px;font-weight:700;color:#1e9e6a;}
    .qt-plan-rows{display:flex;flex-direction:column;gap:6px;}
    .qt-plan-row{display:grid;grid-template-columns:1fr 70px 140px 1fr;gap:12px;align-items:center;padding:8px 10px;border:1px solid var(--line);border-radius:8px;font-size:13px;}
    .qt-plan-label{font-weight:600;color:var(--ink,#1f2a37);}
    .qt-plan-pct{color:var(--muted);}
    .qt-plan-amt{font-weight:700;direction:ltr;text-align:start;}
    .qt-plan-due{color:var(--muted);font-size:12px;text-align:end;}
    #payCountSeg{display:inline-flex;gap:4px;}
    #payCountSeg button{min-width:52px;}

    @media (max-width:860px){ .qt-canvas{padding:16px 0;} .qt-plan-row{grid-template-columns:1fr 1fr;} }

    @media print {
        .sidebar, .topbar, .editor-bar, .sidebar-backdrop, .flash, .qt-approved, .modal { display:none !important; }
        .layout, .main, .content { display:block !important; margin:0 !important; padding:0 !important; background:#fff !important; }
        .qt-canvas { background:#fff !important; padding:0 !important; overflow:visible !important; }
        .qt-sheet { box-shadow:none !important; margin:0 auto !important; break-after:page; }
        .qt-sheet:last-of-type { break-after:auto; }
        @page { size:A4; margin:0; }
        * { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    }
</style>
<script>
    (function () {
        const modal = document.getElementById('approveModal');
        if (!modal) return;
        const total = {{ $quotation['grandTotal'] }};
        const cur = @json($quotation['currency']);
        const presets = {
            1: [['الدفعة كاملة', 100]],
            2: [['الدفعة الأولى', 50], ['الدفعة الثانية', 50]],
            3: [['الدفعة الأولى', 40], ['الدفعة الثانية', 30], ['الدفعة الثالثة', 30]],
        };
        const rowsBody = modal.querySelector('#payRows');
        const seg = modal.querySelector('#payCountSeg');
        const sumPct = modal.querySelector('#paySumPct');
        const sumAmt = modal.querySelector('#paySumAmt');
        const err = modal.querySelector('#payErr');
        const approveBtn = modal.querySelector('#payApproveBtn');
        const fmt = (n) => n.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });

        function rowHtml(i, label, pct) {
            return `<tr>
                <td><input type="text" name="installments[${i}][label]" class="form-control" value="${label}"></td>
                <td><input type="number" min="0" max="100" step="0.01" name="installments[${i}][percent]" class="form-control pay-pct" value="${pct}"></td>
                <td><input type="date" name="installments[${i}][due_date]" class="form-control"></td>
                <td class="pay-amt" style="direction:ltr;text-align:start;font-weight:700;">—</td>
            </tr>`;
        }
        function build(n) {
            rowsBody.innerHTML = presets[n].map((p, i) => rowHtml(i, p[0], p[1])).join('');
            recalc();
        }
        function recalc() {
            let sp = 0;
            rowsBody.querySelectorAll('tr').forEach((tr) => {
                const pct = parseFloat(tr.querySelector('.pay-pct').value) || 0;
                sp += pct;
                tr.querySelector('.pay-amt').textContent = fmt(total * pct / 100) + ' ' + cur;
            });
            sumPct.textContent = (Math.round(sp * 100) / 100) + '%';
            sumAmt.textContent = fmt(total * sp / 100) + ' ' + cur;
            const ok = Math.abs(sp - 100) < 0.01;
            err.classList.toggle('is-hidden', ok);
            approveBtn.disabled = !ok;
        }
        seg.addEventListener('click', (e) => {
            const b = e.target.closest('button[data-n]');
            if (!b) return;
            seg.querySelectorAll('button').forEach(x => x.classList.toggle('active', x === b));
            build(+b.dataset.n);
        });
        rowsBody.addEventListener('input', (e) => { if (e.target.classList.contains('pay-pct')) recalc(); });
        build(1);
    })();
</script>
@endpush
