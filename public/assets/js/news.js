// public/js/news.js

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize news functionality
    initializeNews();
    
    function initializeNews() {
        initializeSearch();
        initializeLazyLoading();
        initializeReadMore();
        initializeFilterTags();
        initializeNewsCards();
    }
    
    // Search functionality
    function initializeSearch() {
        const searchForm = document.getElementById('newsSearchForm');
        const resetBtn = document.getElementById('resetSearch');
        const searchInputs = document.querySelectorAll('.search-input, .search-select');
        
        if (searchForm) {
            // Auto-submit on select change
            const selects = searchForm.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    searchForm.submit();
                });
            });
            
            // Search input with debounce
            const searchInput = document.getElementById('search');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        // Optional: Auto-submit after typing (uncomment if needed)
                        // searchForm.submit();
                    }, 1000);
                });
            }
        }
        
        // Reset functionality
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                // Clear all form inputs
                searchInputs.forEach(input => {
                    if (input.type === 'text') {
                        input.value = '';
                    } else if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    }
                });
                
                // Submit form to reset
                searchForm.submit();
            });
        }
    }
    
    // Lazy loading for images
    function initializeLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }
    
    // Read more functionality with smooth animation
    function initializeReadMore() {
        document.querySelectorAll('.read-more-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Add loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                this.style.pointerEvents = 'none';
                
                // Allow normal navigation after short delay
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.pointerEvents = 'auto';
                }, 300);
            });
        });
    }
    
    // Filter tags functionality
    function initializeFilterTags() {
        document.querySelectorAll('.remove-filter').forEach(removeBtn => {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add fade out animation
                const filterTag = this.closest('.filter-tag');
                filterTag.style.opacity = '0.5';
                filterTag.style.transform = 'scale(0.9)';
                
                // Navigate after animation
                setTimeout(() => {
                    window.location.href = this.href;
                }, 200);
            });
        });
    }
    
    // News cards interactions
    function initializeNewsCards() {
        const newsCards = document.querySelectorAll('.news-card');
        
        newsCards.forEach(card => {
            // Add hover effect enhancement
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
            
            // Add click to read functionality
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on links or buttons
                if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON' && !e.target.closest('a')) {
                    const readMoreBtn = this.querySelector('.read-more-btn');
                    if (readMoreBtn) {
                        readMoreBtn.click();
                    }
                }
            });
        });
    }
    
    // Category filter functionality
    function initializeCategoryFilter() {
        const categoryButtons = document.querySelectorAll('.category-filter-btn');
        const newsCards = document.querySelectorAll('.news-card');
        
        categoryButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.dataset.category;
                
                // Update active button
                categoryButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Filter cards
                newsCards.forEach(card => {
                    const cardCategory = card.dataset.category;
                    
                    if (category === 'all' || cardCategory === category) {
                        card.style.display = 'block';
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        
                        setTimeout(() => {
                            card.style.transition = 'all 0.3s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 100);
                    } else {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(-20px)';
                        
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }
    
    // Search suggestions functionality
    function initializeSearchSuggestions() {
        const searchInput = document.getElementById('search');
        if (!searchInput) return;
        
        let suggestionsContainer = document.createElement('div');
        suggestionsContainer.className = 'search-suggestions';
        searchInput.parentNode.appendChild(suggestionsContainer);
        
        // Sample suggestions - you can populate this from your database
        const suggestions = [
            'Peraturan Baru Kemenkumham',
            'Pelayanan Hukum Maluku',
            'Imigrasi Ambon',
            'Hak Asasi Manusia',
            'Pemasyarakatan',
            'Notaris dan PPAT',
            'Administrasi Hukum Umum'
        ];
        
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            suggestionsContainer.innerHTML = '';
            
            if (query.length > 2) {
                const filteredSuggestions = suggestions.filter(s => 
                    s.toLowerCase().includes(query)
                );
                
                if (filteredSuggestions.length > 0) {
                    suggestionsContainer.style.display = 'block';
                    filteredSuggestions.slice(0, 5).forEach(suggestion => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.className = 'suggestion-item';
                        suggestionItem.textContent = suggestion;
                        suggestionItem.addEventListener('click', function() {
                            searchInput.value = suggestion;
                            suggestionsContainer.style.display = 'none';
                            document.getElementById('newsSearchForm').submit();
                        });
                        suggestionsContainer.appendChild(suggestionItem);
                    });
                } else {
                    suggestionsContainer.style.display = 'none';
                }
            } else {
                suggestionsContainer.style.display = 'none';
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.style.display = 'none';
            }
        });
    }
    
    // Loading state management
    function showLoading() {
        const newsContainer = document.querySelector('.news-container');
        if (newsContainer) {
            newsContainer.classList.add('loading');
        }
    }
    
    function hideLoading() {
        const newsContainer = document.querySelector('.news-container');
        if (newsContainer) {
            newsContainer.classList.remove('loading');
        }
    }
    
    // Smooth scroll to results
    function scrollToResults() {
        const newsContainer = document.querySelector('.news-container');
        if (newsContainer) {
            newsContainer.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
    
    // Image error handling
    function initializeImageErrorHandling() {
        document.querySelectorAll('.news-image img').forEach(img => {
            img.addEventListener('error', function() {
                const noImageDiv = document.createElement('div');
                noImageDiv.className = 'no-image';
                noImageDiv.innerHTML = `
                    <i class="fas fa-newspaper"></i>
                    <span>Kemenkumham Maluku</span>
                `;
                this.parentNode.replaceChild(noImageDiv, this);
            });
        });
    }
    
    // Initialize image error handling
    initializeImageErrorHandling();
    
    // Initialize search suggestions
    initializeSearchSuggestions();
    
    // Add CSS for search suggestions
    const suggestionStyles = `
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .suggestion-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s;
        }
        
        .suggestion-item:hover {
            background-color: #f9fafb;
        }
        
        .suggestion-item:last-child {
            border-bottom: none;
        }
        
        .search-field {
            position: relative;
        }
    `;
    
    // Inject styles
    const styleSheet = document.createElement('style');
    styleSheet.textContent = suggestionStyles;
    document.head.appendChild(styleSheet);
    
    // Performance optimization: Debounced resize handler
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            // Recalculate layout if needed
            const newsGrid = document.querySelector('.news-grid');
            if (newsGrid) {
                // Force reflow for proper grid layout
                newsGrid.style.display = 'none';
                newsGrid.offsetHeight; // Trigger reflow
                newsGrid.style.display = 'grid';
            }
        }, 250);
    });
    
    // Accessibility enhancements
    function enhanceAccessibility() {
        // Add ARIA labels to interactive elements
        document.querySelectorAll('.read-more-btn').forEach(btn => {
            const newsTitle = btn.closest('.news-card').querySelector('.news-title a').textContent;
            btn.setAttribute('aria-label', `Baca selengkapnya: ${newsTitle}`);
        });
        
        // Add keyboard navigation for filter tags
        document.querySelectorAll('.remove-filter').forEach(link => {
            link.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
        
        // Add focus indicators
        const focusableElements = document.querySelectorAll('a, button, input, select');
        focusableElements.forEach(el => {
            el.addEventListener('focus', function() {
                this.style.outline = '2px solid #3b82f6';
                this.style.outlineOffset = '2px';
            });
            
            el.addEventListener('blur', function() {
                this.style.outline = '';
                this.style.outlineOffset = '';
            });
        });
    }
    
    // Initialize accessibility enhancements
    enhanceAccessibility();
    
    // Export functions for external use
    window.newsModule = {
        showLoading,
        hideLoading,
        scrollToResults,
        initializeNews
    };
    
    // Analytics tracking (if needed)
    function trackNewsInteraction(action, category, label) {
        if (typeof gtag !== 'undefined') {
            gtag('event', action, {
                event_category: category,
                event_label: label
            });
        }
    }
    
    // Track search submissions
    const searchForm = document.getElementById('newsSearchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const searchQuery = document.getElementById('search').value;
            const category = document.getElementById('category').value;
            trackNewsInteraction('search', 'news', `${searchQuery} | ${category}`);
        });
    }
    
    // Track news card clicks
    document.querySelectorAll('.read-more-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const newsTitle = this.closest('.news-card').querySelector('.news-title a').textContent;
            trackNewsInteraction('click', 'news_card', newsTitle);
        });
    });
    
});