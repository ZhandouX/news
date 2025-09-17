<div class="row">
    <div class="col-sm-12">
        <div class="statistics-details d-flex align-items-center justify-content-between">

            {{-- NEWS TOTAL --}}
            <div>
                <p class="statistics-title fw-bold">
                    <i class="mdi mdi-newspaper-variant-multiple-outline"></i>
                    Jumlah Berita
                </p>
                <h3 class="rate-percentage text-center total">
                    {{ $stats['total_news'] }} <!-- Menghitung jumlah berita -->
                </h3>
            </div>

            {{-- BERITA MINGGU INI --}}
            <div>
                <p class="statistics-title fw-bold">
                    <i class="mdi mdi-calendar-week"></i>
                    Minggu Ini
                </p>
                <h3 class="rate-percentage text-center">
                    {{ $stats['news_this_week'] }} <!-- Menghitung jumlah berita minggu ini -->
                </h3>
            </div>

            {{-- BERITA BULAN INI --}}
            <div>
                <p class="statistics-title fw-bold">
                    <i class="mdi mdi-calendar-month"></i>
                    Bulan Ini
                </p>
                <h3 class="rate-percentage text-center">
                    {{ $stats['news_this_month'] }} <!-- Menghitung jumlah berita bulan ini -->
                </h3>
            </div>

            {{-- BERITA BULAN LALU --}}
            <div class="d-none d-md-block">
                <p class="statistics-title fw-bold">
                    <i class="mdi mdi-calendar-arrow-left"></i>
                    Bulan Lalu
                </p>
                <h3 class="rate-percentage text-center">
                    {{ $stats['news_last_month'] }} <!-- Menghitung jumlah berita bulan lalu -->
                </h3>
            </div>

            {{-- BERITA TAHUN INI --}}
            <div class="d-none d-md-block">
                <p class="statistics-title fw-bold">
                    <i class="mdi mdi-calendar-blank"></i>
                    Tahun Ini
                </p>
                <h3 class="rate-percentage text-center">
                    {{ $stats['news_this_year'] }} <!-- Menghitung jumlah berita tahun ini -->
                </h3>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/news-stats.css') }}">