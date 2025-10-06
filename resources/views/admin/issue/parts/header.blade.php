<div class="w-full">
    <div class="flex justify-between items-center mb-4 gap-2 flex-wrap">
        <a href="@yield('back_to_route')" class="btn btn-ghost">
            <span class="icon icon-sm icon-arrow-left me-2"></span>
            @yield('back_to_text')
        </a>
        @yield('header_actions')
    </div>
    <div class="content__header-title">
        <h1>@yield('page_title')</h1>
        <p class="text-sm opacity-60">@yield('page_subtitle')</p>
    </div>
</div>