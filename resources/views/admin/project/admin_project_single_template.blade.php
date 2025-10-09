@include('admin.head')
<div class="drawer lg:drawer-open">
    <input id="drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col justify-start}}">
        @include('admin.body.header')

        <main class="main-content w-full grow" id="mainContent">
            <div class="content px-4 py-12">
                <div class="content__header mb-6">
                    @include('admin.project.parts.header')
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