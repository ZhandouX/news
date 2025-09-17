<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Berita {{ $monthName }} {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { text-align: center; margin-bottom: 30px; }
        .news-item { margin-bottom: 25px; page-break-inside: avoid; }
        .news-item img { width: 100%; max-height: 300px; object-fit: cover; margin-bottom: 10px; }
        .news-title { font-size: 14px; font-weight: bold; margin-bottom: 4px; }
        .news-date { font-size: 12px; color: #555; margin-bottom: 10px; }
        hr { border: none; border-top: 1px solid #ddd; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="title">
        <h2>Rekap Berita {{ $monthName }} {{ $year }}</h2>
    </div>
    <hr>

    @foreach($news as $item)
        <div class="news-item">
            @if($item->cover_image)
                <img src="{{ public_path('storage/' . $item->cover_image) }}" alt="Cover Image">
            @endif
            <div class="news-title">{{ $item->title }}</div>
            <div class="news-date">{{ \Carbon\Carbon::parse($item->news_date)->translatedFormat('d F Y') }}</div>
            <hr>
        </div>
    @endforeach
</body>
</html>
