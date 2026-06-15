@extends('layouts.app')
@section('title', __('Tasks'))

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ __('Tasks') }}</h1>
            <p class="subtitle">{{ count($tasks) }} {{ __('Tasks') }}</p>
        </div>
        <button class="btn-brand"><i class="bi bi-plus-lg"></i>{{ __('Add Task') }}</button>
    </div>

    <div class="chip-row">
        <button class="chip"><i class="bi bi-search"></i>{{ __('Search...') }}</button>
        <button class="chip"><i class="bi bi-person"></i>{{ __('Assignee') }}<i class="bi bi-chevron-down"></i></button>
        <button class="chip"><i class="bi bi-flag"></i>{{ __('Priority') }}<i class="bi bi-chevron-down"></i></button>
        <button class="chip"><i class="bi bi-funnel"></i>{{ __('Status') }}<i class="bi bi-chevron-down"></i></button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                    <tr>
                        <th style="width:36px"><input type="checkbox" class="checkbox"></th>
                        <th>{{ __('Task') }}</th>
                        <th>{{ __('Exhibition') }}</th>
                        <th>{{ __('Assignee') }}</th>
                        <th>{{ __('Due Date') }}</th>
                        <th>{{ __('Priority') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $t)
                        <tr>
                            <td><input type="checkbox" class="checkbox"></td>
                            <td class="cell-strong">{{ $t['title'] }}</td>
                            <td class="cell-muted">{{ $t['exhibition'] }}</td>
                            <td class="cell-muted">{{ $t['assignee'] }}</td>
                            <td class="cell-muted">{{ $t['due'] }}</td>
                            <td>@include('partials.priority', ['priority' => $t['priority']])</td>
                            <td>@include('partials.status', ['status' => $t['status']])</td>
                            <td>
                                <div class="row-actions">
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
