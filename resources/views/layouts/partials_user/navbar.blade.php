{{-- layouts/partials_user/navbar.blade.php --}}
<nav class="navbar" id="navbar">
    {{-- Logo Section --}}
    <div class="logo">
        <img src="{{ asset('assets/images/logo/logo_kemenkumham.png') }}" alt="Logo Kemenkumham">
        <div class="logo-text">
            <h1>Kemenkumham</h1>
            <p>Maluku</p>
        </div>
    </div>

    {{-- Mobile Menu Toggle Button --}}
    <div class="mobile-menu-toggle" id="mobile-menu-toggle" tabindex="0" role="button"
        aria-label="Toggle navigation menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </div>

    {{-- Navigation Links --}}
    <div class="nav-links" id="nav-links" role="navigation" aria-label="Main navigation">
        <a href="{{ route('user.dashboard') }}" class="{{ Request::routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('news.index') }}" class="{{ Request::routeIs('news.index') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i>
            <span>Berita</span>
        </a>
        <a href="{{ route('user.services') }}" class="{{ Request::routeIs('user.services') ? 'active' : '' }}">
            <i class="fas fa-cogs"></i>
            <span>Layanan</span>
        </a>
        <a href="{{ route('user.galery') }}" class="{{ Request::routeIs('user.galery') ? 'active' : '' }}">
            <i class="fas fa-images"></i>
            <span>Galeri</span>
        </a>
        <a href="{{ route('user.contact') }}" class="{{ Request::routeIs('user.contact') ? 'active' : '' }}">
            <i class="fas fa-phone"></i>
            <span>Kontak</span>
        </a>
    </div>

    {{-- Right Side Navigation (Search & Profile) --}}
    <div class="nav-right">
        {{-- Search Bar --}}
        <div class="nav-search" role="search">
            <input type="text" placeholder="Cari..." aria-label="Search" autocomplete="off">
            <button type="button" aria-label="Search button">
                <i class="fas fa-search"></i>
            </button>
        </div>

        {{-- Authentication Buttons or Profile --}}
        @auth
            <div class="nav-profile">
                <img src="{{ asset('assets/images/profile-default.jpg') }}"
                    alt="Profile {{ auth()->user()->name }}" class="profile-image" loading="lazy">

                {{-- Profile Dropdown --}}
                <div class="profile-dropdown">
                    <ul>
                        <li>
                            <a href="{{ route('profile.edit') }}">
                                <i class="fas fa-user"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-cog"></i>
                                Pengaturan
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit"
                                    style="background: none; border: none; width: 100%; text-align: left; padding: 10px 15px; color: #333;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            {{-- Login and Register Buttons --}}
            <div class="nav-auth">
                <a href="{{ route('login') }}" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </a>
                <a href="{{ route('register') }}" class="regis-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar</span>
                </a>
            </div>
        @endauth
    </div>
</nav>

{{-- Mobile Search Overlay (Optional) --}}
<div class="mobile-search-overlay" id="mobile-search-overlay">
    <div class="mobile-search-container">
        <div class="mobile-search-header">
            <h3>Pencarian</h3>
            <button class="close-search" id="close-mobile-search">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-search-form">
            <input type="text" placeholder="Ketik kata kunci..." id="mobile-search-input">
            <button type="button" class="mobile-search-btn">
                <i class="fas fa-search"></i>
                Cari
            </button>
        </div>
        <div class="mobile-search-suggestions">
            {{-- Popular search suggestions --}}
            <div class="search-suggestions">
                <h4>Pencarian Populer:</h4>
                <ul>
                    <li><a href="#">Visa</a></li>
                    <li><a href="#">Paspor</a></li>
                    <li><a href="#">Akta Kelahiran</a></li>
                    <li><a href="#">SKCK</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for mobile search --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileSearchOverlay = document.getElementById('mobile-search-overlay');
        const closeMobileSearch = document.getElementById('close-mobile-search');
        const mobileSearchInput = document.getElementById('mobile-search-input');
        const navSearchInput = document.querySelector('.nav-search input');

        // Show mobile search overlay when search is clicked on mobile
        if (navSearchInput && window.innerWidth <= 767) {
            navSearchInput.addEventListener('focus', function () {
                if (mobileSearchOverlay) {
                    mobileSearchOverlay.style.display = 'flex';
                    setTimeout(() => {
                        mobileSearchInput.focus();
                    }, 100);
                }
            });
        }

        // Close mobile search overlay
        if (closeMobileSearch && mobileSearchOverlay) {
            closeMobileSearch.addEventListener('click', function () {
                mobileSearchOverlay.style.display = 'none';
            });

            mobileSearchOverlay.addEventListener('click', function (e) {
                if (e.target === mobileSearchOverlay) {
                    mobileSearchOverlay.style.display = 'none';
                }
            });
        }
    });
</script>