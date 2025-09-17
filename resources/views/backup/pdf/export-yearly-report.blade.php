<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Berita {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h2 { margin: 0; }
        .header p { margin: 0; font-size: 12px; color: #555; }

        .news-item { margin-bottom: 25px; page-break-inside: avoid; }
        .news-title { font-size: 14px; font-weight: bold; margin-bottom: 4px; }
        .news-date { font-size: 12px; color: #555; margin-bottom: 4px; }
        .news-link { font-size: 12px; margin-bottom: 4px; display: inline-block; }
        .news-img { width: 100%; max-height: 300px; object-fit: cover; margin-bottom: 10px; }
        hr { border: none; border-top: 1px solid #ddd; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAP BERITA</h2>
        <p>Tahun {{ $year }}</p>
        <hr>
    </div>

    @foreach($news as $item)
        <div class="news-item">
            <div class="news-title">{{ $item->title }}</div>
            <div class="news-date">{{ \Carbon\Carbon::parse($item->news_date)->translatedFormat('d F Y') }}</div>
            <div class="news-link">
                <a class="news-link" href="{{ $item->link_berita }}" target="_blank">Lihat Berita</a>
            </div>
            @if($item->cover_image)
                <img src="{{ public_path('storage/' . $item->cover_image) }}" class="news-img" alt="Cover Image">
            @endif
            <hr>
        </div>
    @endforeach
</body>
</html>
