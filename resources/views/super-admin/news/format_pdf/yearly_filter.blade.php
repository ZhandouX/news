<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Berita {{ $year }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .title { font-size: 14px; text-align: left; margin-bottom: 16px; font-weight: bold; }
        .news-item { margin-bottom: 25px; page-break-inside: avoid; }
        .news-item img { width: 100%; max-height: 300px; object-fit: cover; margin-bottom: 10px; }
        .news-title { font-size: 14px; font-weight: bold; margin-bottom: 4px; }
        .news-date { font-size: 12px; color: #555; margin-bottom: 10px; }
        .news-link { font-size: 12px; color: #007bff; text-decoration: none; margin-bottom: 5px; display: block; }
        hr { border: none; border-top: 1px solid #4c4c4cff; margin: 15px 0; }
    </style>
</head>

<body>
    <div class="title">
        <!-- <h2>REKAP TAHUNAN</h2> -->
        <p>EVIDANCE RILIS MEDIA KERJASAMA</p>
        <p>KANWIL KEMENKUM MALUKU</p>
        <p>Tahun: {{ $year }}</p>
        <p>{{ $filterValue }}</p>
        <hr>
    </div>

    @foreach($news as $item)
        <div class="news-item">
            <div class="news-title">{{ $item->title }}</div>
            <div class="news-date">{{ \Carbon\Carbon::parse($item->news_date)->translatedFormat('d F Y') }}</div>
            <div class="news-link">
                <a class="news-link" href="{{ $item->link_berita }}" target="_blank">Lihat Berita</a>
            </div>
            @if($item->compressed_image)
                <img src="{{ public_path('storage/' . $item->compressed_image) }}" class="news-img" alt="Cover Image">
            @endif
            <hr>
        </div>
    @endforeach
</body>

</html>