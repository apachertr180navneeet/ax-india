<!DOCTYPE html>
<html lang="en" ng-app="{{ config('app.name') }}" lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="ws_url" content="{{ env('WS_URL') }}">
        <meta name="user_id" content="{{ Auth::id() }}">
        <link rel="icon" type="image/x-icon" href="{{asset('assets/admin/img/favicon/favicon.ico')}}" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/fonts/boxicons.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/css/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{asset('assets/admin/css/demo.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrapDataTable.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/libs/apex-charts/apex-charts.css')}}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/common/css/theme.css?v=2.0')}}" />
        <script src="{{asset('assets/admin/vendor/js/helpers.js')}}"></script>
        <script src="{{asset('assets/admin/js/config.js')}}"></script>
        <link rel="stylesheet" href="{{asset('assets/admin/css/sweet-alert.css')}}" />
        @yield('style')
        <style>
            body, .layout-wrapper, .layout-container, .layout-page, .content-wrapper {
                background-color: var(--alice-blue) !important;
                color: var(--text-primary) !important;
            }
            .bg-menu-theme {
                background-color: #ffffff !important;
                border-right: 1px solid var(--lavender-accent) !important;
            }
            .bg-menu-theme .menu-link, .bg-menu-theme .menu-header-text {
                color: #1e293b !important;
            }
            aside#layout-menu .menu-inner .menu-item.active > .menu-link,
            aside#layout-menu.bg-menu-theme .menu-inner .menu-item.active > .menu-link,
            .layout-wrapper .bg-menu-theme .menu-inner .menu-item.active > .menu-link,
            html .bg-menu-theme .menu-inner .menu-item.active > .menu-link,
            .menu-vertical .menu-inner .menu-item.active > .menu-link {
                background-color: #4f46e5 !important;
                background: #4f46e5 !important;
                box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4) !important;
            }

            aside#layout-menu .menu-inner .menu-item.active > .menu-link,
            aside#layout-menu .menu-inner .menu-item.active > .menu-link *,
            aside#layout-menu .menu-inner .menu-item.active > .menu-link i,
            aside#layout-menu .menu-inner .menu-item.active > .menu-link div,
            aside#layout-menu .menu-inner .menu-item.active > .menu-link span,
            .bg-menu-theme .menu-inner .menu-item.active > .menu-link,
            .bg-menu-theme .menu-inner .menu-item.active > .menu-link *,
            .bg-menu-theme .menu-inner .menu-item.active > .menu-link i,
            .bg-menu-theme .menu-inner .menu-item.active > .menu-link div,
            .bg-menu-theme .menu-inner .menu-item.active > .menu-link span,
            .menu-item.active > .menu-link,
            .menu-item.active > .menu-link div,
            .menu-item.active > .menu-link i {
                color: #ffffff !important;
                font-weight: 700 !important;
            }

            .bg-menu-theme .menu-link,
            .bg-menu-theme .menu-item .menu-link div,
            .bg-menu-theme .menu-item .menu-link i {
                color: #1e293b !important;
            }
            .card {
                background-color: #ffffff !important;
                border: 1px solid var(--lavender-accent) !important;
                box-shadow: var(--shadow-soft) !important;
                border-radius: var(--radius-md) !important;
                color: var(--text-primary) !important;
            }
            .navbar-detached {
                background-color: var(--bg-glass) !important;
                border: 1px solid var(--lavender-accent) !important;
                backdrop-filter: blur(16px);
            }
            .table-hover tbody tr:hover {
                background-color: var(--lavender-light) !important;
                color: var(--text-primary) !important;
            }
        </style>
        
    </head>
    <body>
       <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('admin.layouts.elements.left_sidebar')
                <div class="layout-page">
                    @include('admin.layouts.elements.header')
                    <div class="content-wrapper">
                        @yield('content')
                        @include('admin.layouts.elements.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                    @include('admin.layouts.elements.right_sidebar')
                </div>
        
                <script src="{{asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
                <script src="{{asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
                <script src="{{asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
                <script src="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
                <script src="{{asset('assets/admin/vendor/js/menu.js')}}"></script>
                <script src="{{asset('assets/admin/vendor/libs/apex-charts/apexcharts.js')}}"></script>
                <script src="{{asset('assets/admin/js/main.js')}}"></script>
                <script src="{{asset('assets/admin/js/dataTable.js')}}"></script>
                <script src="{{asset('assets/admin/js/bootstrapDataTable.js')}}"></script>
                <script src="{{asset('assets/admin/js/dashboards-analytics.js')}}"></script>
                <script src="{{asset('assets/admin/js/moment.min.js')}}"></script>
                <script async defer src="https://buttons.github.io/buttons.js"></script>
                @yield('script')
                @include('admin.layouts.elements.sweet_alerts')
            </div>
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
    </body>
</html>