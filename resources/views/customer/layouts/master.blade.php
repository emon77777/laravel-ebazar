<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ maanAppearance('keywords') }}" />
    <meta name="description" content="{{ maanAppearance('meta_desc') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>

    <!-- Apple Favicon -->
    {{-- <link rel="apple-touch-icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}"> --}}

    <!-- All Device Favicon -->
    {{-- <link rel="icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}"> --}}

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('customer/css/bootstrap.min.css') }}">

    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('customer/css/normalize.css') }}">

    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('customer/css/nice-select.css') }}">

    <!-- SweetAlert -->
    <script src="{{ asset('frontend/js/vendor/sweetalert.min.js') }}"></script>

    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('customer/css/default.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('customer/css/style.css') }}">

    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('customer/css/responsive.css') }}">

    <!-- Timeline CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/timeline.css') }}">

    <!-- Invoice CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/invoice.css') }}">

    <!-- Cancel CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/cancel.css') }}">

    <!-- My Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/my-custom.css') }}">

    <!-- Print CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/print.css') }}">
</head>

<body>

<div id="main-wrapper">
    <!-- Main Header Start -->
    <div class="main-header">
        @include('customer.includes.mid-bar')
        @include('customer.includes.menu-bar')
    </div>
    <!-- Main Header End -->
    <div class="mybazar-customer-dashboard">
        <div class="container">
            <div class="row user-dashbord pt-0">
                <div class="col-lg-9 order-lg-last">
                    @yield('content')
                </div>
                <div class="col-lg-3">
                    @include('customer.includes.sidebar')
                </div>
            </div>
        </div>
    </div>
    <footer>
        @include('customer.includes.info-footer')
        @include('customer.includes.main-footer')
    </footer>
</div>

<!-- jQuery -->
<script src="{{ asset('customer/js/vendor/jquery-3.6.0.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('customer/js/vendor/bootstrap.min.js') }}"></script>

<!-- Popper -->
<script src="{{ asset('customer/js/vendor/popper.min.js') }}"></script>

<!-- Nice Select -->
<script src="{{ asset('customer/js/vendor/jquery.nice-select.min.js') }}"></script>

<!-- Waypoints -->
<script src="{{ asset('customer/js/vendor/waypoints.min.js') }}"></script>

<!-- Counter Up -->
<script src="{{ asset('customer/js/vendor/counterup.min.js') }}"></script>

<!-- Count Down -->
<script src="{{ asset('customer/js/vendor/countdown.js') }}"></script>
<script src="{{ asset('customer/js/vendor/chart.min.js') }}"></script>

<!-- Index -->
<script src="{{ asset('customer/js/index.js') }}"></script>

<!-- Form Pass -->
<script src="{{ asset('customer/js/form-pass.js') }}"></script>

@yield('script')

</body>

</html>
