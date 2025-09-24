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
                        @include('admin.issue.parts.header')
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
@include('admin.foot')