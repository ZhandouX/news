<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Berita {{ $monthName }} {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 0; font-size: 14px; }

        .news-item { margin-bottom: 25px; page-break-inside: avoid; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .news-title { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        .news-date { font-size: 12px; color: #555; margin-bottom: 5px; }
        .news-link { font-size: 12px; color: #007bff; text-decoration: none; margin-bottom: 5px; display: block; }
        .news-img { width: 100%; max-height: 300px; object-fit: cover; margin-top: 5px; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h2>REKAP BERITA</h2>
        <p>{{ $monthName }} {{ $year }}</p>
        <p>Sumber: {{ ucfirst($filterType) }} - {{ $filterValue }}</p>
        <hr>
    </div>

    {{-- ISI BERITA --}}
    @foreach($news as $item)
        <div class="news-item">
            <div class="news-title">{{ $item->title }}</div>
            <div class="news-date">Tanggal: {{ \Carbon\Carbon::parse($item->news_date)->translatedFormat('d F Y') }}</div>
            <a class="news-link" href="{{ $item->link_berita }}" target="_blank">Lihat Berita</a>
            @if($item->cover_image)
                <img class="news-img" src="{{ public_path('storage/' . $item->cover_image) }}" alt="Cover Image">
            @endif
        </div>
    @endforeach

</body>
</html>
