<header class="site-header lonyo-header-section light-bg" id="sticky-menu">
    <div class="container">
        <div class="row gx-3 align-items-center justify-content-between">
            <div class="col-8 col-sm-auto ">
                <div class="header-logo1 ">
                    <a href="index.html">
                        <div class="d-flex align-items-center">
                            <i data-feather="clock"></i>
                            <span class="sidebar-text ms-2">Project Manager</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="lonyo-main-menu-item">
                    <nav class="main-menu menu-style1 d-none d-lg-block menu-left">
                        <ul>
                            <li>
                                <a href="#">Home</a>
                            </li>
                            <li>
                                <a href="#">About Us</a>
                            </li>
                            <li>
                                <a href="#">Our Services</a>
                            </li>
                            <li>
                                <a href="#">Blog</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-auto d-flex align-items-center">
                @include('components.language_switcher')
                <div class="lonyo-header-info-wraper2">
                    <div class="lonyo-header-info-content">
                        <ul>
                            <li>
                                @auth
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}">Log in</a>
                                @endauth
                            </li>
                        </ul>
                    </div>

                    <a class="btn btn-lg btn-primary" href="#">Kontaktieren Sie uns</a>
                </div>
                <div class="lonyo-header-menu">
                    <nav class="navbar site-navbar justify-content-between">
                        <!-- Brand Logo-->
                        <!-- mobile menu trigger -->
                        <button class="lonyo-menu-toggle d-inline-block d-lg-none">
                            <span></span>
                        </button>
                        <!--/.Mobile Menu Hamburger Ends-->
                    </nav>
                </div>
            </div>
        </div>
    </div>

</header>