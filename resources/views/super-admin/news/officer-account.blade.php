@extends('layouts.super_admin')

@section('title', 'Kelola Petugas')

@section('content')
    @include('layouts.partials_super_admin.officer-table')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/last-seen.js') }}"></script>
@endsection