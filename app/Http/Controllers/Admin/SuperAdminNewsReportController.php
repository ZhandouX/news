<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\News;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Symfony\Component\Console\Input\InputOption;
use function PHPUnit\Framework\fileExists;

class SuperAdminNewsReportController extends Controller
{
    /* ====================================== */
    /* ============ REKAP BERITA ============ */
    /* ====================================== */

    /* REKAP BERITA BULANAN (REPORT TABLE) */
    public function exportMonthlyReport(string $year, string $month)
    {
        $year = (int) $year;
        $month = (int) ltrim($month, '0');

        if ($month < 1 || $month > 12) {
            abort(404);
        }

        $news = News::whereYear('news_date', $year)
            ->whereMonth('news_date', $month)
            ->orderBy('news_date', 'asc')
            ->get();

        if ($news->isEmpty()) {
            return back()->with('error', 'Tidak ada berita pada bulan tersebut.');
        }

        // Inisialisasi Image Manager (Menggunakan GD Driver)
        $manager = new ImageManager(new Driver());

        //Compress cover_image sebelum masuk ke PDF
        foreach ($news as $item) {
            if ($item->cover_image) {
                $path = storage_path("app/public/{$item->cover_image}");

                if (file_exists($path)) {
                    try {
                        // Resize max width 800px & Compress ke JPG berkualitas 70%
                        $image = $manager->read($path)
                            ->scale(width: 800)
                            ->toJpeg(70);
                        
                        // Simpan ke folder cache
                        $cacheDir = storage_path('app/public/pdf-cache');
                        if (!file_exists($cacheDir)) {
                            mkdir($cacheDir, 0755, true);
                        }

                        $tempPath = $cacheDir . "/news-{$item->id}.jpg";
                        $image->save($tempPath);

                        // Simpan ke dalam path baru
                        $item->compressed_image = "pdf-cache/news-{$item->id}.jpg";
                    } catch (\Exception $e) {
                        // Fallback -> menggunakan originalnya
                        $item->compressed_image = $item->cover_image;
                    }
                } else {
                    $item->compressed_image = $item->cover_image;
                }
            } else {
                $item->compressed_image = null;
            }
        }

        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('super-admin.news.format_pdf.monthly', compact('news', 'month', 'year', 'monthName'))
            ->setPaper('A4', 'portrait')
            ->setOption('dpi', 96)
            ->setOption('defaultFont', 'sans-serif');

        return $pdf->download("Rekap-Berita-{$monthName}-{$year}.pdf");
    }

    // REKAP BERITA (TAHUN)
    public function exportYearlyReportByYear(Request $request)
    {
        $year = (int) $request->year;

        $query = News::whereYear('news_date', $year);

        $news = $query->orderBy('news_date', 'asc')->get();

        if ($news->isEmpty()) {
            return back()->with('error', "Tidak ada berita pada tahun {$year}.");
        }

        // Inisialisasi Image Manager (menggunakan GD Driver)
        $manager = new ImageManager(new Driver());

        // Compress cover_image sebelum masuk ke PDF
        foreach ($news as $item) {
            if ($item->cover_image) {
                $path = storage_path("app/public/{$item->cover_image}");

                if (file_exists($path)) {
                    try {
                        // Resize max width 800px & Compress ke JPG berkualitas 70%
                        $image = $manager->read($path)
                            ->scale(width: 800)
                            ->toJpeg(70);

                        // Simpan ke folder cache
                        $cacheDir = storage_path('app/public/pdf-cache');
                        if (!file_exists($cacheDir)) {
                            mkdir($cacheDir, 0755, true);
                        }

                        // Simpan ke folder path baru
                        $tempPath = $cacheDir . "/news-{$item->id}.jpg";
                    } catch (\Exception $e) {
                        // Fallback -> pakai original
                        $item->compressed_image = $item->cover_image;
                    }
                } else {
                    $item->compressed_image = $item->cover_image;
                }
            } else {
                $item->compressed_image = null;
            }
        }

        $pdf = Pdf::loadView('super-admin.news.format_pdf.yearly', [
            'news' => $news,
            'year' => $year,
        ])
            ->setPaper('A4', 'portrait')
            ->setOption('dpi', 96)
            ->setOption('defaultFont', 'sans-serif');

        return $pdf->download("Rekap-Berita-Tahun-{$year}.pdf");
    }

    // REKAP BERITA (BULAN)
    public function exportMonthlyReportByMonth(Request $request)
    {
        $monthInput = $request->get('month'); // format "YYYY-MM"

        if (!$monthInput) {
            return back()->with('error', 'Bulan dan filter harus dipilih.');
        }

        [$year, $month] = explode('-', $monthInput);
        $year = (int) $year;
        $month = (int) ltrim($month, '0');

        $news = News::whereYear('news_date', $year)
            ->whereMonth('news_date', $month)
            ->orderBy('news_date', 'asc')
            ->get();

        if ($news->isEmpty()) {
            return back()->with('error', "Tidak ada berita pada bulan {$month}-{$year}.");
        }

        // ✅ Inisialisasi Image Manager (pakai GD driver)
        $manager = new ImageManager(new Driver());

        // ✅ Kompres cover_image sebelum masuk ke PDF
        foreach ($news as $item) {
            if ($item->cover_image) {
                $path = storage_path("app/public/{$item->cover_image}");

                if (file_exists($path)) {
                    try {
                        // Resize max width 800px & kompres ke JPG kualitas 70%
                        $image = $manager->read($path)
                            ->scale(width: 800)
                            ->toJpeg(70);

                        // Simpan ke folder cache
                        $cacheDir = storage_path('app/public/pdf-cache');
                        if (!file_exists($cacheDir)) {
                            mkdir($cacheDir, 0755, true);
                        }

                        $tempPath = $cacheDir . "/news-{$item->id}.jpg";
                        $image->save($tempPath);

                        // Simpan path baru
                        $item->compressed_image = "pdf-cache/news-{$item->id}.jpg";
                    } catch (\Exception $e) {
                        // fallback → pakai original
                        $item->compressed_image = $item->cover_image;
                    }
                } else {
                    $item->compressed_image = $item->cover_image;
                }
            } else {
                $item->compressed_image = null;
            }
        }

        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F');

        // ✅ generate PDF
        $pdf = Pdf::loadView('super-admin.news.format_pdf.monthly', [
            'news' => $news,
            'year' => $year,
            'month' => $month,
            'monthName' => $monthName,
        ])
            ->setPaper('A4', 'portrait')
            ->setOption('dpi', 96) // turunkan DPI biar kecil
            ->setOption('defaultFont', 'sans-serif');

        return $pdf->download("Rekap-Berita-{$monthName}-{$year}.pdf");
    }

    /* ==================================================== */
    /* ============ REKAP BERITA DENGAN FILTER ============ */
    /* ==================================================== */

    /* REKAP BERITA FILTER (BULAN: UNIT UTAMA & SUMBER)  */
    public function exportMonthlyReportByOfficeOrSumberForm(Request $request)
    {
        $monthInput = $request->get('month'); // format YYYY-MM
        $filterType = $request->get('filterType'); // office / sumber
        $filterValue = $request->get('filterValue');

        if (!$monthInput || !$filterType || !$filterValue) {
            return back()->with('error', 'Bulan dan filter harus dipilih.');
        }

        [$year, $month] = explode('-', $monthInput);
        $year = (int) $year;
        $month = (int) ltrim($month, '0');

        $query = News::whereYear('news_date', $year)
            ->whereMonth('news_date', $month);

        if ($filterType === 'office') {
            $query->where('office', $filterValue);
        } elseif ($filterType === 'sumber') {
            $query->where('sumber', $filterValue);
        }

        $news = $query->orderBy('news_date', 'asc')->get();

        if ($news->isEmpty()) {
            return back()->with('error', "Tidak ada berita pada bulan {$month}-{$year} untuk {$filterType}: {$filterValue}.");
        }

        // Inisialisasi Image Manager (menggunakan GD Driver)
        $manager = new ImageManager(new Driver());

        // Compress cover_image sebelum masuk ke PDF
        foreach ($news as $item) {
            if ($item->cover_image) {
                $path = storage_path("app/public/{$item->cover_image}");

                if (file_exists($path)) {
                    try {
                        // Resize max width 800px & Compress ke JPG berkualitas 70%
                        $image = $manager->read($path)
                            ->scale(width: 800)
                            ->toJpeg(70);

                        // Simpan ke folder cache
                        $cacheDir = storage_path('app/public/pdf-cache');
                        if (!file_exists($cacheDir)) {
                            mkdir($cacheDir, 0755, true);
                        }

                        $tempPath = $cacheDir . "/news-{$item->id}.jpg";
                        $image->save($tempPath);

                        // Simpan ke path baru
                        $item->compressed_image = "pdf-cache/news-{$item->id}.jpg";
                    } catch (\Exception $e) {
                        // Fallback -> pakai original
                        $item->compressed_image = $item->cover_image;
                    }
                } else {
                    $item->compressed_image = $item->cover_image;
                }
            } else {
                $item->compressed_image = null;
            }
        }

        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('super-admin.news.format_pdf.monthly_filter', [
            'news' => $news,
            'year' => $year,
            'month' => $month,
            'monthName' => $monthName,
            'filterType' => $filterType,
            'filterValue' => $filterValue,
        ])
            ->setPaper('A4', 'portrait')
            ->setOption('dpi', 96) // menurunkan DPI gambar supaya lebih kecil
            ->setOption('defaultFont', 'sans-serif');

        return $pdf->download("Rekap-Berita-{$filterType}-{$filterValue}-{$monthName}-{$year}.pdf");
    }

    // REKAP BERITA FILTER (TAHUN: UNIT UTAMA & SUMBER)
    public function exportYearlyReportByOfficeOrSumberForm(Request $request)
    {
        $year = (int) $request->year;
        $filterType = $request->filterType;
        $filterValue = $request->filterValue;

        $query = News::whereYear('news_date', $year);

        if ($filterType === 'office') {
            $query->where('office', $filterValue);
        } elseif ($filterType === 'sumber') {
            $query->where('sumber', $filterValue);
        }

        $news = $query->orderBy('news_date', 'asc')->get();

        if ($news->isEmpty()) {
            return back()->with('error', "Tidak ada berita pada tahun {$year} untuk {$filterType}: {$filterValue}.");
        }

        // Inisialisasi Image Manager (menggunakan GD Driver)
        $manager = new ImageManager(new Driver());

        // Compress cover_image sebelum masuk ke PDF
        foreach ($news as $item) {
            if ($item->cover_image) {
                $path = storage_path("app/public/{$item->cover_image}");

                if (fileExists($path)) {
                    try {
                        // Resize max width (800px) & Compress ke JPG berkualitas 70%
                        $image = $manager->read($path)
                            ->scale(width: 800)
                            ->toJpeg(70);

                        // Simpan ke folder cache
                        $cacheDir = storage_path('app/public/pdf-cache');
                        if (!file_exists($cacheDir)) {
                            mkdir($cacheDir, 0755, true);
                        }

                        $tempPath = $cacheDir . "/news-{$item->id}.jpg";
                        $image->save($tempPath);

                        // Simpan file ke folder path baru
                        $item->compressed_image = "pdf-cache/news-{$item->id}.jpg";
                    } catch (\Exception $e) {
                        // Falback -> pakai original
                        $item->compressed_image = $item->cover_image;
                    }
                } else {
                    $item->compressed_image = $item->cover_image;
                }
            } else {
                $item->compressed_image = null;
            }
        }

        $pdf = Pdf::loadView('super-admin.news.format_pdf.yearly_filter', [
            'news' => $news,
            'year' => $year,
            'filterType' => $filterType,
            'filterValue' => $filterValue,
        ])
            ->setPaper('A4', 'portrait')
            ->setOption('dpi', 96)
            ->setOption('defaultFont', 'sans-serif');

        return $pdf->download("Rekap-Berita-{$filterType}-{$filterValue}-{$year}.pdf");
    }

}
