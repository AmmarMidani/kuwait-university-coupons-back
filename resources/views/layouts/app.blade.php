<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-no-customizer" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name', 'Laravel') }} | @yield('pagename')</title>

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
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}?v={{ config('app.version') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/css/pages/cards-statistics.css') }}?v={{ config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/css/pages/cards-analytics.css') }}?v={{ config('app.version') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}?v={{ config('app.version') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}?v={{ config('app.version') }}"></script>

    @yield('css_plugin')
    @yield('css')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.leftSidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.topbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            @include('layouts.message')
                            @yield('content')
                        </div>
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    @include('layouts.footer')
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

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
    <script
        src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}?v={{ config('app.version') }}">
    </script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}?v={{ config('app.version') }}"></script>
    <script
        src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}?v={{ config('app.version') }}">
    </script>
    <script
        src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}?v={{ config('app.version') }}">
    </script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}?v={{ config('app.version') }}">
    </script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}?v={{ config('app.version') }}">
    </script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}?v={{ config('app.version') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}?v={{ config('app.version') }}"></script>

    @yield('js_plugin')

    <!-- Custom js for this page -->
    @yield('js')
    <!-- End custom js for this page -->
</body>

</html>
