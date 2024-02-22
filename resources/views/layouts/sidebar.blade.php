<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary shadow">
    <!-- Brand Logo -->
    @php
        $logo = App\Models\Media::appLogo()->imageName();
    @endphp

    <a href="{{ url('dashboard') }}" class="brand-link border-bottom-0 text-light  navbar-navy">
        <img src="{{ asset('storage/images/app/' . $logo) }}" alt="Dr Car" class="brand-image">
        <span class="brand-text font-weight-light">Dr Car</span> </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
                data-accordion="false">
                @include('layouts.menu', ['icons' => true])
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
