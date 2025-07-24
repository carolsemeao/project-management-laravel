<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @endif
        <!-- Code Editor  -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/app.min.css')}}">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js">
        </script>
    </head>

    <body>
        <!-- Mobile Menu -->
        @include('home.body.mobile_menu')
        <!-- End mobile menu -->

        @include('home.body.header')

        <!-- End mobile menu -->

        @yield('maincontent')

        <!-- Footer  -->
        @include('home.body.footer')
    </body>

</html>