<header class="main-header">
    <div class="header-content">
        <!-- Mobile Menu Toggle -->
        <button class="btn-toggle-sidebar d-lg-none" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Page Title -->
        <div class="page-title">
            <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>

        <!-- Header Actions -->
        <div class="header-actions d-flex align-items-center">
            <!-- Search -->
            <div class="search-container me-3 d-none d-md-block">
                <form action="{{ route('news.index') }}" method="GET" class="input-group">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Cari judul berita...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Notifications -->
            <div class="dropdown me-3">
                <button class="btn btn-outline-secondary position-relative" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                        <span class="visually-hidden">notifikasi baru</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
                    <li>
                        <h6 class="dropdown-header">Notifikasi</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="notification-item">
                                <div class="notification-icon bg-primary">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="notification-content">
                                    <h6 class="notification-title">Dokumen Baru</h6>
                                    <p class="notification-text">Ada dokumen baru yang perlu direview</p>
                                    <small class="text-muted">2 menit yang lalu</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="notification-item">
                                <div class="notification-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="notification-content">
                                    <h6 class="notification-title">Persetujuan Selesai</h6>
                                    <p class="notification-text">Permohonan telah disetujui</p>
                                    <small class="text-muted">1 jam yang lalu</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="notification-item">
                                <div class="notification-icon bg-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="notification-content">
                                    <h6 class="notification-title">Deadline Mendekati</h6>
                                    <p class="notification-text">3 perkara mendekati deadline</p>
                                    <small class="text-muted">3 jam yang lalu</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-center" href="#">
                            Lihat Semua Notifikasi
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Profile -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/images/profile-default.jpg') }}" alt="User Avatar"
                        class="user-avatar-sm me-2">
                    <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="dropdown-header">
                            <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong><br>
                            <small class="text-muted">{{ auth()->user()->email ?? 'admin@kemenkumham.go.id' }}</small>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle me-2"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i>
                            Pengaturan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-question-circle me-2"></i>
                            Bantuan
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>