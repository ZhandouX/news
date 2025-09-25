<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super-admin.dashboard') }}">
                <i class="mdi mdi-gauge menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Manajemen Data</li>

        {{-- MANAGEMENT NEWS DATA --}}
        <li class="nav-item {{ request()->routeIs('super-admin.news.index') }}">
            <a class="nav-link" href="{{ route('super-admin.news.index') }}">
                <i class="menu-icon mdi mdi-newspaper-variant-multiple-outline"></i>
                <span class="menu-title">Berita</span>
            </a>
        </li>

        {{-- MANAGEMENT OFFICER ACCOUNTS --}}
        <li class="nav-item {{ request()->routeIs('super-admin.news.officer-account') }}">
            <a class="nav-link" href="{{ route('super-admin.news.officer-account') }}">
                <i class="menu-icon mdi mdi-account-hard-hat-outline"></i>
                <span class="menu-title">Kelola Petugas</span>
            </a>
        </li>

        {{-- YOUTUBE --}}
        <li class="nav-item {{ request()->routeIs('super-admin.youtube.index') }}">
            <a class="nav-link" href="{{ route('super-admin.youtube.index') }}">
                <i class="menu-icon mdi mdi-youtube"></i>
                <span class="menu-title">Youtube</span>
            </a>
        </li>
        
        {{-- INSTAGRAM --}}
        <li class="nav-item {{ request()->routeIs('super-admin.instagram.index') }}">
            <a class="nav-link" href="{{ route('super-admin.instagram.index') }}">
                <i class="menu-icon mdi mdi-instagram"></i>
                <span class="menu-title">Instagram</span>
            </a>
        </li>

        {{-- TIKTOK --}}
        <li class="nav-item {{ request()->routeIs('super-admin.tiktok.index') }}">
            <a class="nav-link" href="{{ route('super-admin.tiktok.index') }}">
                <i class="menu-icon fa-brands fa-tiktok"></i>
                <span class="menu-title">Tiktok</span>
            </a>
        </li>

        {{-- TWITTER --}}
        <li class="nav-item {{ request()->routeIs('super-admin.twitter.index') }}">
            <a class="nav-link" href="{{ route('super-admin.twitter.index') }}">
                <i class="menu-icon mdi mdi-twitter"></i>
                <span class="menu-title">Twitter</span>
            </a>
        </li>

        {{-- WEBSITE --}}
        <li class="nav-item {{ request()->routeIs('super-admin.website.index') }}">
            <a class="nav-link" href="{{ route('super-admin.website.index') }}">
                <i class="menu-icon mdi mdi-web"></i>
                <span class="menu-title">Website</span>
            </a>
        </li>
    </ul>
</nav>