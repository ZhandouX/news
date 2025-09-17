<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title card-title-dash"><i class="mdi mdi-account-hard-hat-outline icon-smd"></i> Admin Petugas</h4>
                    <p class="card-subtitle card-subtitle-dash">
                        Total Admin Petugas : <span class="totals">{{ $totalAdmins }}</span>
                    </p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="officer-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kontribusi Berita</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $index => $admin)
                            <tr data-id="{{ $admin->id }}">
                                <td>{{ $index + 1 }}</td> <!-- Nomor index 1, 2, 3 ... -->
                                <td>{{ $admin->name }}</td> <!-- Nama Akun Petugas (di ambil dari kolom name pada tabel users) -->
                                <td>{{ $admin->email }}</td> <!-- Email Petugas -->
                                <td>{{ $admin->news_count }}</td> <!-- Kontribusi dalam menambahkan/input berita -->
                                <td>
                                    <span class="status {{ $admin->isOnline() ? 'text-success' : 'text-danger' }}">
                                        {{ $admin->isOnline() ? 'Online' : 'Offline' }} <!-- Real-time unutk akun Petugas apakah Online / Offline -->
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>