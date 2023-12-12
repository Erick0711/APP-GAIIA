<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo-2.jpg') }}" width="55" alt="Infyom Logo">
        <a href="{{ url('/') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ asset('img/logo.jpg') }}" width="45px" alt="" />
        </a>
    </div>
    <ul class="sidebar-menu" id="menu">
        @include('layouts.menu')
    </ul>
</aside>
