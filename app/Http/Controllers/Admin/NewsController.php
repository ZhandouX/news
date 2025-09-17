<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use App\Models\News;
use Carbon\Carbon;

class NewsController extends Controller
{
    /* ================================== */
    /* ====== MANAGEMENT NEWS DATA ====== */
    /* ================================== */

    /* NEWS INDEX */
    public function index(Request $request)
    {
        // Statistik bulanan (Postgres pakai TO_CHAR)
        $newsPerMonth = News::selectRaw("TO_CHAR(news_date, 'YYYY-MM') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'monthName' => Carbon::parse($item->month . '-01')->translatedFormat('F Y'),
                    'count' => $item->count,
                ];
            })
            ->keyBy('month');

        // Data utama (pencarian & filter)
        $news = News::when($request->q, fn($q) =>
            $q->where('title', 'like', '%' . $request->q . '%'))
            ->when($request->kategori, fn($q) =>
                $q->where('category', $request->kategori))
            ->when($request->sumber, fn($q) =>
                $q->where('sumber', $request->sumber))
            ->when($request->kantor, fn($q) =>
                $q->where('office', $request->kantor))
            ->when($request->date, fn($q) =>
                $q->whereDate('news_date', $request->date)) // Single date
            ->when($request->start_date && $request->end_date, fn($q) =>
                $q->whereBetween('news_date', [$request->start_date, $request->end_date])) // Range
            ->orderBy('news_date', 'desc')
            ->paginate(25)
            ->withQueryString();

        // Dropdown list
        $categories = News::select('category')->distinct()->orderBy('category')->pluck('category');
        $sources = News::select('sumber')->distinct()->orderBy('sumber')->pluck('sumber');
        $offices = News::select('office')->distinct()->orderBy('office')->pluck('office');

        return view('admin.news.index', compact('news', 'newsPerMonth', 'categories', 'sources', 'offices'));
    }

    // ADMIN DASHBOARD
    public function dashboard()
    {
        $allNews = News::orderBy('news_date', 'desc')->get();

        $newsPerMonth = $allNews->groupBy(function ($item) {
            return Carbon::parse($item->news_date)->format('Y-m');
        })->map(function ($items) {
            $totalTarget = 30;
            $count = $items->count();
            $progress = ($count / $totalTarget) * 100;

            return [
                'monthName' => Carbon::parse($items->first()->news_date)->translatedFormat('F Y'),
                'count' => $count,
                'target' => $totalTarget,
                'progress' => $progress
            ];
        });

        $news = News::orderBy('news_date', 'desc')->paginate(2);

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        $stats = [
            'total_news' => News::count(),
            'news_this_week' => News::whereBetween('news_date', [$startOfWeek, $today])->count(),
            'news_this_month' => News::whereBetween('news_date', [$startOfMonth, $today])->count(),
            'news_last_month' => News::whereBetween('news_date', [$startOfLastMonth, $endOfLastMonth])->count(),
            'news_this_year' => News::whereYear('news_date', $today->year)->count(),
        ];

        $chartLabels = $newsPerMonth->pluck('monthName')->toArray();
        $chartData = $newsPerMonth->pluck('count')->toArray();

        // 🔹 ambil nilai unik untuk dropdown
        $categories = News::select('category')->distinct()->pluck('category');
        $sources = News::select('sumber')->distinct()->pluck('sumber');
        $offices = News::select('office')->distinct()->pluck('office');

        return view('admin.dashboard', compact(
            'news',
            'newsPerMonth',
            'stats',
            'chartLabels',
            'chartData',
            'categories',
            'sources',
            'offices'
        ));
    }


    // NEWS CREATE
    public function create()
    {
        $categories = News::getCategories();
        $offices = News::getOfficeCategories();
        $sumbers = News::getSumberCategories();

        return view('admin.news.create', compact('categories', 'offices', 'sumbers'));
    }

    // NEWS SAVED (STORE)
    public function store(NewsRequest $request)
    {
        // Ambil data input
        $data = $request->only([
            'title',
            'content',
            'news_date',
            'category',
            'office',
            'office_other',
            'sumber',
            'sumber_other',
            'link_sumber',
            'link_sumber_other',
            'link_berita'
        ]);

        // Jika memilih Other, gunakan office_other sebagai office
        if ($request->office === 'Other') {
            $data['office'] = $request->office_other;
        }
        // Hapus office_other supaya tidak tersimpan ke DB
        unset($data['office_other']);

        // SUMBER & LINK
        if ($request->sumber === 'Other') {
            $data['sumber'] = $request->sumber_other;
            $data['link_sumber'] = $request->link_sumber_other;
        } else {
            $data['link_sumber'] = News::getSumberLinks()[$request->sumber] ?? null;
        }
        unset($data['sumber_other'], $data['link_sumber_other']);

        // Upload cover image jika ada
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('news/covers', $filename, 'public');
            $data['cover_image'] = $path;
        }

        // Set user_id
        $data['user_id'] = auth()->id();

        // Simpan ke DB
        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    // SHOW NEWS
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    // EDIT NEWS
    public function edit(News $news)
    {
        $categories = News::getCategories();
        $offices = News::getOfficeCategories();
        $sumbers = News::getSumberCategories();

        // HANDLE OFFICE "Other"
        $officeOther = null;
        if (!in_array($news->office, $offices)) {
            $officeOther = $news->office;
            $news->office = 'Other';
        }

        // HANDLE SUMBER "Other"
        $sumberOther = null;
        if (!in_array($news->sumber, $sumbers)) {
            $news->sumber = 'Other';
        }

        return view('admin.news.edit', compact(
            'news', 
            'categories', 
            'offices', 
            'sumbers', 
            'officeOther', 
            'sumberOther'
        ));
    }

    // UPDATE NEWS
    public function update(NewsRequest $request, News $news)
    {
        $data = $request->only([
            'title',
            'news_date',
            'content',
            'category',
            'office',
            'sumber',
            'link_berita',
        ]);

        // HANDLE OFFICE "Other"
        if ($request->office === 'Other') {
            $data['office'] = $request->office_other;
        }

        // HANDLE SUMBER "Other"
        if ($request->sumber === 'Other') {
            $data['office'] = $request->sumber_other;
        }

        // HANDLE COVER IMAGE
        if ($request->hasFile('cover_image')) {
            if ($news->cover_image && Storage::disk('public')->exists($news->cover_image)) {
                Storage::disk('public')->delete($news->cover_image);
            }

            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('news/covers', $filename, 'public');
            $data['cover_image'] = $path;
        }

        // Tambahkan user_id (supaya tidak null)
        $data['user_id'] = auth()->id();

        $news->update($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    // DESTROY NEWS
    public function destroy(News $news)
    {
        if ($news->cover_image && Storage::disk('public')->exists($news->cover_image)) {
            Storage::disk('public')->delete($news->cover_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
