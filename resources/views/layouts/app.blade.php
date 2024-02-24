<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@php
    $logo = App\Models\Media::appLogo()->imageName();
@endphp

<head>
    <meta charset="UTF-8">
    <title>Dr Car | Manage Mobile Application</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" type="image/png" href="{{  $app_logo ?? asset('storage/images/app/' . $logo)  }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    @stack('css_lib')
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/primary.css') }}">
    @yield('css_custom')
</head>

<body
    class="{{ LaravelLocalization::getCurrentLocaleDirection() }} layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-mini primary light-mode"
    data-scrollbar-auto-hide="l" data-scrollbar-theme="os-theme-dark">

    @php
        $admin = auth()->user();
    @endphp
    
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-dark navbar-navy border-bottom-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('dashboard') }}" class="nav-link">{{ trans('lang.dashboard') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @if (env('APP_CONSTRUCTION', false))
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#"><i class="fas fa-info-circle"></i>
                            {{ env('APP_CONSTRUCTION', '') }}</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}"
                        href="{!! route('dashboard') !!}"><i class="fas fa-bell"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fas fa-angle-down"></i>
                        {!! Str::upper(LaravelLocalization::getCurrentLocale()) !!}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                class="dropdown-item {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'active' : '' }}"
                                rel="alternate" hreflang="{{ $localeCode }}">
                                <i class="fas fa-circle mr-2"></i> {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="{{ asset('storage/images/accounts/' . $admin->media()->first()?->imageName()) }}"
                            class="brand-image mx-2 img-circle elevation-2" alt="User Image">
                        <i class="fa fas fa-angle-down"></i> {{ auth()->user()->full_name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('users.profile') }}" class="dropdown-item"> <i class="fas fa-user mr-2"></i>
                            {{ trans('lang.user_profile') }}
                        </a>
                        <a href="{!! url('logout') !!}" class="dropdown-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-envelope mr-2"></i> {{ __('auth.logout') }}
                        </a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer border-0 shadow-sm">
            <div class="float-sm-right d-none d-sm-block">
                <b>Version</b> {{ implode('.', str_split(substr(config('installer.currentVersion', 'v100'), 1, 3))) }}
            </div>
            <strong>Copyright © {{ date('Y') }} <a href="{{ url('/') }}">Dr Car</a>.</strong> All rights
            reserved.
        </footer>

    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('vendor/bootstrap-v4-rtl/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="{{ asset('https://www.gstatic.com/firebasejs/7.2.0/firebase-app.js') }}"></script>

    <script src="{{ asset('https://www.gstatic.com/firebasejs/7.2.0/firebase-messaging.js') }}"></script>

    <script type="text/javascript">
        @include('vendor.notifications.init_firebase')
    </script>

    <script type="text/javascript">
        // firebase
        // getRegToken()

        // saveToken()
        // changeLanguage
    </script>
    @stack('scripts_lib')
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/scripts.min.js') }}"></script>
    @stack('scripts')

</body>

</html>
