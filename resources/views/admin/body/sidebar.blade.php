<aside class="sidebar bg-base-100 w-80">
    <div class="sidebar-content p-3 lg:p-0 flex-1">
        <div class="sidebar-header hidden lg:block mb-5">
            [Logo goes here]
        </div>
        <div class="join block lg:hidden mb-5">
            <input type="text" placeholder="{{ __('Search projects, issues..') }}" name="search" id="search"
                class="input join-item w-60 lg:w-80" />
            <button class="btn join-item">
                <span class="icon icon-sm icon-search"></span>
            </button>
        </div>
        <nav class="sidebar-nav p-0 lg:p-3">
            <ul class="menu">
                <li>
                    <a href="{{ route('dashboard') }}" title="Dashboard"
                        class="{{Route::currentRouteName() == 'dashboard' ? ' menu-active' : ''}}">
                        <span class="icon icon-home sidebar-icon"></span>
                        {{ __('Dashboard') }}
                    </a>
                </li>

                <li>
                    <span class="menu-title">
                        <span class="icon icon-folder sidebar-icon"></span>
                        {{ __('Projects') }}
                    </span>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('admin.projects') }}" title="All Projects"
                                class="{{Route::currentRouteName() == 'admin.projects' ? 'menu-active' : ''}}">
                                {{ __('All Projects') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.projects.create') }}" title="Create New Project"
                                class="{{Route::currentRouteName() == 'admin.projects.create' ? 'menu-active' : ''}}">
                                {{ __('Create New Project') }}
                            </a>
                        </li>
                    </ul>

                </li>
                <li>
                    <span class="menu-title">
                        <span class="icon icon-bug sidebar-icon"></span>
                        {{ __('Issues') }}
                    </span>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('admin.issues') }}" title="All Issues"
                                class="{{Route::currentRouteName() == 'admin.issues' ? 'menu-active' : ''}}">
                                {{ __('All Issues') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.issues.create') }}" title="Create New Issue"
                                class="{{Route::currentRouteName() == 'admin.issues.create' ? 'menu-active' : ''}}">
                                {{ __('Create New Issue') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <div class="divider my-1"></div>

                <li>
                    <a href="#" title="Customers">
                        <span class="icon icon-users sidebar-icon"></span>
                        {{ __('Customers') }}
                    </a>
                </li>
                <li>
                    <a href="#" title="Offers">
                        <span class="icon icon-file-text sidebar-icon"></span>
                        {{ __('Offers') }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    @php
        $id = Auth::user()->id;
        $profileData = App\Models\User::find($id);
    @endphp

    <div class="sidebar-footer flex justify-between">
        <div class="dropdown dropdown-top">
            <div tabindex="0" role="button" class="dropdown-trigger">
                <div class="avatar">
                    <div class="w-8 rounded-full border-2 border-base-content/10 dark:border-base-content/20">
                        <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                            alt="User" class="w-8 rounded-full">
                    </div>
                </div>
                <small class="font-medium mb-0 overflow-hidden text-ellipsis">{{ $profileData->name ?? 'User' }}</small>
                <span class="icon icon-sm icon-chevron-down sidebar-text"></span>
            </div>
            <ul tabindex="0" class="dropdown-content menu">
                <li>
                    <a href="{{ route('admin.profile') }}">
                        <span class="icon icon-sm icon-user"></span>
                        {{ __('My Account') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings') }}">
                        <span class="icon icon-sm icon-settings"></span>
                        {{ __('Settings') }}
                    </a>
                </li>

                <div class="divider my-0"></div>

                <li>
                    <a href="{{ route('admin.logout') }}">
                        <span class="icon icon-sm icon-log-out"></span>
                        {{ __('Logout') }}
                    </a>
                </li>
            </ul>
        </div>
        @include('components.theme-switcher')
    </div>
</aside>