<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>Kemenkum Maluku - Kantor Wilayah Maluku</title>

    <!-- Preload font untuk performance -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        as="style">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/4.0.0/font/MaterialIcons-Regular.ttf">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app_user.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/news.css') }}" type="text/css">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo_kemenkum.png') }}" />
</head>

<body>

    {{-- Navbar --}}
    @include('layouts.partials_user.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials_user.footer')

    {{-- Library JavaScript --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('assets/js/app_user.js') }}"></script>
    <script src="{{ asset('assets/js/news/js') }}"></script>

    @stack('scripts')

    {{-- Service Worker Registration --}}
    <script>
        // Register service worker for PWA capabilities (optional)
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            window.addEventListener('load', function () {
                // Uncomment the line below if you have a service worker
                // navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>

</html>