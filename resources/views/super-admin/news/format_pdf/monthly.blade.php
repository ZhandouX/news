<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Berita {{ $monthName }} {{ $year }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
        }
        .header-section {
            text-align: left;
            margin-bottom: 16px;
            font-weight: bold;
        }
        .header-section p {
            margin: 0;
            padding: 2px 0;
        }
        .news-group {
            margin-bottom: 40px;
            page-break-after: always; /* Setiap sumber berita mulai di halaman baru */
        }
        .news-item { 
            margin-bottom: 25px; 
            page-break-inside: avoid; 
        }
        .news-item img { 
            width: 100%; 
            max-height: 300px; 
            object-fit: cover; 
            margin-bottom: 10px; 
        }
        .news-title { 
            font-size: 14px; 
            font-weight: bold; 
            margin-bottom: 4px; 
        }
        .news-date { 
            font-size: 12px; 
            color: #555; 
            margin-bottom: 10px; 
        }
        .news-link { 
            font-size: 12px; 
            color: #007bff; 
            text-decoration: none; 
            margin-bottom: 5px; 
            display: block; 
        }
        hr { 
            border: none; 
            border-top: 1px solid #4c4c4cff; 
            margin: 15px 0; 
        }
    </style>
</head>

<body>
    @php
        // Kelompokkan berita berdasarkan kolom 'sumber'
        $groupedNews = $news->groupBy('sumber');
    @endphp

    @foreach ($groupedNews as $sumber => $newsItems)
        <div class="news-group">
            <!-- Header untuk setiap sumber -->
            <div class="header-section">
                <p>EVIDANCE RILIS MEDIA KERJASAMA</p>
                <p>KANWIL KEMENKUM MALUKU</p>
                <p>BULAN : {{ $monthName }} {{ $year }}</p>
                <p>SUMBER : {{ $sumber ?? 'Tidak Diketahui' }}</p>
                <hr>
            </div>

            <!-- Daftar berita dari sumber ini -->
            @foreach ($newsItems as $item)
                <div class="news-item">
                    <div class="news-title">{{ $item->title }}</div>
                    <div class="news-date">
                        {{ \Carbon\Carbon::parse($item->news_date)->translatedFormat('d F Y') }}
                    </div>
                    <a class="news-link" href="{{ $item->link_berita }}" target="_blank">Lihat Berita</a>

                    @if ($item->compressed_image)
                        <img src="{{ public_path('storage/' . $item->compressed_image) }}" alt="Screenshot">
                    @endif

                    <hr>
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>
