@extends('layouts.app_admin')

@section('title', 'Kelola Berita')

@section('content')
    @include('layouts.partials_admin.news-table')
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Auto hide alert after 5 seconds
            setTimeout(function () {
                $('.alert').fadeOut();
            }, 5000);
        });
    </script>
@endpush