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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="w-100" style="max-width: 400px;">
                <div class="card rounded-4 shadow-lg" style="background-color: rgba(255, 255, 255, 0.2)">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="/"><x-application-logo style="width: 120px; height: 120px"/></a>                            
                        </div>
                        <br>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
