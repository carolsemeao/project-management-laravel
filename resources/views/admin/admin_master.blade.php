@include('admin.head')
<div class="drawer lg:drawer-open">
    <input id="drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col justify-start}}">
        @include('admin.body.header')

        <main class="main-content w-full grow" id="mainContent">
            <div class="content px-4 py-12">
                <div class="content__header">
                    <div class="page-title mb-6">
                        <h1 class="text-3xl font-bold">@yield('page_title')</h1>
                        <p class="text-sm opacity-50">@yield('page_subtitle')</p>
                    </div>
                    @yield('header_actions')
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