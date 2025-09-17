<nav class="navbar" id="navbar">
    <div class="logo">
        <img src="{{ asset('assets/images/logo/logo_kemenkumham.png') }}" alt="Logo Kemenkumham">
        <div class="logo-text">
            <h1>Kemenkumham Maluku</h1>
            <p>Kantor Wilayah Maluku</p>
        </div>
    </div>

    <div class="nav-profile">
        @if (Route::has('login'))
            @auth
                {{-- Jika user sudah login, tampilkan foto profil & menu dropdown --}}
                <img src="{{ asset('assets/images/profile-default.jpg') }}" alt="Profil Admin">
                <div class="profile-dropdown">
                    <ul>
                        <li><a href="dashboard">Dashboard</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    style="background: none; border: none; color: red; cursor: pointer;">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                {{-- Jika user belum login, tampilkan tombol login/register --}}
                <a href="{{ route('login') }}" class="login-btn"><i class="fas fa-sign-in"></i>
                     Masuk
                </a>
            @endauth
        @endif
    </div>
</nav>