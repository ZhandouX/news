<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="#">
                <img src="{{ asset('assets/images/logo/logo-kemenkum.png') }}" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="#">
                <img src="{{ asset('assets/images/logo/logo_kemenkum.png') }}" alt="logo" />
            </a>
        </div>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-top">
        {{-- WELCOME TEXT --}}
        <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">Halo!
                    <span class="text-black fw-bold">{{ auth()->user()->name ?? 'Administrator' }}</span>
                </h1>
                <h3 class="welcome-sub-text">Selamat Datang di Portal Berita
                    <strong class="text-dark">
                        <i class="mdi mdi-account-tie-hat"></i> KANWIL KEMENKUM MALUKU
                    </strong>
                </h3>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            {{-- CALENDAR --}}
            <li class="nav-item d-none d-lg-block">
                <div class="input-group navbar-date-picker">
                    <label for="news-date-filter" class="input-group-addon input-group-prepend border-right mb-0">
                        <span class="icon-calendar input-group-text calendar-icon"></span>
                    </label>
                    <input type="text" id="news-date-filter" class="form-control" placeholder="Pilih tanggal..."
                        autocomplete="off">
                </div>
            </li>

            {{-- CATEGORY --}}
            <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link dropdown-bordered dropdown-toggle-split d-flex align-items-center justify-content-between gap-2"
                    id="categoryDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Kategori
                    {{-- ICON --}}
                    <i class="mdi mdi-chevron-down fs-5 dropdown-icon"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                    aria-labelledby="categoryDropdown">

                    <div class="dropdown-divider"></div>

                    {{-- ================= SUB-MENU (NEWS CATEGORY) ================= --}}
                    <a class="dropdown-item dropdown-toggle custom-submenu-toggle d-flex align-items-center justify-content-between"
                        href="#">
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis fw-medium text-dark">Kategori Berita</p>
                        </div>
                        <!-- <i class="mdi mdi-chevron-left submenu-icon"></i> -->
                    </a>
                    <div class="dropdown-menu custom-submenu">
                        @foreach(($categories ?? []) as $cat)
                            <a class="dropdown-item preview-item d-flex justify-content-between align-items-center"
                                href="{{ route('super-admin.news.index', ['kategori' => $cat]) }}">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis fw-medium text-dark">{{ $cat }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- ================= SUB-MENU (NEWS SUMBER) ================= --}}
                    <a class="dropdown-item dropdown-toggle custom-submenu-toggle d-flex align-items-center justify-content-between"
                        href="#">
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis fw-medium text-dark">Sumber Berita</p>
                        </div>
                        <!-- <i class="mdi mdi-chevron-left submenu-icon"></i> -->
                    </a>
                    <div class="dropdown-menu custom-submenu">
                        @foreach(($sources ?? []) as $src)
                            <a class="dropdown-item preview-item"
                                href="{{ route('super-admin.news.index', ['sumber' => $src]) }}">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis fw-medium text-dark">{{ $src }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- ================= SUB-MENU (UNIT UTAMA) ================= --}}
                    <a class="dropdown-item dropdown-toggle custom-submenu-toggle d-flex align-items-center justify-content-between"
                        href="#">
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis fw-medium text-dark">Unit Utama</p>
                        </div>
                        <!-- <i class="mdi mdi-chevron-left submenu-icon"></i> -->
                    </a>
                    <div class="dropdown-menu custom-submenu">
                        @foreach(($offices ?? []) as $office)
                            <a class="dropdown-item preview-item"
                                href="{{ route('super-admin.news.index', ['kantor' => $office]) }}">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis fw-medium text-dark">{{ $office }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>

            {{-- SEARCH SECTION --}}
            <li class="nav-item">
                <form class="search-form" action="{{ route('super-admin.news.index') }}" method="GET">
                    <i class="icon-search"></i>
                    <input type="search" name="q" class="form-control" placeholder="Search Here" title="Search here"
                        value="{{ request('q') }}">
                </form>
            </li>

            {{-- NOTIFICATION --}}
            <!-- <li class="nav-item dropdown">
                <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="icon-bell"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                    aria-labelledby="notificationDropdown">
                    <a class="dropdown-item py-3 border-bottom">
                        <p class="mb-0 fw-medium float-start">You have 4 new notifications </p>
                        <span class="badge badge-pill badge-primary float-end">View all</span>
                    </a>
                    <a class="dropdown-item preview-item py-3">
                        <div class="preview-thumbnail">
                            <i class="mdi mdi-alert m-auto text-primary"></i>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                            <p class="fw-light small-text mb-0"> Just now </p>
                        </div>
                    </a>
                </div>
            </li> -->

            {{-- PROFILE ACCOUNT --}}
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="{{ asset('assets/images/profile-default.jpg') }}"
                        alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="{{ asset('assets/images/profile-default.jpg') }}"
                            alt="Profile image">
                        <p class="mb-1 mt-3 fw-semibold">{{ auth()->user()->name ?? '' }}</p>
                        <p class="fw-light text-muted mb-0">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <!-- <hr class="w-100"> -->
                    <a class="dropdown-item" href="{{ route('profile.profile-super-admin') }}">
                        <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="logout-btn dropdown-item block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>

<style>
    /* ==================== CUSTOM SUBMENU ==================== */
    .dropdown-menu.custom-submenu {
        display: none;
        position: absolute;
        top: 0;
        right: 100%; /* Muncul di sebelah kiri */
        margin-left: 5px;
        background: #fff;
        border: 1px solid #ddd;
        min-width: 220px;
        border-radius: 6px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        animation: fadeInLeft 0.25s ease forwards;
    }

    /* Animasi muncul dari kanan ke kiri */
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Hover untuk memunculkan submenu */
    .dropdown-menu>.custom-submenu-toggle:hover+.custom-submenu {
        display: block;
    }

    /* Jika parent di-hover, submenu tetap terbuka */
    .dropdown-menu.custom-submenu:hover {
        display: block;
    }

    /* Styling untuk item submenu */
    .dropdown-menu.custom-submenu .dropdown-item {
        padding: 8px 15px;
        transition: all 0.2s ease;
    }

    .dropdown-menu.custom-submenu .dropdown-item:hover {
        background: var(--bs-primary);
        color: #fff;
    }

    /* Icon chevron */
    .submenu-icon {
        transition: transform 0.3s ease;
    }

    /* Saat hover, icon bergerak */
    .custom-submenu-toggle:hover .submenu-icon {
        transform: translateX(-3px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                // Tutup semua submenu lain
                document.querySelectorAll('.custom-submenu').forEach(menu => {
                    if (menu !== this.nextElementSibling) {
                        menu.style.display = 'none';
                    }
                });

                // Toggle submenu saat ini
                const submenu = this.nextElementSibling;
                submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
            });
        });

        // Klik di luar dropdown untuk menutup semua submenu
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-item.dropdown')) {
                document.querySelectorAll('.custom-submenu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });
    });
</script>