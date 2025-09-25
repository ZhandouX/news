<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;

class SuperAdminNewsController extends Controller
{
    /* ================================== */
    /* ====== MANAGEMENT NEWS DATA ====== */
    /* ================================== */

    /* INDEX */
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request (atau default sekarang)
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Tentukan halaman saat ini dari request
        $currentPage = $request->get('periode', 1); // default page 1

        // Hitung batas bulan per halaman
        // contoh:
        // Halaman 1 = Jan-Jun
        // Halaman 2 = Jul-Des
        $monthsPerPage = 6;

        // Tentukan start dan end bulan berdasarkan halaman
        $startMonth = ($currentPage - 1) * $monthsPerPage + 1;
        $endMonth = $startMonth + $monthsPerPage - 1;

        // Range tanggal
        $startDate = Carbon::create($currentYear, $startMonth, 1)->startOfMonth();
        $endDate = Carbon::create($currentYear, $endMonth, 1)->endOfMonth();

        // Statistik bulanan per sumber
        $newsPerMonth = News::selectRaw("TO_CHAR(news_date, 'YYYY-MM') as month, sumber, COUNT(*) as count")
            ->whereBetween('news_date', [$startDate, $endDate])
            ->groupBy('month', 'sumber')
            ->orderBy('month', 'asc')
            ->orderBy('sumber', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'monthName' => Carbon::parse($item->month . '-01')->translatedFormat('F Y'),
                    'sumber' => $item->sumber,
                    'count' => (int) $item->count,
                ];
            })
            ->groupBy('month');

        // Query utama berita sesuai filter
        $query = News::query()
            ->whereBetween('news_date', [$startDate, $endDate])
            ->when($request->q, fn($q) => $q->where('title', 'like', '%' . $request->q . '%'))
            ->when($request->kategori, fn($q) => $q->where('category', $request->kategori))
            ->when($request->sumber, fn($q) => $q->where('sumber', $request->sumber))
            ->when($request->kantor, fn($q) => $q->where('office', $request->kantor))
            ->when(
                $request->start_date && $request->end_date,
                fn($q) => $q->whereBetween('news_date', [$request->start_date, $request->end_date])
            );

        // Paginate per berita dalam periode ini
        $news = $query->orderBy('news_date', 'desc')
            ->paginate(1000)
            ->withQueryString();

        // Group berita per bulan -> per sumber
        $groupedPageNews = $news->getCollection()
            ->groupBy(fn($item) => Carbon::parse($item->news_date)->format('Y-m'))
            ->map(fn($monthGroup) => $monthGroup->groupBy('sumber'));

        // Ambil dropdown filter
        $categories = News::select('category')->distinct()->orderBy('category')->pluck('category');
        $sources = News::select('sumber')->distinct()->orderBy('sumber')->pluck('sumber');
        $offices = News::select('office')->distinct()->orderBy('office')->pluck('office');

        // Hitung total periode dalam tahun ini
        $totalPeriods = ceil(12 / $monthsPerPage); // misal 2 periode: Jan-Jun & Jul-Des

        return view('super-admin.news.index', compact(
            'news',
            'groupedPageNews',
            'newsPerMonth',
            'categories',
            'sources',
            'offices',
            'currentPage',
            'totalPeriods',
            'startDate',
            'endDate'
        ));
    }

    // DASHBOARD
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

        $admins = User::role('admin')->get()->map(function ($admin) {
            $admin->news_count = $admin->news()->count();
            $admin->status = $admin->isOnline() ? 'Online' : 'Offline';
            return $admin;
        });

        $totalAdmins = $admins->count();

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
        $categories = News::select('category')
            ->distinct()
            ->pluck('category');
        $sources = News::select('sumber')
            ->distinct()
            ->pluck('sumber');
        $offices = News::select('office')
            ->distinct()
            ->pluck('office');

        return view('super-admin.dashboard', compact(
            'news',
            'newsPerMonth',
            'admins',
            'totalAdmins',
            'stats',
            'chartLabels',
            'chartData',
            'categories',
            'sources',
            'offices'
        ));
    }

    // CREATE NEWS
    public function create()
    {
        $categories = News::getCategories();
        $offices = News::getOfficeCategories();
        $sumbers = News::getSumberCategories();

        return view('super-admin.news.create', compact('categories', 'offices', 'sumbers'));
    }

    // SAVED NEWS
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

        return redirect()->route('super-admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    // SHOW NEWS
    public function show(News $news)
    {
        return view('super-admin.news.show', compact('news'));
    }

    // EDIT NEWS
    public function edit(News $news)
    {
        $categories = News::getCategories();
        $offices = News::getOfficeCategories();
        $sumbers = News::getSumberCategories();

        // Handle Office "Other"
        $officeOther = null;
        if (!in_array($news->office, $offices)) {
            $officeOther = $news->office;
            $news->office = 'Other';
        }

        // Handle Sumber "Other"
        $sumberOther = null;
        if (!in_array($news->sumber, $sumbers)) {
            $sumberOther = $news->sumber;
            $news->sumber = 'Other';
        }

        return view('super-admin.news.edit', compact(
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

        // Tangani office "Other"
        if ($request->office === 'Other') {
            $data['office'] = $request->office_other;
        }

        // Tangani sumber "Other"
        if ($request->sumber === 'Other') {
            $data['sumber'] = $request->sumber_other;
        }

        // Tangani cover image
        if ($request->hasFile('cover_image')) {
            if ($news->cover_image && Storage::disk('public')->exists($news->cover_image)) {
                Storage::disk('public')->delete($news->cover_image);
            }

            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('news/covers', $filename, 'public');
            $data['cover_image'] = $path;
        }

        $data['user_id'] = auth()->id();

        $news->update($data);

        return redirect()
            ->route('super-admin.news.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    // DESTROY NEWS
    public function destroy(News $news)
    {
        if ($news->cover_image && Storage::disk('public')->exists($news->cover_image)) {
            Storage::disk('public')->delete($news->cover_image);
        }

        $news->delete();

        return redirect()->route('super-admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
