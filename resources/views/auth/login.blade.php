<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN - PORTAL BERITA KANWIL KEMENKUM MALUKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo_kemenkum.png') }}" />
</head>
<body>
    <div class="auth-container">
        <div class="auth-image">
            <h2>Portal Berita Kemenkum</h2>
            <p>Masuk untuk mengakses berita terbaru, informasi hukum, dan update kebijakan dari Kementerian Hukum Republik Indonesia.</p>
        </div>
        
        <div class="auth-form">
            <div class="logo">
                <img src="{{ asset('assets/images/logo/logo_kemenkum.png') }}" alt="Logo Kemenkumham">
            </div>
            
            <div class="form-title">
                <h2>Masuk ke Akun Anda</h2>
                <p>Silakan masuk menggunakan email dan kata sandi yang terdaftar</p>
            </div>
            
            <!-- Session Status -->
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda">
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Masukkan kata sandi Anda">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label for="remember_me">Ingat saya</label>
                    </div>
                    <div class="forgot-password">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                        @endif
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Masuk</button>
                
                    <div class="divider">Privacy & Policy</div>
                
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling;
            
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>