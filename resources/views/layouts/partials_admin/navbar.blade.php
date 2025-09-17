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
            {{-- CALENDAR (Single / Range) --}}
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
                <a class="nav-link dropdown-bordered dropdown-toggle dropdown-toggle-split" id="categoryDropdown"
                    href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Kategori
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                    aria-labelledby="categoryDropdown">

                    <a class="dropdown-item py-3">
                        <p class="mb-0 fw-medium float-start">
                            Menu Kategori
                        </p>
                    </a>
                    <div class="dropdown-divider"></div>

                    {{-- Submenu Kategori Berita --}}
                    <a class="dropdown-item dropdown-toggle custom-submenu-toggle" href="#">
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis fw-medium text-dark">
                                Kategori Berita
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-menu custom-submenu">
                        @foreach(($categories ?? []) as $cat)
                            <a class="dropdown-item preview-item"
                                href="{{ route('admin.news.index', ['kategori' => $cat]) }}">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis fw-medium text-dark">{{ $cat }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Submenu Sumber Berita --}}
                    <a class="dropdown-item dropdown-toggle custom-submenu-toggle" href="#">
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis fw-medium text-dark">Sumber Berita</p>
                        </div>
                    </a>
                    <div class="dropdown-menu custom-submenu">
                        @foreach(($sources ?? []) as $src)
                            <a class="dropdown-item preview-item"
                                href="{{ route('admin.news.index', ['sumber' => $src]) }}">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis fw-medium text-dark">{{ $src }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Submenu Kantor Berita --}}
                    <a class="dropdown-item dropdown-toggle custom-submenu-toggle" href="#">
                        <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis fw-medium text-dark">
                                Unit Utama
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-menu custom-submenu">
                        @foreach(($offices ?? []) as $office)
                            <a class="dropdown-item preview-item"
                                href="{{ route('admin.news.index', ['kantor' => $office]) }}">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis fw-medium text-dark">{{ $office }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>

            {{-- SEARCH --}}
            <li class="nav-item">
                <form class="search-form" action="{{ route('admin.news.index') }}" method="GET">
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

            {{-- PROFILE --}}
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="{{ asset('assets/images/profile-default.jpg') }}"
                        alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}"
                            alt="Profile image">
                        <p class="mb-1 mt-3 fw-semibold">{{ auth()->user()->name ?? '' }}</p>
                        <p class="fw-light text-muted mb-0">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile.profile-admin') }}"><i
                            class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
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
    /* Posisi submenu */
    .dropdown-menu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -5px;
    }

    /* Submenu styling untuk StarAdmin */
    .dropdown-menu .custom-submenu {
        position: absolute;
        top: 0;
        left: 100%;
        margin-top: -5px;
        display: none;
        min-width: 220px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    /* Tampilkan submenu saat aktif */
    .dropdown-menu .custom-submenu.show {
        display: block;
        animation: fadeIn 0.2s ease-in-out;
    }

    /* Animasi smooth */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.custom-submenu-toggle').forEach(function (toggle) {
            toggle.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                let submenu = this.nextElementSibling;

                // Tutup submenu lain biar rapi
                this.closest('.dropdown-menu').querySelectorAll('.custom-submenu.show').forEach(function (openSubmenu) {
                    if (openSubmenu !== submenu) {
                        openSubmenu.classList.remove("show");
                    }
                });

                submenu.classList.toggle("show");
            });
        });
    });
</script>