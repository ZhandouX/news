@extends('layouts.super_admin')

@section('title', 'Kelola Konten Website')

@section('content')
    @include('layouts.partials_super_admin.website.table')
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // AUTO HIDE ALERT SETELAH 5 DETIK
            setTimeout(function () {
                $('.alert').fadeOut();
            }, 5000);
        })
    </script>
@endpush