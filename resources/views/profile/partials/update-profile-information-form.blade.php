<form id="profile-info-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="photo">Foto Profil</label>
        <div class="photo-upload">
            <div class="photo-preview">
                <img src="{{ asset('assets/images/profile-default.jpg') }}" alt="Foto Profil" id="photo-preview">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <div class="input-with-icon">
            <i class="fa fa-user"></i>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name"
                placeholder="Masukkan nama lengkap">
        </div>
        @error('name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <div class="input-with-icon">
            <i class="fa fa-envelope"></i>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                autocomplete="email" placeholder="Masukkan alamat email">
        </div>
        @error('email')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="save-btn">
            <i class="mdi mdi-content-save"></i> Simpan Perubahan
        </button>
    </div>
</form>