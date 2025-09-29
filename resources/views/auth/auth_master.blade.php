<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="valentine">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <script>
            const savedTheme = localStorage.getItem('theme') || 'valentine';
            document.documentElement.setAttribute('data-theme', savedTheme);
        </script>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>

    <body class="min-h-screen flex flex-col">
        @include('auth.body.header')
        <main class="main-content max-w-[100rem] w-full mx-auto py-15 grow flex items-center" id="mainContent">
            <div class="content grid grid-cols-1 md:grid-cols-2 gap-x-5 items-center w-full">
                @yield('content')
            </div>
        </main>
        @include('auth.body.footer')
        @stack('scripts')
    </body>

</html>