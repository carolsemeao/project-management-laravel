<div class="d-flex flex-column h-100">
    <div class="sidebar-header px-3 py-4 border-bottom border-secondary flex-shrink-0">
        <div class="d-flex align-items-center justify-content-between text-white">
            <div class="d-flex align-items-center">
                <span class="icon icon-clock sidebar-icon"></span>
                <span class="sidebar-text ms-2">Project Manager</span>
            </div>
            <!-- Close button for mobile only -->
            <button class="sidebar-close-btn d-lg-none" id="sidebarClose" type="button">
                <span class="icon icon-x"></span>
            </button>
        </div>
    </div>

    <nav class="sidebar-nav flex-grow-1 px-3 py-3 overflow-y-auto">
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" title="Dashboard"
                    class="nav-link d-flex align-items-center py-3 text-white text-decoration-none{{Route::currentRouteName() == 'dashboard' ? ' active' : ''}}">
                    <span class="icon icon-home sidebar-icon"></span>
                    <span class="sidebar-text ms-3">{{ __('Dashboard') }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.projects') }}" title="Projects"
                    class="nav-link d-flex align-items-center py-3 text-white text-decoration-none{{Route::currentRouteName() == 'admin.projects' || Route::currentRouteName() == 'admin.projects.show' || Route::currentRouteName() == 'admin.projects.create' || Route::currentRouteName() == 'admin.projects.edit' ? ' active' : ''}}">
                    <span class="icon icon-folder sidebar-icon"></span>
                    <span class="sidebar-text ms-3">{{ __('Projects') }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.issues') }}" title="Issues"
                    class="nav-link d-flex align-items-center py-3 text-white text-decoration-none{{Route::currentRouteName() == 'admin.issues' || Route::currentRouteName() == 'admin.issues.show' || Route::currentRouteName() == 'admin.issues.create' || Route::currentRouteName() == 'admin.issues.edit' ? ' active' : ''}}">
                    <span class="icon icon-bug sidebar-icon"></span>
                    <span class="sidebar-text ms-3">{{ __('Issues') }}</span>
                </a>
            </li>

            <hr class="my-2 border-secondary">

            <li class="nav-item">
                <a href="#" title="Customers"
                    class="nav-link d-flex align-items-center py-3 text-white text-decoration-none">
                    <span class="icon icon-users sidebar-icon"></span>
                    <span class="sidebar-text ms-3">{{ __('Customers') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" title="Offers"
                    class="nav-link d-flex align-items-center py-3 text-white text-decoration-none">
                    <span class="icon icon-file-text sidebar-icon"></span>
                    <span class="sidebar-text ms-3">{{ __('Offers') }}</span>
                </a>
            </li>
        </ul>
    </nav>

    @php
        $id = Auth::user()->id;
        $profileData = App\Models\User::find($id);
    @endphp

    <div class="sidebar-footer py-3 px-3 border-top border-secondary flex-shrink-0">
        <div class="dropdown dropup">
            <button class="btn p-0 d-flex align-items-center gap-2 border-0 bg-transparent w-100 text-start text-white"
                data-bs-toggle="dropdown">
                <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                    alt="User" class="rounded-circle avatar-sm">
                <div class="d-flex flex-column align-items-start sidebar-text overflow-hidden">
                    <small class="fw-medium mb-0 text-truncate w-100">{{ $profileData->name ?? 'User' }}</small>
                </div>
                <span class="icon icon-sm icon-chevron-down sidebar-text ms-auto"></span>
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow border-0 w-100">
                <a href="{{ route('admin.profile') }}"
                    class="dropdown-item d-flex align-items-center gap-2 py-2 text-dark">
                    <span class="icon icon-sm icon-user"></span>
                    My Account
                </a>

                <a href="#" class="dropdown-item d-flex align-items-center gap-2 py-2 text-dark">
                    <span class="icon icon-sm icon-settings"></span>
                    Settings
                </a>

                <div class="dropdown-divider"></div>

                <a href="{{ route('admin.logout') }}"
                    class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                    <span class="icon icon-sm icon-log-out"></span>
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>