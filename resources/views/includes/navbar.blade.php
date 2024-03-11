<header class="nk-header">
    <!--  START: Navbar -->
    <nav class="nk-navbar nk-navbar-top nk-navbar-sticky nk-navbar-transparent nk-navbar-white-text-on-top">
        <div class="container">
            <div class="nk-nav-table">
                <a href="{{ route('index') }}" class="nk-nav-logo">
                    <img src="/img/white.png" alt="" width="85" class="nk-nav-logo-onscroll">
                    <img src="/img/blcck.png" alt="" width="85">
                </a>

                <form action="{{ route('search') }}" method="get" class="scc">
                    <input class="search" id="searchleft" type="search" name="search" placeholder="Search Courses">
                    <label style="color: #31dcfe;" class="button searchbutton" for="searchleft"><span class="mglass">&#9906;</span></label>
                    <input type="submit" style="display: none;">
                </form>

                <ul class="nk-nav nk-nav-right hidden-md-down" data-nav-mobile="#nk-nav-mobile">
                    @if(Auth::guard('instructor')->check())
                    <li>
                        <a href="{{ route('instructor.dashboard') }}" style="color:#31dcfe; font-weight:750 !important;">DASHBOARD</a>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="
                            font-weight:700 !important;">LOGOUT</a>

                    </li>
                    <li>
                        <a href="#">
                            @if(isset($instructor_info) && $instructor_info->profile_picture)
                            <img class="profile-picture" src="{{ asset('storage/' . $instructor_info->profile_picture) }}" alt="...">
                            @else
                            <!-- Add a placeholder image or default image -->
                            <img class="profile-picture" src="/img/9131529.png" alt="Placeholder Image">
                            @endif
                        </a>

                    </li>
                    @elseif(Auth::guard('student')->check())
                    <li>
                        <a href="{{ route('student.profile') }}" style="color:#31dcfe; font-weight:750 !important;">PROFILE</a>
                    </li>
                    <li>
                        <a href="{{ route('student.cart') }}">
                            <i class="fa fa-shopping-cart"></i>
                            @if ($cart > 0)
                            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">{{ $cart }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="
                            font-weight:700 !important;">LOGOUT</a>

                    </li>
                    <li>
                        <a href="#">
                            @if(isset($user_info) && $user_info->profile_picture)
                            <img class="profile-picture text-center" src="{{ asset('storage/' . $user_info->profile_picture) }}" alt="...">
                            @else
                            <!-- Add a placeholder image or default image -->
                            <img class="profile-picture text-center" src="/img/9131529.png" alt="Placeholder Image">
                            @endif
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('become.instructor') }}" style="color:#31dcfe; font-weight:750 !important;">Become an
                            Instructor</a>
                    </li>
                    <li>
                        <a href="{{ route('student.login') }}" style="font-weight:750 !important;">Log In</a>
                    </li>
                    <li>
                        <a href="{{ route('student.register') }}" style="font-weight:700 !important;">Sign Up</a>
                    </li>
                    @endif
                </ul>

                <ul class="nk-nav nk-nav-right nk-nav-icons">
                    <li class="single-icon hidden-lg-up">
                        <a href="#" class="nk-navbar-full-toggle">
                            <span class="nk-icon-burger">
                                <span class="nk-t-1"></span>
                                <span class="nk-t-2"></span>
                                <span class="nk-t-3"></span>
                            </span>

                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END: Navbar -->

</header>




<!--
    START: Navbar Mobile
-->
<nav class="nk-navbar nk-navbar-full nk-navbar-align-center" id="nk-nav-mobile">
    <div class="nk-navbar-bg">
        <div class="bg-image" style="background-image: url('/img/bg-menu.jpg')"></div>
    </div>
    <div class="nk-nav-table">
        <div class="nk-nav-row">
            <div class="container">
                <div class="nk-nav-header">

                    <div class="nk-nav-logo">
                        <a href="{{ route('index') }}" class="nk-nav-logo">
                            <img src="/img/white.png" alt="" width="85">
                        </a>
                    </div>

                    <div class="nk-nav-close nk-navbar-full-toggle">
                        <span class="nk-icon-close"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-nav-row-full nk-nav-row">
            <div class="nano">
                <div class="nano-content">
                    <div class="nk-nav-table">
                        <div class="nk-nav-row nk-nav-row-full nk-nav-row-center nk-navbar-mobile-content">
                            <ul class="nk-nav">
                                <!-- Here will be inserted menu from [data-mobile-menu="#nk-nav-mobile"] -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-nav-row">
            <div class="container">
                <div class="nk-nav-social">
                    <ul>
                        <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
@yield('content')