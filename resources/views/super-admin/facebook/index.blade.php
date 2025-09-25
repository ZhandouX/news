@extends('layouts.super_admin')

@section('title', 'Kelola Konten Facebook')

@section('content')
    @include('layouts.partials_super_admin.facebook.table')
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