@extends('layouts.app')
@push('css_lib')
    <!-- icheck-bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-lite.min.css') }}">
    {{-- dropzone --}}
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/min/dropzone.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{!! trans('lang.user_profile') !!} <small>{{ trans('lang.media_desc') }}</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                                {{ trans('lang.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('lang.user_profile') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @php
        $admin = auth()->user();
    @endphp

    <section class="content">
        <div class="container-fluid">
            @include('partials.session_messages')
            @include('partials.request_errors_first')

            <div class="row">
                <div class="col-md-4">
                    <!-- Profile Image -->
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user mr-2"></i> {{ trans('lang.user_about_me') }}</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img src="{{ $admin->media[0]->image ?? $noneImage }}"
                                    class="profile-user-img img-fluid img-circle" alt="{{ $admin->name }}">
                            </div>
                            <h3 class="profile-username text-center">{{ $admin->full_name }}</h3>
                            <p class="text-muted text-center">{{ trans('lang.admin') }}</p>
                            <a class="btn btn-outline-primary btn-block" href="mailto:{{ $admin->email }}"><i
                                    class="fas fa-envelope mr-2"></i>{{ $admin->email }}
                            </a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body login-card-body">
                            {!! Form::model($admin, ['route' => ['admin.update'], 'method' => 'post', 'files' => true]) !!}
                            <div class="row">
                                <div class="d-flex flex-column col-sm-12 col-md-6">
                                    <!-- Name Field -->
                                    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                        {!! Form::label('full_name', trans('lang.user_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                        <div class="col-md-9">
                                            {!! Form::text('full_name', null, [
                                                'class' => 'form-control',
                                                'placeholder' => trans('lang.user_name_placeholder'),
                                            ]) !!}
                                            <div class="form-text text-muted">
                                                {{ trans('lang.user_name_help') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                        {!! Form::label('email', trans('lang.user_email'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                        <div class="col-md-9">
                                            {!! Form::text('email', null, [
                                                'class' => 'form-control',
                                                'placeholder' => trans('lang.user_email_placeholder'),
                                            ]) !!}
                                            <div class="form-text text-muted">
                                                {{ trans('lang.user_email_help') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column col-sm-12 col-md-6">
                                    <!-- $FIELD_NAME_TITLE$ Field -->
                                    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                        {!! Form::label('image', trans('lang.user_avatar'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                        <div class="col-md-9">
                                            {!! Form::file('image', ['class' => 'form-control-file']) !!}
                                            <div class="form-text text-muted w-50">
                                                {{ trans('lang.user_avatar_help') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-3 mb-0">
                                    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
                                        <i class="fas fa-save"></i> {{ trans('lang.save') }}
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <!-- App Logo -->
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"> {{ trans('lang.upload_app_logo') }}</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img src="{{ $app_logo ?? $noneImage }}"
                                    class="profile-user-img img-fluid img-circle">
                            </div>
                            <form class="pt-3" method="POST" action="{{ route('logo.update') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="input-group mb-3">
                                    <input type="file" name="logo">
                                    @if ($errors->has('logo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('logo') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4 ml-auto">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('lang.save') }}
                                        </button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card-body shadow-sm login-card-body">
                        <p class="login-box-msg">{{ __('lang.update_password') }}</p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="input-group mb-3">
                                <input type="password"
                                    class="form-control  {{ $errors->has('oldPassword') ? ' is-invalid' : '' }}"
                                    name="oldPassword" placeholder="{{ __('auth.password') }}"
                                    aria-label="{{ __('auth.password') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                @if ($errors->has('oldPassword'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('oldPassword') }}
                                    </div>
                                @endif
                            </div>

                            <div class="input-group mb-3">
                                <input type="password"
                                    class="form-control  {{ $errors->has('newPassword') ? ' is-invalid' : '' }}"
                                    name="newPassword" placeholder="{{ __('lang.new_password') }}"
                                    aria-label="{{ __('lang.new_password') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                @if ($errors->has('newPassword'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('newPassword') }}
                                    </div>
                                @endif
                            </div>

                            <div class="input-group mb-3">
                                <input type="password"
                                    class="form-control  {{ $errors->has('newPassword_confirmation') ? ' is-invalid' : '' }}"
                                    name="newPassword_confirmation" placeholder="{{ __('auth.password_confirmation') }}"
                                    aria-label="{{ __('auth.password_confirmation') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                @if ($errors->has('newPassword_confirmation'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('newPassword_confirmation') }}
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-2">
                                <div class="col-4 ml-auto">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('lang.update_password') }}
                                    </button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>

    @include('layouts.media_modal', ['collection' => null])
@endsection

@push('scripts_lib')
    <!-- select2 -->
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/summernote-lite.min.js') }}"></script>
    {{-- dropzone --}}
    <script src="{{ asset('vendor/dropzone/min/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var dropzoneFields = [];
    </script>
@endpush
