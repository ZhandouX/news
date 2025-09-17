{{-- resources/views/user/berita-detail.blade.php --}}
@extends('layouts.app_user')

@section('title', $news->title . ' - Kemenkumham Maluku')

@section('meta_description', Str::limit(strip_tags($news->content), 155))

@section('meta_keywords', 'berita kemenkumham maluku, ' . strtolower($news->category) . ', hukum maluku, ' . strtolower($news->title))

@section('og_title', $news->title)
@section('og_description', Str::limit(strip_tags($news->content), 155))
@section('og_image', $news->cover_image ? asset('storage/' . $news->cover_image) : asset('images/kemenkumham-maluku-default.jpg'))
@section('og_url', route('news.show', $news))

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css" rel="stylesheet">
@endpush

@section('content')
{{-- Reading Progress Bar --}}
<div class="reading-progress" id="readingProgress"></div>

<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="breadcrumb mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('user.dashboard') }}" class="hover:text-blue-600">Home</a></li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <a href="{{ route('news.index') }}" class="hover:text-blue-600">Berita</a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <a href="{{ route('news.category', $news->category) }}" class="hover:text-blue-600">{{ $news->category }}</a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="font-semibold text-blue-600">{{ Str::limit($news->title, 50) }}</span>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Main Content --}}
        <article class="lg:col-span-3 bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- News Header --}}
            <header class="news-header">
                {{-- Category Badge --}}
                <div class="category-section p-6 pb-4">
                    <span class="category-badge category-{{ Str::slug($news->category) }} inline-flex items-center">
                        <i class="fas fa-tag mr-2"></i>
                        {{ $news->category }}
                    </span>
                </div>
                
                {{-- Title --}}
                <div class="title-section px-6 pb-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4">
                        {{ $news->title }}
                    </h1>
                    
                    {{-- Meta Information --}}
                    <div class="news-meta flex flex-wrap items-center gap-4 text-gray-600 border-b border-gray-200 pb-4">
                        <div class="meta-item flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($news->news_date)->format('d F Y') }}</span>
                        </div>
                        <div class="meta-item flex items-center">
                            <i class="fas fa-clock mr-2 text-green-500"></i>
                            <span>Dipublikasi {{ $news->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="meta-item flex items-center">
                            <i class="fas fa-eye mr-2 text-purple-500"></i>
                            <span id="viewCount">-</span> <span class="ml-1">kali dilihat</span>
                        </div>
                        <div class="meta-item flex items-center">
                            <i class="fas fa-stopwatch mr-2 text-orange-500"></i>
                            <span id="readingTime">-</span> <span class="ml-1">menit baca</span>
                        </div>
                    </div>
                </div>
            </header>
            
            {{-- Featured Image --}}
            @if($news->cover_image)
                <div class="news-image-detail relative">
                    <img src="{{ asset('storage/' . $news->cover_image) }}" 
                         alt="{{ $news->title }}"
                         class="w-full h-64 md:h-96 object-cover">
                    <div class="image-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                        <p class="text-white text-sm opacity-90">
                            <i class="fas fa-camera mr-2"></i>
                            {{ $news->title }}
                        </p>
                    </div>
                </div>
            @endif
            
            {{-- News Content --}}
            <div class="news-content-wrapper p-6">
                <div class="news-content prose max-w-none text-gray-700 text-lg leading-relaxed" id="newsContent">
                    {!! nl2br(e($news->content)) !!}
                </div>
                
                {{-- Tags Section (if you have tags) --}}
                <div class="tags-section mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-tags mr-2 text-blue-500"></i>
                        Tag Terkait:
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        {{-- Sample tags - replace with actual tags from database --}}
                        @php
                            $sampleTags = explode(' ', Str::limit($news->title, 50));
                            $tags = array_slice($sampleTags, 0, 5);
                        @endphp
                        @foreach($tags as $tag)
                            @if(strlen($tag) > 3)
                                <span class="tag bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                    #{{ strtolower(str_replace([',', '.', '!', '?'], '', $tag)) }}
                                </span>
                            @endif
                        @endforeach
                        <span class="tag bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                            #kemenkumham
                        </span>
                        <span class="tag bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                            #maluku
                        </span>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="action-buttons mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3">
                    <button onclick="window.print()" class="action-btn bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-print mr-2"></i>
                        Cetak
                    </button>
                    <button onclick="downloadPDF()" class="action-btn bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Download PDF
                    </button>
                    <button onclick="copyLink()" class="action-btn bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-link mr-2"></i>
                        Salin Link
                    </button>
                </div>
            </div>
        </article>
        
        {{-- Sidebar --}}
        <aside class="lg:col-span-1 space-y-6">
            {{-- Share Buttons (Sticky) --}}
            <div class="share-buttons bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-share-alt mr-2 text-blue-500"></i>
                    Bagikan
                </h3>
                <div class="space-y-3">
                    <a href="#" onclick="shareToFacebook()" class="share-btn bg-blue-600 hover:bg-blue-700 text-white w-full py-3 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-facebook-f mr-3"></i>
                        Facebook
                    </a>
                    <a href="#" onclick="shareToTwitter()" class="share-btn bg-sky-500 hover:bg-sky-600 text-white w-full py-3 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-twitter mr-3"></i>
                        Twitter
                    </a>
                    <a href="#" onclick="shareToWhatsApp()" class="share-btn bg-green-500 hover:bg-green-600 text-white w-full py-3 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-whatsapp mr-3"></i>
                        WhatsApp
                    </a>
                    <a href="#" onclick="shareToTelegram()" class="share-btn bg-blue-500 hover:bg-blue-600 text-white w-full py-3 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-telegram-plane mr-3"></i>
                        Telegram
                    </a>
                </div>
            </div>
            
            {{-- Latest News --}}
            @if($latestNews->count() > 0)
                <div class="latest-news-sidebar bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-newspaper mr-2 text-green-500"></i>
                        Berita Terbaru
                    </h3>
                    <div class="space-y-4">
                        @foreach($latestNews as $latest)
                            <article class="latest-news-item flex gap-3 pb-4 border-b border-gray-100 last:border-b-0 last:pb-0">
                                <div class="flex-shrink-0">
                                    @if($latest->cover_image)
                                        <img src="{{ asset('storage/' . $latest->cover_image) }}" 
                                             alt="{{ $latest->title }}"
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-newspaper text-white text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm leading-tight mb-1">
                                        <a href="{{ route('news.show', $latest) }}" class="hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $latest->title }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 mb-1">
                                        {{ \Carbon\Carbon::parse($latest->news_date)->format('d M Y') }}
                                    </p>
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-xs rounded text-gray-600">
                                        {{ $latest->category }}
                                    </span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('news.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center justify-center">
                            Lihat Semua Berita
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            @endif
            
            {{-- Back to Category --}}
            <div class="category-navigation bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                <h3 class="text-lg font-bold mb-3 text-gray-800">
                    <i class="fas fa-arrow-left mr-2 text-blue-500"></i>
                    Navigasi
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('news.index') }}" 
                       class="block bg-white hover:bg-blue-50 text-gray-700 hover:text-blue-700 px-4 py-3 rounded-lg transition-all duration-200 border border-gray-200 hover:border-blue-200">
                        <i class="fas fa-newspaper mr-2"></i>
                        Semua Berita
                    </a>
                    <a href="{{ route('news.category', $news->category) }}" 
                       class="block bg-white hover:bg-blue-50 text-gray-700 hover:text-blue-700 px-4 py-3 rounded-lg transition-all duration-200 border border-gray-200 hover:border-blue-200">
                        <i class="fas fa-tag mr-2"></i>
                        Kategori: {{ $news->category }}
                    </a>
                </div>
            </div>
        </aside>
    </div>
    
    {{-- Related News --}}
    @if($relatedNews->count() > 0)
        <section class="related-news mt-12">
            <div class="section-header text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">
                    <i class="fas fa-layer-group mr-3 text-blue-500"></i>
                    Berita Terkait
                </h2>
                <p class="text-gray-600">Berita lainnya dalam kategori {{ $news->category }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedNews as $related)
                    <article class="related-news-card bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="news-image-detail relative h-48">
                            @if($related->cover_image)
                                <img src="{{ asset('storage/' . $related->cover_image) }}" 
                                     alt="{{ $related->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-3xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                <span class="category-badge category-{{ Str::slug($related->category) }} text-xs">
                                    {{ $related->category }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="news-content p-4">
                            <h3 class="font-bold text-lg mb-2 leading-tight">
                                <a href="{{ route('news.show', $related) }}" class="hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ Str::limit(strip_tags($related->content), 80) }}
                            </p>
                            
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ \Carbon\Carbon::parse($related->news_date)->format('d M Y') }}
                                </span>
                                <a href="{{ route('news.show', $related) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                                    Baca <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/news.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize reading progress
            initReadingProgress();
            
            // Calculate reading time
            calculateReadingTime();
            
            // Track page view
            trackPageView();
            
            // Initialize code highlighting
            hljs.highlightAll();
        });
        
        // Reading progress bar
        function initReadingProgress() {
            const progressBar = document.getElementById('readingProgress');
            const content = document.getElementById('newsContent');
            
            window.addEventListener('scroll', function() {
                const contentHeight = content.offsetHeight;
                const windowHeight = window.innerHeight;
                const scrolled = window.scrollY;
                const contentTop = content.offsetTop;
                
                const progress = Math.min(
                    Math.max((scrolled - contentTop + windowHeight) / contentHeight * 100, 0),
                    100
                );
                
                progressBar.style.width = progress + '%';
            });
        }
        
        // Calculate reading time
        function calculateReadingTime() {
            const content = document.getElementById('newsContent').textContent;
            const wordsPerMinute = 200;
            const words = content.trim().split(/\s+/).length;
            const readingTime = Math.ceil(words / wordsPerMinute);
            
            document.getElementById('readingTime').textContent = readingTime;
        }
        
        // Track page view
        function trackPageView() {
            fetch('/analytics/berita/{{ $news->id }}/view', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.views) {
                      document.getElementById('viewCount').textContent = data.views;
                  }
              });
        }
        
        // Social sharing functions
        function shareToFacebook() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        }
        
        function shareToTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $news->title }}');
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }
        
        function shareToWhatsApp() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $news->title }} - ');
            window.open(`https://wa.me/?text=${text}${url}`, '_blank');
        }
        
        function shareToTelegram() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $news->title }}');
            window.open(`https://t.me/share/url?url=${url}&text=${text}`, '_blank');
        }
        
        // Copy link function
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check mr-2"></i>Tersalin!';
                button.classList.add('bg-green-100', 'text-green-700');
                
                setTimeout(function() {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-100', 'text-green-700');
                }, 2000);
            });
        }
        
        // Download PDF function
        function downloadPDF() {
            window.open('/berita/{{ $news->id }}/pdf', '_blank');
        }
    </script>
@endpush