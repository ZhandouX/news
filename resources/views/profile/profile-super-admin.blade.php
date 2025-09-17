@extends('layouts.super_admin')

@section('content')

    {{-- STYLE PROFILE FORM --}}
    <link rel="stylesheet" href="{{ asset('assets/css/profile/admin.css') }}">

    <div class="profile-section">
        <div class="profile-header">
            <h2><i class="mdi mdi-account-cog icon-lg"></i> Pengaturan Akun & Profil</h2>
            <div>
                <div class="profile-title-animation mb-2"></div>
            </div>
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
                    <h3><i class="fa fa-lock icon-smd"></i> Ubah Password</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@endsection