@extends('layouts.app_admin')

@section('content')

    {{-- STYLE PROFILE FORM --}}
    <link rel="stylesheet" href="{{ asset('assets/css/profile/admin.css') }}">

    <div class="profile-section">
        <div class="profile-header">
            <h2><i class="mdi mdi-account-cog icon-lg"></i> Pengaturan Akun & Profil</h2>
            <p>Kelola informasi profil dan akun Anda</p>
        </div>

        <div class="profile-content">
            {{-- PROFILE INFORMATION --}}
            <div class="profile-card">
                <div class="card-header">
                    <h3><i class="mdi mdi-information icon-smd"></i> Informasi Profil</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- UPDATE PASSWORD --}}
            <div class="profile-card">
                <div class="card-header">
                    <h3><i class="mdi mdi-account-edit icon-smd"></i> Ubah Password</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- DELETE ACCOUNT --}}
            <div class="profile-card danger">
                <div class="card-header">
                    <h3><i class="mdi mdi-account-remove icon-smd"></i> Hapus Akun</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection