<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="valentine">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <script>
            // Apply theme immediately to prevent flash
            const savedTheme = localStorage.getItem('theme') || 'valentine';
            document.documentElement.setAttribute('data-theme', savedTheme);
        </script>
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>

    <body>