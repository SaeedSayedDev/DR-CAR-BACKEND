@extends('layouts.app')
@push('css_lib')
    <link rel="stylesheet" href="{{asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/dropzone/min/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0 text-bold">{{trans('lang.price_plural')}} <small class="mx-3">|</small><small>{{trans('lang.price_desc')}}</small></h1>
                </div><!-- /.col -->
                <div class="col-md-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fas fa-tachometer-alt mx-1"></i> {{trans('lang.dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{!! route('prices.index') !!}">{{trans('lang.price_plural')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{trans('lang.price_create')}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="clearfix"></div>
        {{-- @include('flash::message')
        @include('adminlte-templates::common.errors') --}}
        <div class="clearfix"></div>
        <div class="card shadow-sm">
            <div class="card-header">
                <ul class="nav nav-tabs d-flex flex-row align-items-start card-header-tabs">
                    @can('prices.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('prices.index') !!}"><i class="fas fa-list mr-2"></i>{{trans('lang.price_table')}}</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fas fa-plus mr-2"></i>{{trans('lang.price_create')}}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'prices.store', 'files' => true]) !!}
                <div class="row">
                    @include('prices.fields')
                </div>
                {!! Form::close() !!}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('layouts.media_modal')
@endsection
@push('scripts_lib')
    <script src="{{asset('vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('vendor/dropzone/min/dropzone.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
    <script type="text/javascript">
        $(".colorpicker-component, input[name$='color']").colorpicker({
            format: 'hex',
        });
        $('.colorpicker-component').on('colorpickerChange', function (event) {
            $(this).find('.fa-square').css('color', event.color.toString());
        });
        Dropzone.autoDiscover = false;
        var dropzoneFields = [];
    </script>
@endpush
