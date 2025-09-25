<div class="navbar bg-base-100 shadow-sm">
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
</div>

<!-- Mobile Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content border-0 rounded-0">
            <div class="modal-body p-3">
                <div class="position-relative">
                    <input type="text" class="form-control bg-light border-1 ps-5"
                        placeholder="{{ __('Search projects, issues...') }}" autofocus>
                    <i data-feather="search" class="position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"
                        style="width: 16px; height: 16px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>