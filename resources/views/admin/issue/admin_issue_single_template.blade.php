<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @endif
    </head>

    <body>
        <div class="container-fluid p-0 layout-container">
            <!-- Mobile overlay -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            <div class="row g-0 h-100">
                <div class="col-auto sidebar bg-dark" id="sidebar">
                    @include('admin.body.sidebar')
                </div>

                <div class="col main-content d-flex flex-column" id="mainContent">
                    @include('admin.body.header')

                    <div class="p-4 flex-grow-1">
                        <div class="content-page">
                            <div class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                                            <div class="flex-grow-1 mb-5">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <a href="{{ route('admin.issues') }}"
                                                            class="text-decoration-none">←
                                                            {{ __('Back to Issues') }}</a>
                                                    </div>
                                                </div>
                                                <div class="card bg-warning border-warning p-2 bg-opacity-25">
                                                    <h1 class="fw-bold m-0">@yield('page_title')</h1>
                                                    <p class="text-muted m-0">@yield('page_subtitle')</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @yield('maincontent')
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        @include('admin.body.footer')
                    </div>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            @if(Session::has('message'))
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="toast-body bg-{{ Session::get('alert-type', 'primary') }} text-white">
                        {{ Session::get('message') }}
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </body>

</html>