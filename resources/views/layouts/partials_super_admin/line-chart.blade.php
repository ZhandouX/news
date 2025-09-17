<div class="row">
    {{-- CHART --}}
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><strong><i class="mdi mdi-chart-line icon-smd"></i> Statistik / Bulan</strong></h4>

                <hr class="w-100">

                {{-- CHART CANVAS --}}
                <canvas id="areaChart"></canvas>

                {{-- SUMMARY DATA --}}
                <div class="mt-4">
                    <p class="mb-2">
                        <strong>
                            <i class="mdi mdi-file-document-outline"></i>
                            Total ->
                        </strong>
                        <span class="total">{{ $news->total() }}</span>
                    </p>

                    <p class="mb-2"><strong><i class="mdi mdi-chart-line"></i> Average / Bulan -> </strong>
                        <span class="average">{{ round($news->total() / $newsPerMonth->count(), 2) }}</span>
                    </p>

                    @php
                        $maxMonth = $newsPerMonth->sortByDesc('count')->first();
                        $minMonth = $newsPerMonth->sortBy('count')->first();
                    @endphp

                    <p class="mb-2"><strong><i class="mdi mdi-arrow-up-bold"></i> Berita Terbanyak -> </strong> <span
                            class="badge badge-outline-success">{{ $maxMonth['monthName'] }}</span> :
                        <span class="up">{{ $maxMonth['count'] }}</span>
                    </p>

                    <p class="mb-2"><strong><i class="mdi mdi-arrow-down-bold"></i> Berita Terendah -> </strong> <span
                            class="badge badge-outline-danger">{{ $minMonth['monthName'] }}</span> :
                        <span class="down">{{ $minMonth['count'] }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- DAFTAR BERITA --}}
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body title-line">
                <h4 class="card-title"><strong><i class="mdi mdi-update icon-smd"></i> Berita Terbaru</strong></h4>

                <hr class="w-100">
                @foreach ($news as $item)
                    <div class="dash-news-card mb-3 d-flex align-items-start">
                        <!-- Gambar -->
                        @if($item->cover_image)
                            <div class="news-img">
                                <a href="{{ route('super-admin.news.show', $item->id) }}">
                                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="images">
                                </a>
                            </div>
                        @else
                            <div class="news-img">
                                <img src="https://via.placeholder.com/120x80?text=No+Image" alt="no-image">
                            </div>
                        @endif

                        {{-- CONTENT --}}
                        <div class="news-content ms-3">
                            <a href="{{ route('super-admin.news.show', $item->id) }}">
                                <h5 class="news-title">{{ $item->title }}</h5>
                            </a>
                            <p class="news-date">
                                {{ \Carbon\Carbon::parse($item->news_date)->translatedFormat('d F Y') }}
                            </p>
                            <p class="news-desc">
                                {{ strip_tags($item->content) }}
                            </p>
                        </div>
                    </div>
                @endforeach

                {{-- PAGINATION --}}
                <div class="mt-3 pagination-container">
                    {{ $news->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>