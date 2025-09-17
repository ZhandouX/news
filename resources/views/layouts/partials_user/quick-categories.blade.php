<div
    class="quick-categories mt-16 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-2xl p-8 border border-blue-100">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-3">
            <i class="fas fa-layer-group text-blue-600 mr-3"></i>
            Kategori Berita
        </h2>
        <p class="text-gray-600">Jelajahi berita berdasarkan kategori yang Anda minati</p>
    </div>

    <div class="category-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @php
            $popularCategories = [
                'Politik' => ['fas fa-landmark', 'from-red-500 to-red-600'],
                'Hukum & Kriminal' => ['fas fa-gavel', 'from-gray-700 to-gray-800'],
                'Ekonomi & Bisnis' => ['fas fa-chart-line', 'from-green-500 to-green-600'],
                'Teknologi' => ['fas fa-microchip', 'from-blue-500 to-blue-600'],
                'Pendidikan' => ['fas fa-graduation-cap', 'from-purple-500 to-purple-600'],
                'Kesehatan' => ['fas fa-heart-pulse', 'from-pink-500 to-pink-600'],
                'Lingkungan' => ['fas fa-leaf', 'from-emerald-500 to-emerald-600'],
                'Internasional' => ['fas fa-globe', 'from-indigo-500 to-indigo-600']
            ];
        @endphp

        @foreach($popularCategories as $category => list($icon, $gradient))
            <a href="{{ route('news.category', $category) }}"
                class="category-card group bg-white rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100 hover:border-blue-200">
                <div class="category-icon mb-4">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br {{ $gradient }} rounded-full flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
                <div
                    class="category-name font-semibold text-gray-700 group-hover:text-blue-600 transition-colors duration-200">
                    {{ $category }}
                </div>
                <div class="category-count text-xs text-gray-500 mt-1">
                    {{ \App\Models\News::where('category', $category)->count() }} berita
                </div>
            </a>
        @endforeach
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('news.index') }}"
            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
            <i class="fas fa-eye mr-2"></i>
            Lihat Semua Berita
        </a>
    </div>
</div>