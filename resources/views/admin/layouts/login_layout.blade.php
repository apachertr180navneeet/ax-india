<!DOCTYPE html>
<html lang="en" ng-app="{{ config('app.name') }}">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" />
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
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/css/pages/page-auth.css')}}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/common/css/theme.css?v=2.0')}}" />
        <script src="{{asset('assets/admin/vendor/js/helpers.js')}}"></script>
        <script src="{{asset('assets/admin/js/config.js')}}"></script>
        @yield('style')
        <style>
            body {
                background: linear-gradient(135deg, var(--parchment), var(--linen)) !important;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card {
                background-color: var(--linen) !important;
                border: 1px solid var(--bone) !important;
                box-shadow: 0 15px 35px rgba(43, 37, 35, 0.08) !important;
                border-radius: var(--radius-md) !important;
            }
            .btn-primary {
                background-color: var(--almond-silk) !important;
                border-color: var(--bone) !important;
                color: var(--text-primary) !important;
                font-weight: 700;
            }
            .btn-primary:hover {
                background-color: var(--almond-cream) !important;
                color: var(--text-primary) !important;
            }
        </style>
        
    </head>
    <body>
        <div class="container-xxl">
            @yield('content')
        </div>
        
        <script src="{{asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
        <script src="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{asset('assets/admin/vendor/js/menu.js')}}"></script>
        <script src="{{asset('assets/admin/js/main.js')}}"></script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        @yield('script')
        @include('admin.layouts.elements.sweet_alerts')
    </body>
</html>