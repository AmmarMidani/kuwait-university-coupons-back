<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-wide customizer-hide" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('assets') }}/"
    data-template="vertical-menu-template-no-customizer" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ asset('assets/img/favicon/favicon.ico') }}?v={{ config('app.version') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/fonts/remixicon/remixicon.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}?v={{ config('app.version') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}?v={{ config('app.version') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}?v={{ config('app.version') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}?v={{ config('app.version') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}?v={{ config('app.version') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}?v={{ config('app.version') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}?v={{ config('app.version') }}"></script>
</head>

<body>
    <!-- Content -->

    <!-- Error -->
    <div class="misc-wrapper">
        <h1 class="mb-2 mx-2" style="font-size: 6rem; line-height: 6rem">@yield('code')</h1>
        <h4 class="mb-2">@yield('message')</h4>
        <p class="mb-6 mx-2">@yield('details')</p>
        <div class="d-flex justify-content-center mt-9">
            <img src="{{ asset('assets/img/illustrations/misc-error-object.png') }}?v={{ config('app.version') }}"
                class="img-fluid misc-object d-none d-lg-inline-block" width="160" />
            <img src="{{ asset('assets/img/illustrations/misc-bg-light.png') }}?v={{ config('app.version') }}"
                class="misc-bg d-none d-lg-inline-block" data-app-light-img="illustrations/misc-bg-light.png"
                data-app-dark-img="illustrations/misc-bg-dark.png" />
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('assets/img/illustrations/misc-error-illustration.png') }}?v={{ config('app.version') }}"
                    class="img-fluid z-1" width="190" />
                <div>
                    <a href="javascript:history.back()" class="btn btn-primary text-center my-10">Back to home</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Error -->

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}?v={{ config('app.version') }}"></script>
    <script
        src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}?v={{ config('app.version') }}">
    </script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}?v={{ config('app.version') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}?v={{ config('app.version') }}"></script>

    <!-- Page JS -->
</body>

</html>
