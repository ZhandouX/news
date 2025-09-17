@extends('layouts.profile')

@section('content')
<div class="profile-section">
    <div class="profile-header">
        <h2><i class="fas fa-user-cog"></i> Pengaturan Profil</h2>
        <p>Kelola informasi profil dan akun Anda</p>
    </div>

    <div class="profile-content">
        <!-- Profile Information -->
        <div class="profile-card">
            <div class="card-header">
                <h3><i class="fas fa-user-edit"></i> Informasi Profil</h3>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="profile-card">
            <div class="card-header">
                <h3><i class="fas fa-lock"></i> Ubah Password</h3>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="profile-card danger">
            <div class="card-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Hapus Akun</h3>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection