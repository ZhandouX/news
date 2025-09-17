<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-gauge menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Manajemen Data</li>

        {{-- Berita --}}
        <li class="nav-item {{ request()->routeIs('admin.news.index') }}">
            <a class="nav-link" href="{{ route('admin.news.index') }}">
                <i class="menu-icon mdi mdi-newspaper-variant-multiple-outline"></i>
                <span class="menu-title">Berita</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="menu-icon mdi mdi-image-outline"></i>
                <span class="menu-title">Galeri</span>
            </a>
        </li>
    </ul>
</nav>