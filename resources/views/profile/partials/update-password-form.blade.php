<form id="password-form" method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="current_password">Password Saat Ini</label>
        <div class="input-with-icon password-field">
            <i class="fa fa-lock"></i>
            <input id="current_password" type="password" name="current_password" required
                autocomplete="current-password" placeholder="Masukkan password saat ini">
            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <i class="fa fa-eye"></i>
            </button>
        </div>
        @error('current_password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password Baru</label>
        <div class="input-with-icon password-field">
            <i class="fa fa-key"></i>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Masukkan password baru">
            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <i class="fa fa-eye"></i>
            </button>
        </div>
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <div class="input-with-icon password-field">
            <i class="fa fa-key"></i>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Konfirmasi password baru">
            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>

    <div class="password-strength">
        <div class="strength-meter">
            <div class="strength-bar" id="strength-bar"></div>
        </div>
        <div class="strength-text" id="strength-text">Kekuatan password</div>
    </div>

    <div class="form-actions">
        <button type="submit" class="save-btn">
            <i class="mdi mdi-check"></i> Perbarui Password
        </button>
    </div>
</form>