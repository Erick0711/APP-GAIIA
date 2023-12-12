<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" type="text/css"/>

@yield('page_css')
<!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">
    @yield('page_css')

    @yield('css')
    <style>
    .collapse {
    overflow: hidden;
    transition: max-height 0.5s ease-in-out;
    }
    .collapsing {
    overflow: hidden;
    transition: max-height 0.5s ease-in-out;
    }
    </style>
</head>
<body>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar navbar-dark bg-primary-gaia"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            @include('layouts.header')

        </nav>
        <div class="main-sidebar main-sidebar-postion" style="background-color: aliceblue">
            @include('layouts.sidebar')
        </div>
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
            <span id="global" data-url="{{ URL::to('/') }}" data-CSRF="{{ csrf_token() }}"></span>
        </div>
        <footer class="main-footer">
            @include('layouts.footer')
        </footer>
    </div>
</div>
<script>
    var url_global={{url("/")}};
</script>

@include('profile.change_password')
@include('profile.edit_profile')

</body>


<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script> --}}
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@include('sweetalert::alert')

<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<script src="{{ mix('assets/js/profile.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

{{-- <script src="{{ asset('assets/js/global/variables.js') }}" type="module"></script> --}}

@yield('page_js')
@yield('scripts')
<script>
    let loggedInUser =@json(\Illuminate\Support\Facades\Auth::user());
    let loginUrl = '{{ route('login') }}';
    const userUrl = '{{url('users')}}';
    const userId = loggedInUser.id;
    if(!loggedInUser.avatar_url == null || !loggedInUser.avatar_url == ''){
        $('#imagenAvatar').attr('src', `storage/img/${loggedInUser.avatar_url}`)
    }
    // Loading button plugin (removed from BS4)
    (function ($) {
        $.fn.button = function (action) {
            if (action === 'loading' && this.data('loading-text')) {
                this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
            }
            if (action === 'reset' && this.data('original-text')) {
                this.html(this.data('original-text')).prop('disabled', false);
            }
        };
    }(jQuery));
</script>
<script>
function toggleCollapse(event, targetId) {
  event.preventDefault();
  var target = document.getElementById(targetId);
  var targetLink = document.querySelector(`a[href="#${targetId}"]`);

  var isExpanded = target.classList.contains('show');

  if (!isExpanded) {
    target.style.maxHeight = '0';
  }

  target.classList.toggle('show');

  if (target.classList.contains('show')) {
    target.style.maxHeight = target.scrollHeight + 'px';
    targetLink.classList.remove('collapsed');
  } else {
    targetLink.classList.add('collapsed');
  }
}
</script>

</html>
