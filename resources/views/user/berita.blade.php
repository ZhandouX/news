{{-- resources/views/user/berita.blade.php --}}
@extends('layouts.app_user')

@section('title', 'Portal Berita - Kemenkumham Maluku')

@section('meta_description', 'Portal berita terkini Kementerian Hukum dan HAM Maluku. Dapatkan informasi terbaru seputar hukum, peraturan, dan layanan publik.')

@section('meta_keywords', 'berita kemenkumham maluku, hukum maluku, peraturan, imigrasi ambon, pemasyarakatan')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="breadcrumb mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('user.dashboard') }}" class="hover:text-blue-600">Home</a></li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="font-semibold text-blue-600">Berita</span>
            </li>
        </ol>
    </nav>
    
    {{-- Page Header --}}
    <div class="page-header mb-8 text-center">
        <div class="header-logo mb-4">
            <i class="fas fa-newspaper text-6xl text-blue-600"></i>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            Portal Berita
            <span class="block text-2xl md:text-3xl text-blue-600 mt-2">Kemenkumham Maluku</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Dapatkan informasi terbaru seputar layanan hukum, peraturan perundang-undangan, 
            program kegiatan, dan berita penting lainnya dari Kementerian Hukum dan HAM Wilayah Maluku
        </p>

        @include('layouts.partials_user.search-news')
    </div>
    
    {{-- Results Info --}}
    @if(request()->hasAny(['search', 'category', 'year', 'month']))
        <div class="results-info bg-white rounded-lg p-4 mb-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="results-text flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3 text-lg"></i>
                    <div>
                        <span class="font-semibold text-lg">{{ number_format($news->total()) }} berita ditemukan</span>
                        <div class="text-sm text-gray-600 mt-1">
                            @if(request('search'))
                                untuk pencarian "<strong class="text-blue-600">{{ request('search') }}</strong>"
                            @endif
                            @if(request('category'))
                                dalam kategori "<strong class="text-blue-600">{{ request('category') }}</strong>"
                            @endif
                            @if(request('year'))
                                pada tahun <strong class="text-blue-600">{{ request('year') }}</strong>
                            @endif
                            @if(request('month'))
                                bulan <strong class="text-blue-600">{{ date('F', mktime(0, 0, 0, request('month'), 1)) }}</strong>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="results-actions">
                    <a href="{{ route('news.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                        <i class="fas fa-times mr-2"></i>
                        Hapus Semua Filter
                    </a>
                </div>
            </div>
        </div>
    @endif
    
    {{-- News Cards --}}
    <div id="news-results" class="news-results-container">
        @include('layouts.partials_user.card-news')
    </div>

    {{-- Quick Categories --}}
    @include('layouts.partials_user.quick-categories')

    {{-- Statistics Section --}}
    @include('layouts.partials_user.news-stats')
</div>
@endsection

@push('scripts')
    
    <script>
        // Additional JavaScript khusus untuk halaman berita
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll untuk category links
            document.querySelectorAll('.category-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Add loading animation
                    const icon = this.querySelector('.category-icon div');
                    icon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    
                    // Allow normal navigation
                    setTimeout(() => {
                        // Reset will happen on page load
                    }, 500);
                });
            });
            
            // Track category clicks for analytics
            document.querySelectorAll('a[href*="kategori"]').forEach(link => {
                link.addEventListener('click', function() {
                    const category = this.textContent.trim();
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'category_click', {
                            event_category: 'news',
                            event_label: category
                        });
                    }
                });
            });
        });
    </script>
@endpush