<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class AdminNewsFilterController extends Controller
{
    /* ========================================================= */
    /* ====================== FILTER FORM ====================== */
    /* ========================================================= */

    /* FILTER BY YEAR */
    public function filterByYear()
    {
        $yearList = News::selectRaw('DISTINCT EXTRACT(YEAR FROM news_date) AS year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('admin.news.filter-year', compact('yearList'));
    }

    // FILTER BY OFFICE
    public function filterByOffice()
    {
        $officeList = News::select('office')->distinct()->pluck('office');
        return view('admin.news.filter-office', compact('officeList'));
    }

    // FILTER BY SUMBER
    public function filterBySumber()
    {
        $sumberList = News::select('sumber')->distinct()->pluck('sumber');
        return view('admin.news.filter-sumber', compact('sumberList'));
    }

    // FILTER YEARLY LIST (AJAX)
    public function filterYearlyList(Request $request)
    {
        $year = (int) $request->query('year', date('Y'));

        $query = News::query();

        // Filter berdasarkan tahun
        $query->whereYear('news_date', $year);

        // Ambil data dengan pagination, misal 5 berita per halaman
        $news = $query->orderBy('news_date', 'desc')->paginate(5);

        // Format data agar konsisten
        $newsData = $news->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'news_date' => $item->news_date->format('Y-m-d'),
                'cover_image' => $item->cover_image,
                'sumber' => $item->sumber,
            ];
        });

        // Render pagination custom
        $paginationView = view('vendor.pagination.pagination-news-card', [
            'paginator' => $news
        ])->render();

        // Return JSON untuk AJAX
        return response()->json([
            'data' => $newsData,
            'pagination' => $paginationView
        ]);
    }

    // FILTER MONTHLY LIST
    public function filterByMonth()
    {
        $monthList = News::selectRaw('DISTINCT EXTRACT(MONTH FROM news_date) AS month')
            ->orderByDesc('month')
            ->pluck('month');

        return view('admin.news.filter-month', compact('monthList'));
    }

    // FILTER MONTHLY LIST (AJAX)
    public function filterMonthlyList(Request $request)
    {
        $yearMonth = $request->query('yearMonth'); // format: YYYY-MM

        $query = News::query();

        // Pastikan format "YYYY-MM" sebelum filter
        if (!empty($yearMonth) && preg_match('/^\d{4}-\d{2}$/', $yearMonth)) {
            [$year, $month] = explode('-', $yearMonth);

            $query->whereYear('news_date', $year)
                ->whereMonth('news_date', $month);
        }

        // Ambil data berita dengan pagination
        $news = $query->orderBy('news_date', 'desc')->paginate(5); // tampilkan 5 berita per halaman

        // Format data agar konsisten seperti yearly list
        $newsData = $news->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'news_date' => $item->news_date->format('Y-m-d'),
                'cover_image' => $item->cover_image,
                'sumber' => $item->sumber,
            ];
        });

        // Render pagination custom ke HTML
        $paginationView = view('vendor.pagination.pagination-news-card', [
            'paginator' => $news
        ])->render();

        // Return JSON untuk AJAX
        return response()->json([
            'data' => $newsData,
            'pagination' => $paginationView
        ]);
    }

    public function filterSumberList(Request $request)
    {
        $yearMonth = $request->query('yearMonth');
        $sumber = $request->query('sumber');

        $query = News::query();

        if (!empty($sumber)) {
            $query->where('sumber', $sumber);
        }

        if (!empty($yearMonth) && preg_match('/^\d{4}-\d{2}$/', $yearMonth)) {
            [$year, $month] = explode('-', $yearMonth);
            $query->whereYear('news_date', $year)
                ->whereMonth('news_date', $month);
        }

        $news = $query->orderBy('news_date', 'desc')->paginate(5);

        $newsData = $news->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'news_date' => $item->news_date->format('Y-m-d'),
                'cover_image' => $item->cover_image,
                'sumber' => $item->sumber,
            ];
        });

        $paginationView = view('vendor.pagination.pagination-news-card', [
            'paginator' => $news
        ])->render();

        return response()->json([
            'data' => $newsData,
            'pagination' => $paginationView
        ]);
    }

    public function filterOfficeList(Request $request)
    {
        $yearMonth = $request->query('yearMonth');
        $office = $request->query('office');

        $query = News::query();

        if (!empty($office)) {
            $query->where('office', $office);
        }

        if (!empty($yearMonth) && preg_match('/^\d{4}-\d{2}$/', $yearMonth)) {
            [$year, $month] = explode('-', $yearMonth);
            $query->whereYear('news_date', $year)
                ->whereMonth('news_date', $month);
        }

        $news = $query->orderBy('news_date', 'desc')->paginate(5);

        $newsData = $news->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'news_date' => $item->news_date->format('Y-m-d'),
                'cover_image' => $item->cover_image,
                'office' => $item->office,
            ];
        });

        $paginationView = view('vendor.pagination.pagination-news-card', [
            'paginator' => $news
        ])->render();

        return response()->json([
            'data' => $newsData,
            'pagination' => $paginationView
        ]);
    }

    public function filterOfficeYearlyList(Request $request)
    {
        $year = $request->query('year', date('Y'));
        $office = $request->query('office');

        $query = News::query();

        // Filter office
        if (!empty($office)) {
            $query->where('office', $office);
        }

        // Filter tahun
        if (!empty($year)) {
            $query->whereYear('news_date', $year);
        }

        // Pagination
        $news = $query->orderBy('news_date', 'desc')->paginate(5);

        // Format data
        $newsData = $news->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'news_date' => $item->news_date->format('Y-m-d'),
                'cover_image' => $item->cover_image,
                'office' => $item->office,
            ];
        });

        // Render pagination custom
        $paginationView = view('vendor.pagination.pagination-news-card', [
            'paginator' => $news
        ])->render();

        return response()->json([
            'data' => $newsData,
            'pagination' => $paginationView
        ]);
    }

    public function filterSumberYearlyList(Request $request)
    {
        $year = $request->query('year', date('Y'));
        $sumber = $request->query('sumber');

        $query = News::query();

        // Filter sumber
        if (!empty($sumber)) {
            $query->where('sumber', $sumber);
        }

        // Filter tahun
        if (!empty($year)) {
            $query->whereYear('news_date', $year);
        }

        // Pagination
        $news = $query->orderBy('news_date', 'desc')->paginate(5);

        // Format data
        $newsData = $news->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'news_date' => $item->news_date->format('Y-m-d'),
                'cover_image' => $item->cover_image,
                'sumber' => $item->sumber,
            ];
        });

        // Render pagination custom
        $paginationView = view('vendor.pagination.pagination-news-card', [
            'paginator' => $news
        ])->render();

        return response()->json([
            'data' => $newsData,
            'pagination' => $paginationView
        ]);
    }

    // FILTER BY OFFICE YEAR
    public function filterByOfficeYear()
    {
        $officeList = News::select('office')->distinct()->pluck('office');
        return view('admin.news.filter-office-year', compact('officeList'));
    }

    public function filterBySumberYear()
    {
        $sumberList = News::select('sumber')->distinct()->pluck('sumber');
        return view('admin.news.filter-sumber-year', compact('sumberList'));
    }
}
