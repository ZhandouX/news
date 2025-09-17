// Enhanced Modern Dashboard JavaScript - Complete Version
document.addEventListener('DOMContentLoaded', function() {
    // Initialize application
    initializeApp();
});

function initializeApp() {
    // Elements
    const toggleBtn = document.querySelector('.toggle-btn');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileCloseBtn = document.querySelector('.mobile-close-btn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    
    // Initialize features
    initializeSidebar(toggleBtn, sidebar);
    initializeMobileMenu(mobileMenuBtn, mobileCloseBtn, sidebar);
    initializeNavigation();
    initializeUserProfile();
    initializeAnimations();
    initializeResponsiveHandling();
    initializeNotifications();
    initializeSearchFeature();
    initializeThemeToggle();
    initializeKeyboardShortcuts();
    initializePerformanceMonitoring();
    initializeAccessibility();
    
    // Show initial animations
    setTimeout(() => {
        document.body.classList.add('loaded');
        animateCards();
        showWelcomeAnimation();
    }, 100);
}

// Enhanced Sidebar functionality
function initializeSidebar(toggleBtn, sidebar) {
    if (!toggleBtn || !sidebar) return;

    toggleBtn.addEventListener('click', function() {
        const isCollapsed = sidebar.classList.contains('collapsed');
        
        if (!isCollapsed) {
            // Collapse animation
            sidebar.style.transition = 'width 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            sidebar.classList.add('collapsed');
            
            // Hide text elements with stagger
            const textElements = sidebar.querySelectorAll('.nav-text, .logo-text');
            textElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateX(-10px)';
                }, index * 50);
            });
            
            // Rotate toggle button
            setTimeout(() => {
                toggleBtn.querySelector('i').style.transform = 'rotate(180deg)';
            }, 200);
            
        } else {
            // Expand animation
            sidebar.classList.remove('collapsed');
            
            // Show text elements with stagger
            setTimeout(() => {
                const textElements = sidebar.querySelectorAll('.nav-text, .logo-text');
                textElements.forEach((el, index) => {
                    setTimeout(() => {
                        el.style.opacity = '1';
                        el.style.transform = 'translateX(0)';
                    }, index * 50);
                });
            }, 300);
            
            // Rotate toggle button back
            toggleBtn.querySelector('i').style.transform = 'rotate(0deg)';
        }
        
        // Store state
        try {
            localStorage.setItem('sidebarCollapsed', isCollapsed ? 'false' : 'true');
        } catch (e) {
            console.log('LocalStorage not available');
        }
    });

    // Restore saved state
    try {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            setTimeout(() => {
                sidebar.classList.add('collapsed');
            }, 100);
        }
    } catch (e) {
        console.log('LocalStorage not available');
    }
}

// Enhanced Mobile Menu
function initializeMobileMenu(mobileMenuBtn, mobileCloseBtn, sidebar) {
    if (!sidebar) return;

    // Create mobile overlay
    const overlay = document.createElement('div');
    overlay.className = 'mobile-overlay';
    document.body.appendChild(overlay);

    function showMobileMenu() {
        sidebar.classList.add('show');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Add subtle haptic feedback
        if (navigator.vibrate) {
            navigator.vibrate(50);
        }
        
        // Animate nav items
        const navItems = sidebar.querySelectorAll('.nav-item');
        navItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-30px)';
            setTimeout(() => {
                item.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, index * 100);
        });
    }

    function hideMobileMenu() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        
        // Reset nav items
        const navItems = sidebar.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.style.transition = '';
            item.style.opacity = '';
            item.style.transform = '';
        });
    }

    // Mobile menu button
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', showMobileMenu);
    }

    // Close button
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', hideMobileMenu);
    }

    // Close on overlay click
    overlay.addEventListener('click', hideMobileMenu);

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('show')) {
            hideMobileMenu();
        }
    });

    // Close on outside click (enhanced)
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 1025 && 
            !sidebar.contains(e.target) && 
            !mobileMenuBtn?.contains(e.target) &&
            sidebar.classList.contains('show')) {
            hideMobileMenu();
        }
    });
}

// Enhanced Navigation
function initializeNavigation() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        // Set active state
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
            link.closest('.nav-item').classList.add('active');
        }

        // Add hover effects
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
            const icon = this.querySelector('.nav-icon');
            if (icon) {
                icon.style.transform = 'scale(1.2) rotate(5deg)';
            }
        });

        link.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateX(0)';
            }
            const icon = this.querySelector('.nav-icon');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });

        // Handle submenu items
        if (link.nextElementSibling && link.nextElementSibling.classList.contains('submenu')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                const dropdownIcon = this.querySelector('.dropdown-icon');
                const isOpen = !submenu.classList.contains('hidden');
                
                if (isOpen) {
                    // Close submenu
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    setTimeout(() => {
                        submenu.style.maxHeight = '0';
                        submenu.style.opacity = '0';
                    }, 10);
                    
                    setTimeout(() => {
                        submenu.classList.add('hidden');
                    }, 300);
                    
                    if (dropdownIcon) {
                        dropdownIcon.style.transform = 'rotate(0deg)';
                    }
                } else {
                    // Open submenu
                    submenu.classList.remove('hidden');
                    submenu.style.maxHeight = '0';
                    submenu.style.opacity = '0';
                    
                    setTimeout(() => {
                        submenu.style.maxHeight = submenu.scrollHeight + 'px';
                        submenu.style.opacity = '1';
                    }, 10);
                    
                    if (dropdownIcon) {
                        dropdownIcon.style.transform = 'rotate(180deg)';
                    }
                }
            });
        }

        // Close mobile menu on navigation
        link.addEventListener('click', function() {
            if (window.innerWidth < 1025 && !this.getAttribute('href').startsWith('#')) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.querySelector('.mobile-overlay');
                if (sidebar && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    overlay?.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }
        });
    });

    // Add navigation breadcrumb functionality
    updateBreadcrumb();
}

// Enhanced User Profile
function initializeUserProfile() {
    const profileBtn = document.querySelector('.user-profile');
    const profileDropdown = document.querySelector('.profile-dropdown');

    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = !profileDropdown.classList.contains('hidden');
            
            if (isVisible) {
                profileDropdown.style.transform = 'translateY(-10px) scale(0.95)';
                profileDropdown.style.opacity = '0';
                setTimeout(() => {
                    profileDropdown.classList.add('hidden');
                }, 200);
            } else {
                profileDropdown.classList.remove('hidden');
                profileDropdown.style.transform = 'translateY(-10px) scale(0.95)';
                profileDropdown.style.opacity = '0';
                
                setTimeout(() => {
                    profileDropdown.style.transform = 'translateY(0) scale(1)';
                    profileDropdown.style.opacity = '1';
                }, 10);
            }
        });

        // Enhanced close dropdown
        document.addEventListener('click', function() {
            if (!profileDropdown.classList.contains('hidden')) {
                profileDropdown.style.transform = 'translateY(-10px) scale(0.95)';
                profileDropdown.style.opacity = '0';
                setTimeout(() => {
                    profileDropdown.classList.add('hidden');
                }, 200);
            }
        });
    }
}

// Enhanced Animations
function initializeAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
                element.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe cards and other elements
    const animatedElements = document.querySelectorAll('.card, .stats-card, .activity-item');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(el);
    });

    // Add loading animation to buttons
    document.addEventListener('click', function(e) {
        if (e.target.matches('.btn, .nav-link, .user-profile')) {
            const element = e.target;
            element.style.transform = 'scale(0.95)';
            setTimeout(() => {
                element.style.transform = '';
            }, 150);
        }
    });

    // Parallax effect for decorative elements
    initializeParallax();
}

// Responsive Handling
function initializeResponsiveHandling() {
    let resizeTimer;
    
    function handleResize() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.mobile-overlay');
        
        if (window.innerWidth >= 1025) {
            // Desktop mode
            if (sidebar) {
                sidebar.classList.remove('show');
                sidebar.style.transform = '';
            }
            if (overlay) {
                overlay.classList.remove('show');
            }
            document.body.style.overflow = '';
        }
        
        // Update viewport height for mobile
        updateViewportHeight();
    }

    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(handleResize, 250);
    });

    // Touch handling for mobile with enhanced gestures
    let touchStartX = 0;
    let touchEndX = 0;
    let touchStartY = 0;
    let touchEndY = 0;
    let touchStartTime = 0;

    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
        touchStartTime = Date.now();
    });

    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const timeThreshold = 500; // Max time for swipe gesture
        const sidebar = document.getElementById('sidebar');
        
        if (!sidebar || window.innerWidth >= 1025) return;

        const swipeDistance = touchEndX - touchStartX;
        const swipeTime = Date.now() - touchStartTime;
        const verticalSwipe = Math.abs(touchEndY - touchStartY);
        
        // Only trigger if it's a horizontal swipe and within time limit
        if (swipeTime > timeThreshold || verticalSwipe > 100) return;
        
        // Swipe right to open
        if (swipeDistance > swipeThreshold && touchStartX < 50 && !sidebar.classList.contains('show')) {
            sidebar.classList.add('show');
            document.querySelector('.mobile-overlay')?.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Haptic feedback
            if (navigator.vibrate) {
                navigator.vibrate(50);
            }
        }
        
        // Swipe left to close
        if (swipeDistance < -swipeThreshold && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            document.querySelector('.mobile-overlay')?.classList.remove('show');
            document.body.style.overflow = '';
        }
    }
}

// Initialize Notifications
function initializeNotifications() {
    // Create notification container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-6 right-6 z-50 space-y-3';
        document.body.appendChild(container);
    }

    // Check for notification permissions
    if ('Notification' in window && Notification.permission === 'default') {
        // Optionally ask for notification permission
        // Notification.requestPermission();
    }
}

// Initialize Search Feature
function initializeSearchFeature() {
    const searchInput = document.querySelector('.search-input');
    const searchResults = document.querySelector('.search-results');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', debounce(function(e) {
            const query = e.target.value.trim();
            
            if (query.length > 2) {
                performSearch(query);
            } else {
                hideSearchResults();
            }
        }, 300));
        
        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults?.contains(e.target)) {
                hideSearchResults();
            }
        });
    }
}

// Initialize Theme Toggle
function initializeThemeToggle() {
    const themeToggle = document.querySelector('.theme-toggle');
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            toggleTheme();
        });
        
        // Load saved theme
        loadSavedTheme();
    }
}

// Initialize Keyboard Shortcuts
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Ctrl/Cmd + B for sidebar toggle
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            const toggleBtn = document.querySelector('.toggle-btn');
            if (toggleBtn) {
                toggleBtn.click();
            }
        }
        
        // Esc to close modals/dropdowns
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    });
}

// Initialize Performance Monitoring
function initializePerformanceMonitoring() {
    // Monitor long tasks
    if ('PerformanceObserver' in window) {
        try {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.duration > 50) {
                        console.warn('Long task detected:', entry.duration + 'ms');
                    }
                }
            });
            observer.observe({ entryTypes: ['longtask'] });
        } catch (e) {
            // Browser doesn't support longtask entries
        }
    }
    
    // Track Core Web Vitals
    trackWebVitals();
}

// Initialize Accessibility Features
function initializeAccessibility() {
    // Skip link functionality
    const skipLink = document.querySelector('.skip-link');
    if (skipLink) {
        skipLink.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.focus();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
    
    // Keyboard navigation for dropdowns
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('using-keyboard');
        }
    });
    
    document.addEventListener('mousedown', function() {
        document.body.classList.remove('using-keyboard');
    });
}

// Animate cards function
function animateCards() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Show welcome animation
function showWelcomeAnimation() {
    const welcomeMessage = document.querySelector('.welcome-message');
    if (welcomeMessage) {
        setTimeout(() => {
            welcomeMessage.classList.add('animate-slide-in-up');
        }, 500);
    }
}

// Initialize parallax effect
function initializeParallax() {
    const parallaxElements = document.querySelectorAll('.parallax');
    
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', throttle(function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            
            parallaxElements.forEach(element => {
                element.style.transform = `translateY(${rate}px)`;
            });
        }, 16));
    }
}

// Update viewport height for mobile
function updateViewportHeight() {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}

// Update breadcrumb
function updateBreadcrumb() {
    const breadcrumb = document.querySelector('.breadcrumb');
    if (breadcrumb) {
        const currentPath = window.location.pathname;
        const pathSegments = currentPath.split('/').filter(segment => segment);
        
        // Build breadcrumb HTML
        let breadcrumbHTML = '<a href="/" class="breadcrumb-item">Home</a>';
        let currentUrl = '';
        
        pathSegments.forEach((segment, index) => {
            currentUrl += '/' + segment;
            const isLast = index === pathSegments.length - 1;
            const displayName = segment.charAt(0).toUpperCase() + segment.slice(1);
            
            if (isLast) {
                breadcrumbHTML += ` <span class="breadcrumb-separator">></span> <span class="breadcrumb-current">${displayName}</span>`;
            } else {
                breadcrumbHTML += ` <span class="breadcrumb-separator">></span> <a href="${currentUrl}" class="breadcrumb-item">${displayName}</a>`;
            }
        });
        
        breadcrumb.innerHTML = breadcrumbHTML;
    }
}

// Perform search
function performSearch(query) {
    // Mock search functionality - replace with actual search logic
    const searchResults = document.querySelector('.search-results');
    
    if (searchResults) {
        // Show loading state
        searchResults.innerHTML = '<div class="search-loading">Mencari...</div>';
        searchResults.classList.remove('hidden');
        
        // Simulate API call
        setTimeout(() => {
            const mockResults = [
                { title: 'Dashboard Overview', url: '/dashboard', type: 'page' },
                { title: 'User Management', url: '/users', type: 'page' },
                { title: 'Settings', url: '/settings', type: 'page' }
            ].filter(item => item.title.toLowerCase().includes(query.toLowerCase()));
            
            if (mockResults.length > 0) {
                const resultsHTML = mockResults.map(result => 
                    `<a href="${result.url}" class="search-result-item">
                        <i class="fas fa-${result.type === 'page' ? 'file' : 'search'}"></i>
                        <span>${result.title}</span>
                    </a>`
                ).join('');
                
                searchResults.innerHTML = resultsHTML;
            } else {
                searchResults.innerHTML = '<div class="search-no-results">Tidak ada hasil ditemukan</div>';
            }
        }, 500);
    }
}

// Hide search results
function hideSearchResults() {
    const searchResults = document.querySelector('.search-results');
    if (searchResults) {
        searchResults.classList.add('hidden');
    }
}

// Toggle theme
function toggleTheme() {
    const currentTheme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    document.body.classList.toggle('dark-theme');
    
    try {
        localStorage.setItem('theme', newTheme);
    } catch (e) {
        console.log('LocalStorage not available');
    }
    
    // Animate theme change
    document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
    setTimeout(() => {
        document.body.style.transition = '';
    }, 300);
}

// Load saved theme
function loadSavedTheme() {
    try {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-theme');
        }
    } catch (e) {
        console.log('LocalStorage not available');
    }
}

// Close all dropdowns
function closeAllDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown, .profile-dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.classList.add('hidden');
    });
}

// Track Web Vitals
function trackWebVitals() {
    // Largest Contentful Paint
    if ('PerformanceObserver' in window) {
        try {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    console.log('LCP:', entry.startTime);
                }
            });
            observer.observe({ entryTypes: ['largest-contentful-paint'] });
        } catch (e) {
            // Not supported
        }
    }
}

// Enhanced Toast notification function
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    // Remove existing toasts of the same type
    const existingToasts = container.querySelectorAll(`.toast-${type}`);
    existingToasts.forEach(toast => toast.remove());

    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
    const iconMap = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle', 
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    
    toast.innerHTML = `
        <i class="${iconMap[type]} toast-icon"></i>
        <span>${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    // Auto remove
    const timeoutId = setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 500);
    }, duration);

    // Clear timeout if manually closed
    toast.addEventListener('click', () => {
        clearTimeout(timeoutId);
    });

    return toast;
}

// Show loading overlay
function showLoading(message = 'Loading...') {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loading-overlay';
    loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50';
    loadingOverlay.innerHTML = `
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <div class="loading-spinner"></div>
            <span class="text-gray-700">${message}</span>
        </div>
    `;
    
    document.body.appendChild(loadingOverlay);
    
    setTimeout(() => {
        loadingOverlay.classList.add('opacity-100');
    }, 10);
    
    return loadingOverlay;
}

// Hide loading overlay
function hideLoading() {
    const loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        loadingOverlay.classList.add('opacity-0');
        setTimeout(() => {
            loadingOverlay.remove();
        }, 300);
    }
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Animation utilities
function slideDown(element, duration = 300) {
    element.style.height = '0';
    element.style.overflow = 'hidden';
    element.style.transition = `height ${duration}ms ease-out`;
    element.style.display = 'block';
    
    const height = element.scrollHeight;
    element.style.height = height + 'px';
    
    setTimeout(() => {
        element.style.height = '';
        element.style.overflow = '';
        element.style.transition = '';
    }, duration);
}

function slideUp(element, duration = 300) {
    element.style.height = element.offsetHeight + 'px';
    element.style.overflow = 'hidden';
    element.style.transition = `height ${duration}ms ease-out`;
    
    setTimeout(() => {
        element.style.height = '0';
    }, 10);
    
    setTimeout(() => {
        element.style.display = 'none';
        element.style.height = '';
        element.style.overflow = '';
        element.style.transition = '';
    }, duration);
}

// Export functions for global access
window.showToast = showToast;
window.showLoading = showLoading;
window.hideLoading = hideLoading;
window.slideDown = slideDown;
window.slideUp = slideUp;
window.debounce = debounce;
window.throttle = throttle;

// Initialize viewport height on load
updateViewportHeight();

// Console welcome message for developers
if (typeof console !== 'undefined') {
    console.log('%c🚀 Dashboard Enhanced JavaScript Loaded!', 
        'background: linear-gradient(90deg, #1a56a7, #e8a317); color: white; padding: 10px; border-radius: 5px; font-size: 14px; font-weight: bold;');
}