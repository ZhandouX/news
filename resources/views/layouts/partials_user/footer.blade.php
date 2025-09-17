{{-- layouts/partials_user/footer.blade.php --}}
<footer>
    <div class="footer-container">
        {{-- Footer Logo Section --}}
        <div class="footer-logo">
            <img src="{{ asset('assets/images/logo/logo_kemenkumham.png') }}" alt="Logo Kemenkumham" loading="lazy">
            <div class="footer-logo-text">
                <h3>Kementerian Hukum dan HAM</h3>
                <p>Kantor Wilayah Maluku</p>
            </div>
        </div>

        {{-- Footer Content Grid --}}
        <div class="footer-content">
            {{-- Quick Links --}}
            <div class="footer-section">
                <h4>Tautan Cepat</h4>
                <div class="footer-links">
                    <a href="{{ route('user.dashboard') }}">
                        <i class="fas fa-angle-right"></i>
                        Beranda
                    </a>
                    <a href="{{ route('user.about_us') }}">
                        <i class="fas fa-angle-right"></i>
                        Tentang Kami
                    </a>
                    <a href="{{ route('user.services') }}">
                        <i class="fas fa-angle-right"></i>
                        Layanan
                    </a>
                    <a href="{{ route('user.galery') }}">
                        <i class="fas fa-angle-right"></i>
                        Galeri
                    </a>
                    <a href="{{ route('user.contact') }}">
                        <i class="fas fa-angle-right"></i>
                        Kontak
                    </a>
                </div>
            </div>

            {{-- Services --}}
            <div class="footer-section">
                <h4>Layanan Utama</h4>
                <div class="footer-links">
                    <a href="#">
                        <i class="fas fa-angle-right"></i>
                        Pelayanan Paspor
                    </a>
                    <a href="#">
                        <i class="fas fa-angle-right"></i>
                        Pelayanan Visa
                    </a>
                    <a href="#">
                        <i class="fas fa-angle-right"></i>
                        Pelayanan Keimigrasian
                    </a>
                    <a href="#">
                        <i class="fas fa-angle-right"></i>
                        Pelayanan Hukum
                    </a>
                    <a href="#">
                        <i class="fas fa-angle-right"></i>
                        Pelayanan HAM
                    </a>
                    <a href="#">
                        <i class="fas fa-angle-right"></i>
                        Legalisir Dokumen
                    </a>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="footer-section">
                <h4>Informasi Kontak</h4>
                <div class="contact-info-footer">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="contact-details">
                            <p>Jl. Raya Pattimura No. 1</p>
                            <p>Ambon, Maluku 97116</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div class="contact-details">
                            <p>+62 911 123456</p>
                            <p>+62 911 654321</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div class="contact-details">
                            <p>info@kemenkumham-maluku.go.id</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div class="contact-details">
                            <p>Senin - Jumat: 08:00 - 16:00</p>
                            <p>Sabtu - Minggu: Tutup</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Newsletter & Social Media --}}
            <div class="footer-section">
                <h4>Ikuti Kami</h4>
                <p class="footer-description">
                    Dapatkan informasi terbaru seputar layanan dan kebijakan dari Kemenkumham Maluku
                </p>
                
                {{-- Newsletter Subscription --}}
                <div class="newsletter">
                    <form action="#" method="POST" class="newsletter-form">
                        @csrf
                        <input type="email" name="email" placeholder="Email Anda" required>
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>

                {{-- Social Media Links --}}
                <div class="social-media">
                    <div class="social-links">
                        <a href="#" target="_blank" rel="noopener" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} Kementerian Hukum dan HAM Kantor Wilayah Maluku. All rights reserved.</p>
                </div>
                <div class="footer-bottom-links">
                    <a href="#">Kebijakan Privasi</a>
                    <span class="separator">|</span>
                    <a href="#">Syarat & Ketentuan</a>
                    <span class="separator">|</span>
                    <a href="#">Peta Situs</a>
                </div>
            </div>
        </div>

        {{-- Back to Top Button --}}
        <button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
            <i class="fas fa-chevron-up"></i>
        </button>
    </div>
</footer>

{{-- Footer JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Back to top button functionality
    const backToTopButton = document.getElementById('backToTop');
    
    if (backToTopButton) {
        // Show/hide back to top button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        // Smooth scroll to top when button is clicked
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            const button = this.querySelector('button');
            const originalButtonContent = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            // Simulate API call (replace with actual implementation)
            setTimeout(() => {
                // Success feedback
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.style.background = '#10b981';
                
                // Reset form
                this.querySelector('input[type="email"]').value = '';
                
                // Show success message (you can customize this)
                alert('Terima kasih! Email Anda telah berhasil didaftarkan.');
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    button.innerHTML = originalButtonContent;
                    button.style.background = '#fbbf24';
                    button.disabled = false;
                }, 3000);
            }, 2000);
        });
    }
    
    // Social media link tracking (optional)
    const socialLinks = document.querySelectorAll('.social-links a');
    socialLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const platform = this.querySelector('i').classList[1].replace('fa-', '');
            console.log(`Social media clicked: ${platform}`);
            // Add analytics tracking here if needed
        });
    });
    
    // Footer links hover effect enhancement
    const footerLinks = document.querySelectorAll('.footer-links a');
    footerLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.paddingLeft = '1rem';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.paddingLeft = '0';
        });
    });
    
    // Newsletter email validation
    const emailInput = document.querySelector('.newsletter-form input[type="email"]');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#ef4444';
                this.setCustomValidity('Format email tidak valid');
            } else {
                this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                this.setCustomValidity('');
            }
        });
    }
});
</script>