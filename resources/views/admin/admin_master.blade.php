@include('admin.head')
<div class="drawer lg:drawer-open">
    <input id="drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col items-center justify-center">
        @include('admin.body.header')

        <main class="main-content w-full" id="mainContent">
            <div class="content">
                <div class="content__header">
                    <div class="page-title">
                        <h1>@yield('page_title')</h1>
                        <p>@yield('page_subtitle')</p>
                    </div>
                    @yield('header_actions')
                </div>
                @yield('maincontent')
            </div>
            <div class="mt-auto">
                @include('admin.body.footer')
            </div>
        </main>
    </div>
    <div class="drawer-side z-40">
        <label for="drawer" aria-label="close sidebar" class="drawer-overlay"></label>
        @include('admin.body.sidebar')
    </div>
</div>


@include('components.toast')

@stack('scripts')
@include('admin.foot')