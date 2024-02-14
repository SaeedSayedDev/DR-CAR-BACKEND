@extends('layouts.auth.default')
@section('content')

    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('auth.login_title') }}</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('login.store') }}" method="post">
            {!! csrf_field() !!}

            <div class="input-group mb-3">
                <input value="{{ old('email') }}" type="email"
                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    placeholder="{{ __('auth.email') }}" aria-label="{{ __('auth.email') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <input value="{{ old('password') }}" type="password"
                    class="form-control  {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                    placeholder="{{ __('auth.password') }}" aria-label="{{ __('auth.password') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <div class="row mb-2">
                <div class="col-8">
                    <p class="">
                        <a href="{{ url('password/forget') }}">{{ __('auth.forgot_password') }}</a>
                    </p>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('auth.login') }}</button>
                </div>
            </div>

            @if (config('installer.demo_app'))
                <div class="my-4">
                    <div class="col-12 card card-outline card-primary">
                        <div class="card-body">
                            <div class="text-bold">Admin</div>
                            <small>User: admin@demo.com | Password: 123456</small>
                            <div class="text-bold mt-3">Provider</div>
                            <small>User: provider@demo.com | Password: 123456</small>
                            <div class="text-bold mt-3">Customer</div>
                            <small>User: customer@demo.com | Password: 123456</small>
                        </div>
                    </div>
                </div>
            @endif

        </form>

        @if (env('enable_facebook', false) || env('enable_google', false) || env('enable_twitter', false))
            <div class="social-auth-links text-center mb-3">
                <p style="text-transform: uppercase">- {{ __('lang.or') }} -</p>
                @if (env('enable_facebook', false))
                    <a href="{{ url('login/facebook') }}" class="btn btn-block btn-facebook"> <i
                            class="fab fa-facebook mr-2"></i> {{ __('auth.login_facebook') }}
                    </a>
                @endif
                @if (env('enable_google', false))
                    <a href="{{ url('login/google') }}" class="btn btn-block btn-google"> <i
                            class="fab fa-google mr-2"></i> {{ __('auth.login_google') }}
                    </a>
                @endif
                @if (env('enable_twitter', false))
                    <a href="{{ url('login/twitter') }}" class="btn btn-block btn-twitter"> <i
                            class="fab fa-twitter mr-2"></i> {{ __('auth.login_twitter') }}
                    </a>
                @endif
            </div>
            <!-- /.social-auth-links -->
        @endif
    </div>

@endsection
