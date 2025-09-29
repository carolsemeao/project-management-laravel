<header
    class="navbar bg-base-100/90 text-base-content sticky top-0 z-30 h-16 w-full [transform:translate3d(0,0,0)] backdrop-blur transition-shadow duration-100 shadow-sm">
    <div class="logo md:hidden">
        [Logo goes here]
    </div>
    <div class="ms-auto gap-2 hidden md:flex">
        <div class="join">
            <input type="text" placeholder="{{ __('Search projects, issues..') }}" name="search" id="search"
                class="input join-item w-40 md:w-80" />
            <button class="btn join-item">
                <span class="icon icon-sm icon-search"></span>
            </button>
        </div>
    </div>
    <label aria-label="Open menu" for="drawer" class="ms-auto btn btn-square btn-ghost drawer-button lg:hidden ">
        <span class="icon icon-sm icon-menu"></span>
    </label>
</header>