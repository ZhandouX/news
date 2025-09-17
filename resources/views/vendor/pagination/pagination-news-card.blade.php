@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation" class="pagination-container">
        <ul class="pagination-list">
            {{-- Tombol First --}}
            @if ($paginator->currentPage() > 3)
                <li class="hidden-sm">
                    <a href="{{ $paginator->url(1) }}" class="pagination-link page-link" title="Halaman Pertama">««</a>
                </li>
            @endif

            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="pagination-disabled">«</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link page-link" rel="prev" title="Halaman Sebelumnya">«</a>
                </li>
            @endif

            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
            @endphp

            {{-- Jika total halaman <= 5, tampilkan semua --}}
            @if ($last <= 5)
                @for ($i = 1; $i <= $last; $i++)
                    @if ($i == $current)
                        <li><span class="pagination-current">{{ $i }}</span></li>
                    @else
                        <li><a href="{{ $paginator->url($i) }}" class="pagination-link page-link">{{ $i }}</a></li>
                    @endif
                @endfor
            @else
                {{-- Dots sebelum range --}}
                @if ($current > 3)
                    <li class="hidden-sm"><span class="pagination-dots">...</span></li>
                @endif

                {{-- Halaman Tengah --}}
                @php
                    $start = max(1, $current - 1);
                    $end = min($last, $current + 1);

                    // Untuk awal sekali (halaman 1 atau 2)
                    if ($current <= 2) {
                        $start = 1;
                        $end = 3;
                    }

                    // Untuk akhir sekali (halaman last atau last-1)
                    if ($current >= $last - 1) {
                        $start = $last - 2;
                        $end = $last;
                    }
                @endphp

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $current)
                        <li><span class="pagination-current">{{ $i }}</span></li>
                    @else
                        <li><a href="{{ $paginator->url($i) }}" class="pagination-link page-link">{{ $i }}</a></li>
                    @endif
                @endfor

                {{-- Dots setelah range --}}
                @if ($current < $last - 2)
                    <li class="hidden-sm"><span class="pagination-dots">...</span></li>
                @endif
            @endif

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link page-link" rel="next" title="Halaman Selanjutnya">»</a>
                </li>
            @else
                <li><span class="pagination-disabled">»</span></li>
            @endif

            {{-- Tombol Last --}}
            @if ($paginator->currentPage() < $last - 2)
                <li class="hidden-sm">
                    <a href="{{ $paginator->url($last) }}" class="pagination-link page-link" title="Halaman Terakhir">»»</a>
                </li>
            @endif
        </ul>

        {{-- Progress bar --}}
        <div class="progress-bar-container">
            <div class="progress-bar" style="width: {{ ($paginator->currentPage() / $paginator->lastPage()) * 100 }}%"></div>
        </div>
    </nav>

    {{-- CSS Custom --}}
    <style>
        /* Container utama */
        .pagination-container {
            margin: 20px 0;
        }

        /* List pagination */
        .pagination-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
            padding: 0;
            list-style: none;
        }

        /* Tombol umum */
        .pagination-link,
        .pagination-current,
        .pagination-disabled,
        .pagination-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 38px;
            height: 38px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: transparent;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        /* Hover efek */
        .pagination-link:hover {
            background-color: #ffcb01;
            color: #1d2650;
            border-color: transparent;
            transform: scale(1.05);
        }

        /* Halaman aktif */
        .pagination-current {
            background: #ffcb01;
            color: #1d2650;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }

        /* Disabled */
        .pagination-disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Dots */
        .pagination-dots {
            border: none;
            background: transparent;
            color: #6b7280;
            font-weight: bold;
            cursor: default;
            pointer-events: none;
        }

        /* Progress Bar */
        .progress-bar-container {
            margin-top: 12px;
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            transition: width 0.5s ease;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .hidden-sm {
                display: none;
            }
        }

        /* Loading state */
        .pagination-loading {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>

    {{-- JS UX tambahan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nav = document.querySelector('.pagination-container');

            if (!nav) return;

            // Efek loading ketika klik halaman
            nav.querySelectorAll('a.page-link').forEach(link => {
                link.addEventListener('click', function () {
                    nav.classList.add('pagination-loading');
                });
            });

            // Navigasi keyboard
            document.addEventListener('keydown', function (e) {
                const currentPage = {{ $paginator->currentPage() }};
                const lastPage = {{ $paginator->lastPage() }};

                if (e.key === 'ArrowLeft' && currentPage > 1) {
                    window.location.href = '{{ $paginator->previousPageUrl() ?? "#" }}';
                } else if (e.key === 'ArrowRight' && currentPage < lastPage) {
                    window.location.href = '{{ $paginator->nextPageUrl() ?? "#" }}';
                }
            });
        });
    </script>
@endif
