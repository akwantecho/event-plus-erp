@extends('layouts.app')
@section('title', __('Invoice').' '.$invoice['number'])

@php
    $accent = $invoice['accent'] ?: '#173B63';
    $fmt = fn ($v) => number_format((float) $v, ((float) $v == floor((float) $v)) ? 0 : 2).' '.$invoice['currency'];
@endphp

@section('content')
    {{-- Top action bar --}}
    <div class="editor-bar full-bleed">
        <div class="editor-bar-start">
            <a href="{{ $invoice['backUrl'] }}" class="btn-icon" title="{{ __('Close') }}"><i class="bi bi-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i></a>
            <strong>{{ $invoice['number'] }}</strong>
            @include('partials.status', ['status' => $invoice['status']])
        </div>
        <div class="editor-bar-end">
            <a href="{{ route('invoices.edit', $invoice['id']) }}" class="chip"><i class="bi bi-pencil"></i>{{ __('Edit') }}</a>
            <button class="btn-brand" onclick="window.print()"><i class="bi bi-printer"></i>{{ __('Print / Download') }}</button>
        </div>
    </div>

    <div class="qt-canvas full-bleed">
        <div class="qt-doc" style="--accent: {{ $accent }};">

            {{-- ================= PAGE 1 · COVER ================= --}}
            <section class="qt-sheet">
                <div class="qt-blob" style="top:-80px; inset-inline-start:-70px;"></div>
                <div class="qt-blob" style="bottom:120px; inset-inline-end:-90px; width:220px; height:220px;"></div>

                <div class="qt-cover-top">
                    <img src="{{ asset('images/quote-logo.png') }}" alt="{{ $company['name'] }}" class="qt-logo">
                    <div class="qt-cover-no">INVOICE · فاتورة<br>{{ __('No.') }}: {{ $invoice['number'] }}</div>
                </div>
                <div class="qt-cover-tag">
                    منصة متكاملة لإدارة الفعاليات والمؤتمرات
                    <span>An Integrated Platform for Event and Conference Management</span>
                </div>

                <div class="qt-cover-title" style="margin-top:80px;">
                    <h1>فاتورة</h1>
                    <div class="qt-cover-sub" style="letter-spacing:.28em;">INVOICE</div>
                </div>

                <div class="qt-cover-box" style="margin-top:48px;">
                    <div class="qt-cover-cell qt-cell-divider">
                        <div class="qt-cell-label">المشروع</div>
                        <div class="qt-cell-strong">{{ $invoice['projectName'] ?: '—' }}</div>
                    </div>
                    <div class="qt-cover-cell" style="flex:0 0 200px;">
                        <div class="qt-cell-label">نوع الدفعة</div>
                        <div class="qt-cell-strong" style="color:var(--accent);">{{ $invoice['paymentType'] ?: '—' }}</div>
                    </div>
                </div>

                <div class="qt-cover-box">
                    <div class="qt-cover-cell qt-cell-divider">
                        <div class="qt-cell-label">الجهة</div>
                        <div class="qt-cell-strong" style="font-size:16px;">{{ $invoice['entity'] ?: '—' }}</div>
                    </div>
                    <div class="qt-cover-cell qt-cell-divider" style="flex:0 0 150px;">
                        <div class="qt-cell-label">رقم الفاتورة</div>
                        <div class="qt-cell-strong" style="font-size:15px; direction:ltr; text-align:start;">{{ $invoice['number'] }}</div>
                    </div>
                    <div class="qt-cover-cell" style="flex:0 0 150px;">
                        <div class="qt-cell-label">التاريخ</div>
                        <div class="qt-cell-strong" style="font-size:15px; direction:ltr; text-align:start;">{{ $invoice['date'] ?: '—' }}</div>
                    </div>
                </div>

                <div class="qt-spacer"></div>
                @include('pages.partials.quotation-footer', ['company' => $company])
            </section>

            {{-- ================= PAGE 2 · ITEMS + BANK ================= --}}
            <section class="qt-sheet">
                <div class="qt-blob" style="top:-70px; inset-inline-end:-80px; width:220px; height:220px;"></div>

                <div class="qt-sec-head">
                    <div class="qt-sec-eyebrow">{{ $invoice['paymentType'] ? 'ITEMS · '.$invoice['paymentType'] : 'ITEMS' }}</div>
                    <h2>البنود</h2>
                </div>

                <div class="qt-tbl">
                    <div class="qt-tr qt-thead">
                        <div class="qt-td qt-flex1">البند <span class="qt-en">ITEM</span></div>
                        <div class="qt-td" style="flex:0 0 220px;">السعر <span class="qt-en">PRICE</span></div>
                    </div>
                    @foreach ($invoice['items'] as $i => $row)
                        <div class="qt-tr {{ $i % 2 ? 'qt-alt' : '' }}">
                            <div class="qt-td qt-flex1 qt-strong">{{ $row['name'] }}</div>
                            <div class="qt-td qt-strong" style="flex:0 0 220px; direction:ltr;">{{ $fmt($row['total']) }}</div>
                        </div>
                    @endforeach
                    <div class="qt-tr qt-grand">
                        <div class="qt-td qt-flex1">المبلغ الاجمالي</div>
                        <div class="qt-td" style="flex:0 0 220px; direction:ltr;">{{ $fmt($invoice['grandTotal']) }}</div>
                    </div>
                </div>

                {{-- Bank details --}}
                <div style="margin-top:34px; position:relative;">
                    <div class="qt-sec-head" style="border-inline-start-width:4px; margin-bottom:14px;">
                        <h2 style="font-size:20px;">بيانات الحساب البنكي</h2>
                        <div class="qt-sec-eyebrow" style="margin-top:4px; margin-bottom:0;">BANK ACCOUNT DETAILS</div>
                    </div>
                    <div class="qt-bank">
                        <div class="qt-bank-cell qt-cell-divider">
                            <div class="qt-cell-label">اسم البنك</div>
                            <div class="qt-bank-val">{{ $company['bank_name'] }}</div>
                        </div>
                        <div class="qt-bank-cell qt-cell-divider" style="flex:1.4;">
                            <div class="qt-cell-label">اسم الحساب البنكي</div>
                            <div class="qt-bank-val">{{ $company['bank_account_name'] }}</div>
                        </div>
                        <div class="qt-bank-cell" style="flex:1.2;">
                            <div class="qt-cell-label">رقم الحساب البنكي</div>
                            <div class="qt-bank-val" style="direction:ltr; text-align:start;">{{ $company['bank_account_no'] }}</div>
                        </div>
                    </div>
                </div>

                {{-- Stamp + signature --}}
                <div class="qt-sign">
                    <img src="{{ asset('images/quote-stamp.png') }}" alt="{{ __('Company Stamp') }}" class="qt-sign-stamp">
                    <img src="{{ asset('images/invoice-signature.png') }}" alt="{{ __('Signature') }}" class="qt-sign-sig">
                </div>

                <div class="qt-spacer"></div>
                @include('pages.partials.quotation-footer', ['company' => $company])
            </section>

        </div>
    </div>
@endsection

@push('scripts')
<style>
    .qt-canvas{background:#e7e9ec;padding:34px 0 50px;overflow-x:auto;}
    .qt-doc{direction:rtl;}
    .qt-sheet{position:relative;overflow:hidden;width:794px;min-height:1123px;background:#fff;margin:0 auto 34px;padding:66px 68px 52px;box-shadow:0 2px 8px rgba(0,0,0,.06);display:flex;flex-direction:column;font-family:'IBM Plex Sans Arabic',sans-serif;color:#1F2937;}
    .qt-spacer{flex:1;}
    .qt-blob{position:absolute;width:260px;height:260px;background:var(--accent);opacity:.035;transform:rotate(45deg);pointer-events:none;}

    .qt-cover-top{display:flex;justify-content:space-between;align-items:flex-start;position:relative;}
    .qt-logo{height:52px;width:auto;display:block;}
    .qt-cover-no{text-align:start;font:500 11px/1.7 'Inter';letter-spacing:.16em;color:#9AA6B2;direction:ltr;}
    .qt-cover-tag{margin-top:14px;font:400 12.5px/1.7 'IBM Plex Sans Arabic';color:#5B6672;text-align:start;position:relative;}
    .qt-cover-tag span{display:block;font:400 11px 'Inter';color:#9AA6B2;direction:ltr;text-align:start;}
    .qt-cover-title{text-align:center;position:relative;}
    .qt-cover-title h1{margin:0;font:800 56px/1.14 'IBM Plex Sans Arabic';color:#1F2937;letter-spacing:-.01em;}
    .qt-cover-sub{margin-top:12px;font:500 16px 'Inter';color:#8A95A1;direction:ltr;}
    .qt-cover-box{margin-top:24px;background:#F6F7F9;border:1px solid #D9DDE5;border-radius:16px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,.05);display:flex;gap:24px;position:relative;}
    .qt-cover-cell{flex:1;}
    .qt-cell-divider{border-inline-start:1px solid #D9DDE5;padding-inline-start:24px;}
    .qt-cell-label{font:500 10px 'IBM Plex Sans Arabic';letter-spacing:.1em;color:#8A95A1;margin-bottom:8px;}
    .qt-cell-strong{font:700 18px/1.4 'IBM Plex Sans Arabic';color:#1F2937;}

    .qt-sec-head{border-inline-start:4px solid var(--accent);padding-inline-start:18px;text-align:start;margin-bottom:18px;}
    .qt-sec-eyebrow{font:600 11px 'Inter';letter-spacing:.26em;color:#9AA6B2;margin-bottom:10px;direction:ltr;text-align:start;}
    .qt-sec-head h2{margin:0;font:800 30px/1.2 'IBM Plex Sans Arabic';color:#1F2937;}

    .qt-tbl{border:1px solid #D9DDE5;border-radius:4px;overflow:hidden;}
    .qt-tr{display:flex;align-items:center;background:#fff;min-height:48px;}
    .qt-tr.qt-alt{background:#F5F6F8;}
    .qt-thead{background:var(--accent);min-height:auto;}
    .qt-thead .qt-td{color:#fff;font:700 13px 'IBM Plex Sans Arabic';padding:14px 18px;text-align:center;}
    .qt-thead .qt-td + .qt-td{border-inline-start:1px solid rgba(255,255,255,.15);}
    .qt-en{font:500 10px 'Inter';letter-spacing:.1em;opacity:.7;margin-inline-start:8px;}
    .qt-td{padding:11px 18px;text-align:center;font-size:13px;}
    .qt-flex1{flex:1;}
    .qt-td + .qt-td{border-inline-start:1px solid #D9DDE5;}
    .qt-strong{font-weight:600;color:#1F2937;}
    .qt-grand{background:var(--accent);min-height:58px;}
    .qt-grand .qt-td{color:#fff;}
    .qt-grand .qt-flex1{font:800 16px 'IBM Plex Sans Arabic';}
    .qt-grand .qt-td:last-child{font:800 20px 'IBM Plex Sans Arabic';border-inline-start:1px solid rgba(255,255,255,.15);}

    .qt-bank{background:#F6F7F9;border:1px solid #D9DDE5;border-radius:16px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,.05);display:flex;gap:24px;}
    .qt-bank-cell{flex:1;}
    .qt-bank-val{font:700 15px/1.4 'IBM Plex Sans Arabic';color:#1F2937;}

    .qt-sign{flex:1;position:relative;min-height:170px;}
    .qt-sign-stamp{position:absolute;inset-inline-start:0;top:56px;width:160px;height:auto;display:block;}
    .qt-sign-sig{position:absolute;inset-inline-start:150px;top:24px;width:150px;height:auto;display:block;}

    .qt-foot{display:flex;border-top:1px solid #D9DDE5;padding-top:20px;position:relative;}
    .qt-foot-col{flex:1;text-align:start;padding:0 18px;}
    .qt-foot-col:not(:last-child){border-inline-start:1px solid #EEF0F2;}
    .qt-foot-eyebrow{font:500 9px 'Inter';letter-spacing:.12em;color:#9AA6B2;margin-bottom:6px;direction:ltr;text-align:start;}
    .qt-foot-val{font:600 12px 'Inter';color:#1F2937;direction:ltr;text-align:start;}
    .qt-foot-val.ar{font-family:'IBM Plex Sans Arabic';direction:rtl;}
    .qt-foot-sub{font:500 10px 'IBM Plex Sans Arabic';color:#8A95A1;}
    .qt-ribbon{margin-top:18px;display:flex;gap:6px;align-items:center;}
    .qt-ribbon .r1{height:4px;flex:1;background:var(--accent);border-radius:4px;}
    .qt-ribbon .r2{width:8px;height:8px;background:var(--accent);transform:rotate(45deg);}
    .qt-ribbon .r3{height:4px;width:60px;background:#D9DDE5;border-radius:4px;}

    @media (max-width:860px){ .qt-canvas{padding:16px 0;} }

    @media print {
        .sidebar, .topbar, .editor-bar, .sidebar-backdrop, .flash { display:none !important; }
        .layout, .main, .content { display:block !important; margin:0 !important; padding:0 !important; background:#fff !important; }
        .qt-canvas { background:#fff !important; padding:0 !important; overflow:visible !important; }
        .qt-sheet { box-shadow:none !important; margin:0 auto !important; break-after:page; }
        .qt-sheet:last-of-type { break-after:auto; }
        @page { size:A4; margin:0; }
        * { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    }
</style>
@endpush
