@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0 text-bold">{{ trans('lang.withdraw_plural') }} <small
                            class="mx-3">|</small><small>{{ trans('lang.withdraw_desc') }}</small></h1>
                </div><!-- /.col -->
                <div class="col-md-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                    class="fas fa-tachometer-alt mx-1"></i> {{ trans('lang.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{!! route('withdraws.index') !!}">{{ trans('lang.withdraw_plural') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.withdraw_table') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="clearfix"></div>
        {{-- @include('flash::message') --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <ul class="nav nav-tabs d-flex flex-md-row flex-column-reverse align-items-start card-header-tabs">
                    <div class="d-flex flex-row">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('withdraws.index') }}">
                                <i class="fa fa-list mr-2"></i>{{ trans('lang.withdraw_table') }}
                            </a>
                        </li>
                        <form action="{{ route('withdraws.filter') }}" method="POST">
                            @csrf
                            <div class="btn-group" role="group">
                                <button type="submit" name="status" value="pending" class="btn btn-link nav-link active">
                                    <i class="fa fa-filter mr-2 text-info"></i> {{ trans('lang.pending') }}
                                </button>

                                <button type="submit" name="status" value="processing"
                                    class="btn btn-link nav-link active">
                                    <i class="fa fa-filter mr-2 text-warning"></i> {{ trans('lang.processing') }}
                                </button>

                                <button type="submit" name="status" value="paid" class="btn btn-link nav-link active">
                                    <i class="fa fa-filter mr-2 text-success"></i> {{ trans('lang.paid') }}
                                </button>

                                <button type="submit" name="status" value="unpaid" class="btn btn-link nav-link active">
                                    <i class="fa fa-filter mr-2 text-danger"></i> {{ trans('lang.unpaid') }}
                                </button>
                            </div>
                        </form>
                        @can('withdraws.create')
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('withdraws.create') !!}"><i
                                        class="fa fa-plus mr-2"></i>{{ trans('lang.withdraw_create') }}</a>
                            </li>
                        @endcan
                    </div>
                    @include('layouts.right_toolbar', compact('dataTable'))
                </ul>
            </div>
            <div class="card-body">
                @include('withdraws.table')
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection
