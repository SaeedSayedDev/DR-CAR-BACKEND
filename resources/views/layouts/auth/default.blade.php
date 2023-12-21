<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DR Car</title>
    <link rel="icon" type="image/png" href=""/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=fallback">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.min.css')}}">
    @stack('js_lib')
</head>
<body class="hold-transition login-page">
<div class="login-box" @if(isset($width)) style="width:{{$width}}" @endif>
    <div class="login-logo">
        <a href="{{ url('/') }}"><img src="" alt=""></a>
    </div>
    <!-- /.login-logo -->
    <div class="card shadow-sm">
        @yield('content')
    </div>
</div>
<!-- /.login-box -->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
@stack('scripts')
</body>
</html>
