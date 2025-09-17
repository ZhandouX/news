{{-- resources/views/layouts/partials_user/card-news.blade.php --}}
<div class="news-container">
    @if($news->count() > 0)
        <div class="news-grid">
            @foreach($news as $item)
                <article class="news-card" data-category="{{ $item->category }}" data-date="{{ $item->news_date }}">
                    <div class="news-image">
                        @if($item->cover_image)
                            <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" loading="lazy">
                        @else
                            <div class="no-image">
                                <i class="fas fa-newspaper"></i>
                                <span>Kemenkumham Maluku</span>
                            </div>
                        @endif
                        <div class="news-category">
                            <span class="category-badge category-{{ Str::slug($item->category) }}">
                                {{ $item->category }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($item->news_date)->format('d M Y') }}
                            </span>
                            <span class="news-time">
                                <i class="fas fa-clock"></i>
                                {{ $item->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <h3 class="news-title">
                            <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                        </h3>
                        
                        <p class="news-excerpt">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>
                        
                        <div class="news-footer">
                            <a href="{{ route('news.show', $item->id) }}" class="read-more-btn">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        @if(method_exists($news, 'links'))
            <div class="news-pagination">
                {{ $news->links() }}
            </div>
        @endif
    @else
        <div class="no-news">
            <div class="no-news-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h3>Belum Ada Berita</h3>
            <p>Saat ini belum ada berita yang tersedia untuk ditampilkan.</p>
        </div>
    @endif
</div>