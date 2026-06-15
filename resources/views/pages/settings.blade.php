@extends('layouts.app')
@section('title', __('Settings'))

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ __('Settings') }}</h1>
            <p class="subtitle">{{ __('General Settings') }}</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-head"><h2>{{ __('General Settings') }}</h2></div>
            <div class="card-body">
                <form onsubmit="return false">
                    <div class="mb-3">
                        <label class="form-label">{{ __('System Name') }}</label>
                        <input type="text" class="form-control" value="{{ config('app.name') }}">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Language') }}</label>
                            <select class="form-select">
                                <option @selected(app()->getLocale() === 'ar')>{{ __('Arabic') }}</option>
                                <option @selected(app()->getLocale() === 'en')>{{ __('English') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Currency') }}</label>
                            <select class="form-select">
                                <option>SAR — ر.س</option>
                                <option>USD — $</option>
                                <option>AED — د.إ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Timezone') }}</label>
                            <select class="form-select">
                                <option>Asia/Riyadh</option>
                                <option>Asia/Dubai</option>
                                <option>UTC</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn-brand mt-4"><i class="bi bi-check2"></i>{{ __('Save Changes') }}</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-head"><h2>{{ __('Profile Settings') }}</h2></div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <span class="avatar" style="width:72px;height:72px;border-radius:20px;font-size:24px;margin-inline:auto;">SA</span>
                </div>
                <form onsubmit="return false">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Full Name') }}</label>
                        <input type="text" class="form-control" value="Admin">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" value="admin@eventpuls.sa" dir="ltr">
                    </div>
                    <button class="btn-brand mt-2"><i class="bi bi-check2"></i>{{ __('Save Changes') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-head">
            <h2>{{ __('Roles & Users') }}</h2>
            <button class="btn-brand"><i class="bi bi-person-plus"></i>{{ __('Add User') }}</button>
        </div>
        <div class="card-body p-0">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr>
                        <th>{{ __('Name') }}</th><th>{{ __('Email') }}</th><th>{{ __('Role') }}</th>
                        <th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th>
                    </tr></thead>
                    <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar sm">{{ mb_substr($u['name'], 0, 1) }}</span>
                                    <span class="cell-strong">{{ $u['name'] }}</span>
                                </div>
                            </td>
                            <td class="cell-muted" dir="ltr">{{ $u['email'] }}</td>
                            <td>
                                <select class="form-select form-select-sm" style="width:auto;display:inline-block;">
                                    @foreach ($roles as $role)
                                        <option @selected($role === $u['role'])>{{ __($role) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>@include('partials.status', ['status' => $u['status']])</td>
                            <td><div class="row-actions"><a href="#" title="{{ __('Edit') }}"><i class="bi bi-pencil"></i></a><button class="danger" title="{{ __('Delete') }}"><i class="bi bi-trash3"></i></button></div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-head"><h2>{{ __('Finance Settings') }}</h2></div>
        <div class="card-body">
            <form onsubmit="return false" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('Default Currency') }}</label>
                    <select class="form-select">
                        <option>SAR — ر.س</option>
                        <option>USD — $</option>
                        <option>AED — د.إ</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('VAT (%)') }}</label>
                    <input type="number" class="form-control" value="15">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Invoice Prefix') }}</label>
                    <input type="text" class="form-control" value="INV-" dir="ltr">
                </div>
                <div class="col-12">
                    <button class="btn-brand mt-2"><i class="bi bi-check2"></i>{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
