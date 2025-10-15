@include('admin.head')
<div class="drawer lg:drawer-open">
    <input id="drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col justify-start}}">
        @include('admin.body.header')

        <main class="main-content w-full grow" id="mainContent">
            <div class="content px-4 py-12">
                <div class="content__header mb-6">
                    <div class="w-full">
                        <div class="flex justify-between items-center mb-4 gap-2 flex-wrap">
                            <a href="@yield('back_to_route')" class="btn btn-ghost">
                                <span class="icon icon-sm icon-arrow-left me-2"></span>
                                @yield('back_to_text')
                            </a>
                            @yield('header_actions')
                        </div>
                        @yield('page_title')
                    </div>
                </div>
                @yield('maincontent')
            </div>
        </main>
        @include('admin.body.footer')
    </div>
    <div class="drawer-side z-40">
        <label for="drawer" aria-label="close sidebar" class="drawer-overlay"></label>
        @include('admin.body.sidebar')
    </div>
</div>


@include('components.toast')

@stack('scripts')
@include('admin.foot')