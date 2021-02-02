<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Rejuvaskin">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rejuvaskin</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/dataTables.bootstrap4.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css') }}" type="text/css">

    @yield('page-css')
</head>
<body class="g-sidenav-show g-sidenav-pinned">
    @include('includes.sidebar')
    <main class="main-content" id="panel">
        @include('includes.navbar')
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Core -->
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/vendor/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Argon JS -->
    <script src="{{ asset('assets/js/argon.js') }}"></script>

    <!-- Custom JS -->
    <script type="text/javascript" src="{{ asset('js/general-use.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatable-custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            generalFunctions.onLoad();
        });
    </script>
    @yield('page-js')
</body>
</html>
