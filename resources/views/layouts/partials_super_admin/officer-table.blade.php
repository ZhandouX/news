<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title card-title-dash"><i class="mdi mdi-account-hard-hat-outline icon-smd"></i> Admin Petugas</h4>

                    <div class="loading-animation-officer-management mb-2"></div>

                    <p class="card-subtitle card-subtitle-dash">Total Admin Petugas : {{ $totalAdmins }}</p>
                </div>
                <div>
                    <a href="{{ route('super-admin.admins.create') }}"
                        class="btn btn-primary btn-lg text-white mb-0 me-0">
                        <i class="mdi mdi-account-plus"></i> Tambah Petugas
                    </a>
                    <a href="{{ route('super-admin.admins.index') }}" class="btn btn-outline-info btn-lg mb-0 me-0">
                        <i class="mdi mdi-account-plus"></i> Kelola Akun
                    </a>
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->news_count }}</td>
                                <td>
                                    <span class="status {{ $admin->isOnline() ? 'text-success' : 'text-danger' }}">
                                        {{ $admin->isOnline() ? 'Online' : 'Offline' }}
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