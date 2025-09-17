<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kemenkum Maluku - Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/profile_user.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo_kemenkum.png') }}" />
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <header class="app-header">
            <div class="header-content">
                <div class="logo-container">
                    <img src="{{ asset('assets/images/logo/logo_kemenkum.png') }}" alt="Logo Kemenkum" class="logo">
                    <div class="logo-text">
                        <h1>Kemenkumham Maluku</h1>
                        <p>Kementerian Hukum dan Hak Asasi Manusia</p>
                    </div>
                </div>
                <nav class="user-nav">
                    <a href="{{ route('dashboard') }}" class="nav-item"><i class="fas fa-home"></i> Beranda</a>
                    <div class="user-dropdown">
                        <button class="user-btn">
                            <span style="color: white;">{{ Auth::user()->name }}</span>
                            <img src="{{ asset('assets/images/profile-default.jpg') }}" alt="{{ Auth::user()->name }}" class="user-avatar">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="{{ route('profile.edit') }}" class="active"><i class="fas fa-user"></i> Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </a>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="app-main">
            <div class="profile-container">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer">
            <div class="footer-content">
                <p>&copy; {{ date('Y') }} Kemenkumham Maluku. Semua hak dilindungi.</p>
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/js/profile_user.js') }}"></script>
</body>
</html>