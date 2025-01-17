@extends('layouts.settings.default')
@section('settings_title', trans('lang.commission'))
@section('settings_content')
    @include('partials.session_messages')
    {{-- @include('flash::message')
    @include('adminlte-templates::common.errors') --}}
    <div class="clearfix"></div>
    <div class="card shadow-sm">
        <div class="card-header">
            <ul class="nav nav-tabs d-flex flex-md-row flex-column-reverse align-items-start card-header-tabs">
                <div class="d-flex flex-row">
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i
                                class="fas fa-list mr-2"></i>{{ trans('lang.commission_table') }}</a>
                    </li>
                </div>
                @include('layouts.right_toolbar', compact('dataTable'))
            </ul>
        </div>
        <div class="card-body">
            @include('settings.commissions.table')
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
