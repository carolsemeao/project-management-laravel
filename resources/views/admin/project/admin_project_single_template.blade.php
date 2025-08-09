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
                        @yield('project-header')
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
@include('admin.foot')