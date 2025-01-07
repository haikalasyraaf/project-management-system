<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                        <a href="/" class="d-flex align-items-center mb-md-0 me-md-auto text-decoration-none">
                            <i data-feather="battery-charging" style="width: 35px !important; height: 35px !important" class="me-3"></i>
                            <span class="d-none d-lg-block fw-bolder text-uppercase h4 mb-0">Test System</span>
                        </a>
                        @include('layouts.sidebar')
                    </div>
                </div>
                <div class="col" style="padding: 25px">
                    @include('layouts.navbar')
                    <div class="py-4 d-flex align-items-center">
                        <div class="border-end pe-3"><span class="h4">@yield('title')</span></div>
                        <div class="ps-3 d-flex">@yield('breadcrumbs')</div>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            feather.replace();
        </script>

        @yield('script')
    </body>
</html>
