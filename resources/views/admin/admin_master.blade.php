@include('admin.head')
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
                                    <div class="page-title">
                                        <h1>@yield('page_title')</h1>
                                        <p>@yield('page_subtitle')</p>
                                    </div>
                                    @yield('header_actions')
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

@include('components.toast')

@stack('scripts')
@include('admin.foot')