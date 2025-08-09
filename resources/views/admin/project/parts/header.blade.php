<div class="pt-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1 mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="@yield('back_to_route')" class="text-decoration-none d-flex align-items-center">
                    <span class="icon icon-sm icon-arrow-left me-2"></span>
                    @yield('back_to_text')</a>
                @yield('header_actions')
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="fw-bold m-0">
                        @yield('page_title')
                    </h1>
                    <p class="text-muted m-0">@yield('page_subtitle')</p>
                </div>
            </div>
        </div>
    </div>
</div>