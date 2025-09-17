@extends('layouts.super_admin')

@section('title', 'Kelola Akun Admin')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title card-title-dash">Kelola Akun Admin</h4>

                    <div class="officer-management-wrapper mb-2">
                        <div class="officer-management"></div>
                    </div>

                    <p class="card-subtitle card-subtitle-dash">Total Admin Petugas : {{ $admins->count() }}</p>
                </div>
                <div>
                    <a href="{{ route('super-admin.admins.create') }}"
                        class="btn btn-primary btn-lg text-white mb-0 me-0">
                        <i class="mdi mdi-account-plus"></i>Tambah Petugas
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <span class="{{ $admin->isOnline() ? 'text-success' : 'text-danger' }}">
                                    {{ $admin->isOnline() ? 'Online' : 'Offline' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('super-admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-warning btn-lg text-white mb-0 me-0">
                                    <i class="mdi mdi-account-edit"></i> Edit
                                </a>

                                <form action="{{ route('super-admin.admins.destroy', $admin->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-lg text-white mb-0 me-0">
                                        <i class="mdi mdi-account-remove"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada admin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination jika ada -->
            @if($admins->hasPages())
                <div class="mt-3">
                    {{ $admins->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
