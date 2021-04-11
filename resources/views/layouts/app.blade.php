<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('img/wheel-2121197.png') }}">
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <style>
            /*lucky draw input css*/
                /* Chrome, Safari, Edge, Opera */
                input.remove-arrow::-webkit-outer-spin-button,
                input.remove-arrow::-webkit-inner-spin-button {
                  -webkit-appearance: none;
                  margin: 0;
                }
                /* Firefox */
                input.remove-arrow[type=number] {
                  -moz-appearance: textfield;
                }
        </style>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-4.4.1-dist/css/bootstrap.min.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('bootstrap-4.4.1-dist/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('bootstrap-4.4.1-dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bootstrap-4.4.1-dist/js/sweetalert2@10.js') }}"></script>
        {{-- <script src="{{ asset('bootstrap-4.4.1-dist/js/popper.min.js') }}"></script> --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
