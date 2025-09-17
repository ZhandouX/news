// Admin Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Sidebar Toggle for Mobile
    const toggleSidebar = document.getElementById('toggleSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    const sidebar = document.getElementById('sidebar');
    
    // Create overlay for mobile
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);
    
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    }
    
    if (closeSidebar) {
        closeSidebar.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        });
    }
    
    // Close sidebar when clicking overlay
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    });
    
    // Close sidebar on window resize if mobile
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1200) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
    
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert && alert.parentNode) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
    
    // Smooth scrolling for sidebar navigation
    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Only prevent default for dropdown toggles
            if (this.hasAttribute('data-bs-toggle')) {
                return;
            }
        });
    });
    
    // Add active class to current page navigation
    const currentPath = window.location.pathname;
    navLinks.forEach(function(link) {
        const href = link.getAttribute('href');
        if (href && currentPath.includes(href.split('/').pop())) {
            link.classList.add('active');
            
            // Expand parent dropdown if it's a submenu
            const parentCollapse = link.closest('.collapse');
            if (parentCollapse) {
                parentCollapse.classList.add('show');
                const parentToggle = document.querySelector(`[data-bs-target="#${parentCollapse.id}"]`);
                if (parentToggle) {
                    parentToggle.classList.add('active');
                    parentToggle.setAttribute('aria-expanded', 'true');
                }
            }
        }
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-container input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch(this.value);
            }
        });
        
        // Search button click
        const searchButton = document.querySelector('.search-container button');
        if (searchButton) {
            searchButton.addEventListener('click', function() {
                performSearch(searchInput.value);
            });
        }
    }
    
    function performSearch(query) {
        if (query.trim()) {
            console.log('Searching for:', query);
            // Implement your search logic here
            // Example: window.location.href = `/admin/search?q=${encodeURIComponent(query)}`;
        }
    }
    
    // Notification mark as read
    const notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach(function(item) {
        item.addEventListener('click', function() {
            this.style.opacity = '0.6';
            // Implement mark as read logic here
        });
    });
    
    // Real-time clock
    function updateClock() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Asia/Jayapura' // Waktu Maluku
        };
        
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            clockElement.textContent = now.toLocaleDateString('id-ID', options);
        }
    }
    
    // Update clock every second
    updateClock();
    setInterval(updateClock, 1000);
    
    // Tooltip initialization
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    // Popover initialization
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
    
    // Data table initialization (if using DataTables)
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.data-table').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json'
            },
            pageLength: 25,
            order: [[0, 'desc']]
        });
    }
    
    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const itemName = this.getAttribute('data-item-name') || 'item ini';
            
            if (confirm(`Apakah Anda yakin ingin menghapus ${itemName}? Tindakan ini tidak dapat dibatalkan.`)) {
                const form = this.closest('form');
                if (form) {
                    form.submit();
                } else {
                    window.location.href = this.getAttribute('href');
                }
            }
        });
    });
    
    // File upload preview
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.file-preview');
                    if (preview) {
                        if (file.type.startsWith('image/')) {
                            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
                        } else {
                            preview.innerHTML = `<div class="alert alert-info">File terpilih: ${file.name}</div>`;
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
    
    // Progress bars animation
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(function(bar) {
        const width = bar.getAttribute('aria-valuenow');
        setTimeout(function() {
            bar.style.width = width + '%';
        }, 500);
    });
    
    // Counter animation for stats cards
    const counters = document.querySelectorAll('.stats-card h2');
    counters.forEach(function(counter) {
        const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = function() {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current).toLocaleString('id-ID');
                setTimeout(updateCounter, 20);
            } else {
                counter.textContent = target.toLocaleString('id-ID');
            }
        };
        
        // Start animation when element is in view
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.disconnect();
                }
            });
        });
        
        observer.observe(counter);
    });
    
    // Lazy loading for images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(function(img) {
        imageObserver.observe(img);
    });
    
    // Auto-save form data to localStorage (for forms with auto-save class)
    const autoSaveForms = document.querySelectorAll('.auto-save-form');
    autoSaveForms.forEach(function(form) {
        const formId = form.getAttribute('id');
        if (!formId) return;
        
        // Load saved data
        const savedData = localStorage.getItem(`form_${formId}`);
        if (savedData) {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(function(key) {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        field.checked = data[key];
                    } else {
                        field.value = data[key];
                    }
                }
            });
        }
        
        // Save data on change
        form.addEventListener('input', function(e) {
            const formData = new FormData(form);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            localStorage.setItem(`form_${formId}`, JSON.stringify(data));
        });
        
        // Clear saved data on successful submit
        form.addEventListener('submit', function() {
            localStorage.removeItem(`form_${formId}`);
        });
    });
    
    // Print functionality
    const printButtons = document.querySelectorAll('.btn-print');
    printButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const printArea = document.querySelector('.print-area');
            if (printArea) {
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Print - Kemenkumham Maluku</title>
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            @media print {
                                .no-print { display: none !important; }
                                body { font-size: 12pt; }
                                .card { border: 1px solid #ddd !important; box-shadow: none !important; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            ${printArea.innerHTML}
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
                setTimeout(function() {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            } else {
                window.print();
            }
        });
    });
    
    // Export functionality
    const exportButtons = document.querySelectorAll('.btn-export');
    exportButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const format = this.getAttribute('data-format') || 'csv';
            const table = document.querySelector('.export-table');
            
            if (table && format === 'csv') {
                exportTableToCSV(table, 'data-export.csv');
            } else if (table && format === 'excel') {
                exportTableToExcel(table, 'data-export.xlsx');
            }
        });
    });
    
    function exportTableToCSV(table, filename) {
        const csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                let data = cols[j].textContent.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(','));
        }
        
        downloadCSV(csv.join('\n'), filename);
    }
    
    function downloadCSV(csv, filename) {
        const csvFile = new Blob([csv], { type: 'text/csv' });
        const downloadLink = document.createElement('a');
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
    
    // Theme toggle (if implemented)
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update icon
            const icon = this.querySelector('i');
            if (newTheme === 'dark') {
                icon.classList.replace('fa-moon', 'fa-sun');
            } else {
                icon.classList.replace('fa-sun', 'fa-moon');
            }
        });
        
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.body.setAttribute('data-theme', savedTheme);
        
        const icon = themeToggle.querySelector('i');
        if (savedTheme === 'dark') {
            icon.classList.replace('fa-moon', 'fa-sun');
        }
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('.search-container input');
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Escape to close modals/dropdowns
        if (e.key === 'Escape') {
            const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
            openDropdowns.forEach(function(dropdown) {
                const toggle = dropdown.previousElementSibling;
                if (toggle) {
                    bootstrap.Dropdown.getOrCreateInstance(toggle).hide();
                }
            });
        }
    });
    
    // Loading states for buttons
    const loadingButtons = document.querySelectorAll('.btn-loading');
    loadingButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const originalText = this.textContent;
            const loadingText = this.getAttribute('data-loading-text') || 'Loading...';
            
            this.disabled = true;
            this.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText}`;
            
            // Reset after 3 seconds (adjust as needed)
            setTimeout(function() {
                button.disabled = false;
                button.textContent = originalText;
            }, 3000);
        });
    });
    
    console.log('Admin dashboard initialized successfully');
});