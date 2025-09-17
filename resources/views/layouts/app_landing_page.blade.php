<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kemenkum Maluku - Kantor Wilayah Maluku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app_user.css') }}" type="text/css">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo_kemenkum.png') }}" />
    @stack('styles')
</head>
<body>
    
    {{-- Navbar --}}
    @include('layouts.partials_user.navbar_landing_page')

    {{-- Halaman Konten --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials_user.footer')

    {{-- Script --}}
    <script>
        // Navbar scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Toggle dropdown
        document.addEventListener('DOMContentLoaded', function () {
            const profileImg = document.querySelector('.nav-profile img');
            const dropdown = document.querySelector('.profile-dropdown');

            profileImg.addEventListener('click', function () {
                dropdown.classList.toggle('active');
            });

            document.addEventListener('click', function (e) {
                if (!profileImg.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
