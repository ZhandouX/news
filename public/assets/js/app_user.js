// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function () {

    // ========== NAVBAR RESPONSIVE FUNCTIONALITY ==========

    // Get mobile menu elements
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const navLinks = document.getElementById('nav-links');
    const navbar = document.getElementById('navbar');

    // Mobile menu toggle functionality
    if (mobileMenuToggle && navLinks) {
        mobileMenuToggle.addEventListener('click', function () {
            this.classList.toggle('active');
            navLinks.classList.toggle('mobile-active');

            // Prevent body scroll when menu is open
            if (navLinks.classList.contains('mobile-active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        // Close mobile menu when clicking on navigation links
        const navLinkItems = navLinks.querySelectorAll('a');
        navLinkItems.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenuToggle.classList.remove('active');
                navLinks.classList.remove('mobile-active');
                document.body.style.overflow = '';
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!mobileMenuToggle.contains(e.target) &&
                !navLinks.contains(e.target) &&
                navLinks.classList.contains('mobile-active')) {
                mobileMenuToggle.classList.remove('active');
                navLinks.classList.remove('mobile-active');
                document.body.style.overflow = '';
            }
        });
    }

    // ========== NAVBAR SCROLL EFFECT ==========

    // Navbar scroll functionality with throttling for performance
    let ticking = false;

    function updateNavbar() {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            requestAnimationFrame(updateNavbar);
            ticking = true;
        }
    });

    // ========== PROFILE DROPDOWN FUNCTIONALITY ==========

    const profileImg = document.querySelector('.nav-profile img');
    const dropdown = document.querySelector('.profile-dropdown');

    if (profileImg && dropdown) {
        profileImg.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!profileImg.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Close dropdown when pressing Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
            }
        });
    }

    // ========== RESPONSIVE SEARCH FUNCTIONALITY ==========

    const navSearch = document.querySelector('.nav-search');
    const searchInput = document.querySelector('.nav-search input');
    const searchButton = document.querySelector('.nav-search button');

    if (searchInput && searchButton) {
        // Focus search input when search button is clicked
        searchButton.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                searchInput.focus();
            }
        });

        // Handle search functionality
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    // Add your search functionality here
                    console.log('Searching for:', searchTerm);
                    // Example: window.location.href = '/search?q=' + encodeURIComponent(searchTerm);
                }
            }
        });
    }

    // ========== RESPONSIVE UTILITIES ==========

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            // Close mobile menu on resize to larger screen
            if (window.innerWidth > 767) {
                if (mobileMenuToggle) mobileMenuToggle.classList.remove('active');
                if (navLinks) navLinks.classList.remove('mobile-active');
                document.body.style.overflow = '';
            }

            // Close dropdown on resize
            if (dropdown) dropdown.classList.remove('active');
        }, 250);
    });

    // ========== SMOOTH SCROLLING FOR ANCHOR LINKS ==========

    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '#top') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ========== LAZY LOADING FOR IMAGES ==========

    // Simple lazy loading implementation
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(function (img) {
            imageObserver.observe(img);
        });
    }

    // ========== ACCESSIBILITY IMPROVEMENTS ==========

    // Add keyboard navigation support
    document.addEventListener('keydown', function (e) {
        // Toggle mobile menu with Enter/Space when focused
        if ((e.key === 'Enter' || e.key === ' ') &&
            e.target === mobileMenuToggle) {
            e.preventDefault();
            mobileMenuToggle.click();
        }
    });

    // ========== PERFORMANCE MONITORING ==========

    // Log performance metrics (optional - remove in production)
    if (typeof console !== 'undefined' && console.log) {
        window.addEventListener('load', function () {
            setTimeout(function () {
                if (performance && performance.timing) {
                    const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                    console.log('Page load time:', loadTime + 'ms');
                }
            }, 0);
        });
    }
});

// ========== ADDITIONAL RESPONSIVE FUNCTIONS ==========

// Function to detect mobile device
function isMobileDevice() {
    return window.innerWidth <= 767;
}

// Function to detect tablet device
function isTabletDevice() {
    return window.innerWidth > 767 && window.innerWidth <= 1024;
}

// Function to detect if touch device
function isTouchDevice() {
    return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
}

// Add CSS classes based on device type
document.documentElement.classList.add(
    isMobileDevice() ? 'mobile-device' : 'desktop-device'
);

if (isTouchDevice()) {
    document.documentElement.classList.add('touch-device');
}

// Update device classes on resize
window.addEventListener('resize', function () {
    document.documentElement.classList.remove('mobile-device', 'desktop-device');
    document.documentElement.classList.add(
        isMobileDevice() ? 'mobile-device' : 'desktop-device'
    );
});
