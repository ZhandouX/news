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
        
        {{-- NEWS GALLERY --}}
        <li class="nav-item">
            <a class="nav-link" href="docs/documentation.html">
                <i class="menu-icon mdi mdi-image-outline"></i>
                <span class="menu-title">Galeri Berita</span>
            </a>
        </li>
    </ul>
</nav>