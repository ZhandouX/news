document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Photo upload preview
    const photoInput = document.getElementById('photo');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('photo-preview');
                    preview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Remove photo button
    const removePhotoBtn = document.getElementById('remove-photo');
    if (removePhotoBtn) {
        removePhotoBtn.addEventListener('click', function() {
            const preview = document.getElementById('photo-preview');
            preview.src = preview.dataset.defaultSrc || '/images/default-avatar.jpg';
            const input = document.getElementById('photo');
            input.value = '';
        });
    }

    // Password strength meter
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            const password = this.value;
            let strength = 0;
            
            // Check password length
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Check for mixed case
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
            
            // Check for numbers
            if (/\d/.test(password)) strength += 1;
            
            // Check for special chars
            if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
            
            // Update UI
            const width = (strength / 5) * 100;
            strengthBar.style.width = `${width}%`;
            
            if (strength <= 1) {
                strengthBar.style.backgroundColor = '#e74c3c';
                strengthText.textContent = 'Lemah';
                strengthText.style.color = '#e74c3c';
            } else if (strength <= 3) {
                strengthBar.style.backgroundColor = '#f39c12';
                strengthText.textContent = 'Sedang';
                strengthText.style.color = '#f39c12';
            } else {
                strengthBar.style.backgroundColor = '#2ecc71';
                strengthText.textContent = 'Kuat';
                strengthText.style.color = '#2ecc71';
            }
            
            if (password.length === 0) {
                strengthBar.style.width = '0';
                strengthText.textContent = 'Kekuatan password';
                strengthText.style.color = '#6c757d';
            }
        });
    }

    // Delete account confirmation modal
    const deleteAccountBtn = document.getElementById('delete-account-btn');
    if (deleteAccountBtn) {
        const modal = document.getElementById('delete-confirm-modal');
        const closeModalButtons = document.querySelectorAll('.close-modal');
        
        deleteAccountBtn.addEventListener('click', function() {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
        
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    }

    // Form submission handling
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            }
        });
    });
});