<header class="main-nav">
    <div class="sidebar-user text-center">
        <!-- <img class="img-90 rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
        <a href="user-profile"> <h6 class="mt-3 f-14 f-w-600">Emay Walter</h6></a>
        <p class="mb-0 font-roboto">Human Resources Department</p> -->
    </div>
    <nav>
        <div class="main-navbar">
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <!-- Tombol Kembali di mobile -->
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>                    <!-- Menu Dashboard -->
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="{{ route('dashboard') }}">
                            <i data-feather="bar-chart-2"></i>  <!-- Ikon untuk Dashboard -->
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Menu Home -->
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="{{ route('home') }}">
                            <i data-feather="home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    
                    <!-- Menu Donasi -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ request()->routeIs('donate*') || request()->routeIs('find-donations') || request()->routeIs('donations.*') || request()->routeIs('claims.*') ? 'active' : '' }}" href="javascript:void(0)">
                            <i data-feather="gift"></i>
                            <span>Donasi</span>
                        </a>
                        <ul class="nav-submenu menu-content" style="display: {{ request()->routeIs('donate*') || request()->routeIs('find-donations') || request()->routeIs('donations.*') || request()->routeIs('claims.*') ? 'block' : 'none' }};">
                            <li><a href="{{ route('donate') }}" class="{{ request()->routeIs('donate') ? 'active' : '' }}">Buat Donasi</a></li>
                            <li><a href="{{ route('find-donations') }}" class="{{ request()->routeIs('find-donations') ? 'active' : '' }}">Cari Donasi</a></li>
                            <li><a href="{{ route('donations.my') }}" class="{{ request()->routeIs('donations.my') ? 'active' : '' }}">Donasi Saya</a></li>
                            <li><a href="{{ route('claims.my') }}" class="{{ request()->routeIs('claims.my') ? 'active' : '' }}">Klaim Saya</a></li>
                        </ul>
                    </li>
                      <!-- Menu Aktivitas -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ request()->routeIs('my-activity') ? 'active' : '' }}" href="{{ route('my-activity') }}">
                            <i data-feather="activity"></i>
                            <span>Aktivitas Saya</span>
                        </a>
                    </li>
                    
                    <!-- Menu Leaderboard -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ request()->routeIs('leaderboard') ? 'active' : '' }}" href="{{ route('leaderboard') }}">
                            <i data-feather="award"></i>
                            <span>Leaderboard</span>
                        </a>
                    </li>
                    
                    <!-- Menu Profil -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ request()->routeIs('profile') || request()->routeIs('settings') ? 'active' : '' }}" href="javascript:void(0)">
                            <i data-feather="user"></i>
                            <span>Profil</span>
                        </a>
                        <ul class="nav-submenu menu-content" style="display: {{ request()->routeIs('profile') || request()->routeIs('settings') ? 'block' : 'none' }};">
                            <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profil Saya</a></li>
                            <li><a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'active' : '' }}">Pengaturan</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>