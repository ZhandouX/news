@extends('layouts.super_admin')

@section('content')
    <div class="row justify-content-start g-3">
        {{-- LEFT COLUMN: NEWS FILTER INPUT --}}
        <div class="col-md-6">
            <div class="card modern-form-card">
                <div class="card-body">
                    <h4 class="card-title"><i class="mdi mdi-clipboard-text-outline icon-smd"></i> Rekap Berita -> Sumber
                        Berita / Bulan</h4>

                    {{-- SUBMIT EXPORT PDF --}}
                    <form action="{{ route('super-admin.news.export-monthly-report-filter', [
                            'year' => '__YEAR__',
                            'month' => '__MONTH__',
                            'filterType' => 'sumber',
                            'filterValue' => '__SUMBER__'
                        ]) }}" method="GET" id="exportForm">
                        <div class="mb-3">
                            <label for="sumber" class="form-label">Pilih Sumber Berita</label>
                            <select class="form-select modern-select" id="sumber" name="filterValue" required>
                                <option value="">-- Pilih Sumber --</option>
                                @foreach($sumberList as $sumber)
                                    <option value="{{ $sumber }}">{{ $sumber }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="filterType" value="sumber">
                        </div>

                        <div class="mb-3">
                            <label for="month" class="form-label">Bulan</label>
                            <input type="month" id="month" name="month" class="form-control modern-input" required>
                        </div>

                        <button type="submit" class="btn btn-danger text-white btn-lg">
                            <i class="fa fa-download me-2"></i> Export PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: NEWS FILTER LIST --}}
        <div class="col-md-6">
            <div class="card modern-list-card">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="mdi mdi-format-list-bulleted-square icon-smd"></i> Daftar Berita
                    </h4>

                    {{-- NEWS LIST --}}
                    <div id="newsList" class="row g-3 mt-2"></div>

                    {{-- PAGINATION AJAX --}}
                    <div id="pagination" class="mt-3 pagination-container"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function fetchNews(page = 1) {
            const sumberEl = document.getElementById('sumber');
            const monthEl = document.getElementById('month');
            if (!sumberEl || !monthEl) return;

            const sumber = sumberEl.value;
            const yearMonth = monthEl.value;

            if (!yearMonth) return;

            fetch(`{{ route('super-admin.news.filter-sumber.list') }}?sumber=${sumber}&yearMonth=${yearMonth}&page=${page}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(response => {
                    // response harus { data: [...], pagination: '...' }
                    let data = response.data;
                    let html = '';

                    if (response.data.length > 0) {
                        response.data.forEach(news => {
                            const shortTitle = news.title.length > 70 ? news.title.substring(0, 70) + '...' : news.title;
                            const newsDate = new Date(news.news_date);
                            const formattedDate = newsDate.toLocaleDateString('id-ID', {
                                weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'
                            });

                            html += `
                            <div class="col-12">
                                <div class="modern-news-card" data-id="${news.id}">
                                    <div class="news-content">
                                        <div class="news-image-container">
                                            <img src="/storage/${news.cover_image}" class="news-image" alt="${news.title}">
                                            <div class="news-source-badge">${limitText(news.sumber, 12)}</div>
                                        </div>
                                        <div class="news-details">
                                            <h5 class="news-title">${shortTitle}</h5>
                                            <p class="news-date">
                                                <i class="fa fa-calendar me-1"></i> ${formattedDate}
                                            </p>
                                            <div class="news-actions">
                                                <button class="btn-action btn-preview" title="Pratinjau">
                                                    <i class="fa fa-info"></i>
                                                </button>
                                                <button class="btn-action btn-share" title="Bagikan">
                                                    <i class="fa fa-share-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        });
                    } else {
                        html = `
                        <div class="col-12">
                            <div class="no-news-state">
                                <i class="far fa-newspaper"></i>
                                <p>Tidak ada berita untuk sumber dan bulan yang dipilih.</p>
                            </div>
                        </div>`;
                    }

                    document.getElementById('newsList').innerHTML = html;

                    // Render pagination
                    renderPagination(response);

                    attachNewsCardEvents();
                });
        }

        function renderPagination(response) {
            document.getElementById('pagination').innerHTML = response.pagination;

            const links = document.querySelectorAll('#pagination a.page-link');
            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page');
                    fetchNews(page);
                });
            });
        }

        function attachNewsCardEvents() {
            const newsCards = document.querySelectorAll('.modern-news-card');
            newsCards.forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 12px 20px rgba(0,0,0,0.15)';
                });
                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
                });
                card.addEventListener('click', function () {
                    const newsId = this.getAttribute('data-id');
                    console.log('News ID:', newsId);
                });
            });
        }

        function limitText(text, limit = 20) {
            if (!text) return '';
            return text.length > limit ? text.substring(0, limit) + '...' : text;
        }

        document.getElementById('sumber').addEventListener('change', () => fetchNews(1));
        document.getElementById('month').addEventListener('input', () => fetchNews(1));
    </script>
@endpush


{{-- CSS --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/monthly-filter-sumber.css') }}">
@endpush