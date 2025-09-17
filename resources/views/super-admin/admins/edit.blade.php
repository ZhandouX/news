@extends('layouts.super_admin')

@section('title', 'Edit Akun Admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title card-title-dash">Edit Akun Admin Petugas</h4>
                </div>
                <div>
                    <a href="{{ route('super-admin.admins.index') }}" class="btn btn-sm btn-danger btn-lg text-white mb-0 me-0">
                        <i class="mdi mdi-backspace"></i>Batal
                    </a>
                </div>
            </div>
            <form action="{{ route('super-admin.admins.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="mb-3">
                    <label>Password (Kosongkan jika tidak ingin diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-sm btn-success btn-lg text-white mb-0 me-0">
                    <i class="mdi mdi-check-bold"></i>Update Akun</button>
            </form>
        </div>
    </div>
@endsection