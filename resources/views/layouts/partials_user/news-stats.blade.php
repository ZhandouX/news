<div class="news-stats mt-16 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="stats-header bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600 text-white p-6">
        <div class="text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-2">
                <i class="fas fa-chart-bar mr-3"></i>
                Statistik Portal Berita
            </h2>
            <p class="text-blue-100">Data terkini aktivitas publikasi berita</p>
        </div>
    </div>

    <div class="stats-grid grid grid-cols-2 lg:grid-cols-4 divide-x divide-gray-200">
        @php
            $totalNews = \App\Models\News::count();
            $thisMonthNews = \App\Models\News::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $popularCategory = \App\Models\News::select('category')
                ->groupBy('category')
                ->orderByRaw('COUNT(*) DESC')
                ->first();
            $latestNews = \App\Models\News::latest('news_date')->first();
        @endphp

        <div class="stat-item p-6 text-center hover:bg-gray-50 transition-colors">
            <div class="stat-icon text-blue-600 text-3xl mb-3">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-number text-3xl font-bold text-blue-600 mb-2">
                {{ number_format($totalNews) }}
            </div>
            <div class="stat-label text-gray-600 font-medium">Total Berita</div>
        </div>

        <div class="stat-item p-6 text-center hover:bg-gray-50 transition-colors">
            <div class="stat-icon text-green-600 text-3xl mb-3">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-number text-3xl font-bold text-green-600 mb-2">
                {{ number_format($thisMonthNews) }}
            </div>
            <div class="stat-label text-gray-600 font-medium">Bulan Ini</div>
        </div>

        <div class="stat-item p-6 text-center hover:bg-gray-50 transition-colors">
            <div class="stat-icon text-purple-600 text-3xl mb-3">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-number text-lg font-bold text-purple-600 mb-2">
                {{ $popularCategory ? Str::limit($popularCategory->category, 15) : 'N/A' }}
            </div>
            <div class="stat-label text-gray-600 font-medium">Kategori Populer</div>
        </div>

        <div class="stat-item p-6 text-center hover:bg-gray-50 transition-colors">
            <div class="stat-icon text-orange-600 text-3xl mb-3">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-number text-lg font-bold text-orange-600 mb-2">
                {{ $latestNews ? $latestNews->news_date->format('d M Y') : 'N/A' }}
            </div>
            <div class="stat-label text-gray-600 font-medium">Berita Terakhir</div>
        </div>
    </div>
</div>