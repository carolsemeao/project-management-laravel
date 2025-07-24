<div class="row">
    <div class="col-12">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1 mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="@yield('back_to_route')" class="text-decoration-none d-flex align-items-center">
                            <i data-feather="arrow-left" class="me-2" style="width: 16px; height: 16px;"></i>
                            @yield('back_to_text')
                        </a>
                        @yield('header_actions')
                    </div>
                </div>
                <div class="card p-2 bg-opacity-25">
                    <h1 class="fw-bold m-0">@yield('page_title')</h1>
                    <p class="text-muted m-0">@yield('page_subtitle')</p>
                </div>
            </div>
        </div>
    </div>
</div>