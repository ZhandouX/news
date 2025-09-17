@extends('layouts.app_admin')

@section('title', 'Detail Berita')

@section('content')
    @include('layouts.partials_admin.news-show')
@endsection

@push('styles')
    <style>
        .news-content {
            font-size: 15px;
            line-height: 1.7;
            color: #6c7293;
            text-align: justify;
        }

        .news-content p {
            margin-bottom: 1rem;
        }

        .news-content h1,
        .news-content h2,
        .news-content h3,
        .news-content h4,
        .news-content h5,
        .news-content h6 {
            color: #2e323c;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .card-title {
            color: #2e323c;
            font-weight: 600;
        }

        .badge-outline-info {
            color: #0dcaf0;
            border: 1px solid #0dcaf0;
            background-color: transparent;
        }

        .d-grid {
            display: grid;
            gap: 0.5rem;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        /* === Style untuk Informasi Berita (Label | Value) === */
        .info-list dl {
            margin: 0;
            padding: 0;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            border-bottom: 1px solid #eee;
            padding: 0.5rem 0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item dt {
            flex: 0 0 40%;
            font-weight: 600;
            color: #2e323c;
            border-right: 1px solid #dee2e6;
            padding-right: 1rem;
        }

        .info-item dd {
            flex: 1;
            margin: 0;
            padding-left: 1rem;
            color: #6c7293;
            word-break: break-word;
        }

        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            // Smooth scroll
            $('a[href^="#"]').on('click', function (event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
