<form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('DELETE')

    <div class="warning-box">
        <i class="fa fa-exclamation-triangle"></i>
        <div class="warning-content">
            <h4>Hapus Akun Secara Permanen</h4>
            <p>Setelah akun Anda dihapus, semua data dan resource akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>
        </div>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <div class="input-with-icon password-field">
            <i class="fa fa-lock"></i>
            <input id="delete_password" type="password" name="password" required placeholder="Masukkan password untuk konfirmasi">
            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <i class="fa fa-eye"></i>
            </button>
        </div>
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="button" id="delete-account-btn" class="delete-btn">
            <i class="mdi mdi-delete"></i> Hapus Akun
        </button>
    </div>

    <!-- Confirmation Modal -->
    <div id="delete-confirm-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Konfirmasi Penghapusan Akun</h3>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel-btn close-modal"><i class="fa fa-times"></i>Batal</button>
                <button type="submit" class="confirm-delete-btn"><i class="fa fa-check"></i>Ya, Hapus Akun</button>
            </div>
        </div>
    </div>
</form>