<div class="card">
    <div class="card-body">
        <h4 class="card-title">Buat Akun Admin</h4>
        <form action="{{ route('super-admin.admins.store') }}" method="POST">
            @csrf

            {{-- NAME --}}
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            {{-- EMAIL --}}
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            {{-- PASSWORD CONFIRMATION --}}
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            {{-- SUMBIT BUTTON --}}
            <button type="submit" class="btn btn-primary btn-lg text-white mb-0 me-0">
                <i class="mdi mdi-account-plus"></i>Buat Akun
            </button>
        </form>
    </div>
</div>