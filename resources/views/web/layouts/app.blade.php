<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>{{ config('app.name', 'AX-India Video Platform') }}</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/web/img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="{{asset('assets/common/css/theme.css?v=2.0')}}" rel="stylesheet">
        @yield('style')
    </head>

    <body>
        <div id="main-wrapper">
            @include('web.layouts.elements.header')
            @yield('content')
            @include('web.layouts.elements.footer')
        </div>

        <script src="{{asset('assets/web/js/jquery.min.js')}}"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        @yield('script')
    </body>
</html>
