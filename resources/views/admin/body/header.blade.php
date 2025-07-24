<div class="bg-white border-bottom p-4 sticky-top" style="z-index: 1020;">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3 justify-content-between w-100">
            <button class="sidebar-toggle-btn" id="sidebarToggle" type="button">
                <i data-feather="menu"></i>
            </button>
            @include('components.language_switcher')
            <div class="position-relative header-search d-none d-md-block" style="width: 300px;">
                <input type="text" class="form-control bg-light border-1 ps-5"
                    placeholder="{{ __('Search projects, issues...') }}" name="search" id="search">
                <i data-feather="search" class="position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"
                    style="width: 16px; height: 16px;"></i>
            </div>
        </div>

        <!-- Mobile search button -->
        <button class="btn btn-light rounded-circle p-2 d-md-none" type="button" data-bs-toggle="modal"
            data-bs-target="#searchModal">
            <i data-feather="search" style="width: 16px; height: 16px;"></i>
        </button>
    </div>
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