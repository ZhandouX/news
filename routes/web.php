<?php

use App\Http\Controllers\Admin\AdminNewsFilterController;
use App\Http\Controllers\Admin\AdminNewsReportController;
use App\Http\Controllers\Admin\OfficerManagementController;
use App\Http\Controllers\Admin\SuperAdminNewsController;
use App\Http\Controllers\Admin\SuperAdminNewsFilterController;
use App\Http\Controllers\Admin\SuperAdminNewsReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\UserNewsController;
use App\Http\Middleware\LastSeen;
use Illuminate\Support\Facades\Auth;

// ROUTE DEFAULT UNTUK LANDING PAGE (SAAT PERTAMA KALI MEMBUKA WEBSITE)
Route::get('/', function () {
    if (Auth::check()) {
        // Jika sudah login, redirect ke dashboard sesuai role
        $user = Auth::user();
        if ($user->hasRole('super-admin')) {
            return redirect()->route('super-admin.dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('user')) {
            return redirect()->route('user.dashboard');
        } else {
            // Default jika role tidak dikenal
            return redirect('/login');
        }
    }
    return redirect()->route('login');
});

// ROUTE AUTH SETELAH LOGIN AGAR MENUJU KE HALAMAN DASHBOARD SESUAI DENGAN ROLE MASING-MASING
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role.redirect'])->name('dashboard');

/* ============================================================================= */
/* ====== SUPER-ADMIN ROUTES. (WARNING : JANGAN MENGUBAH URUTAN ROUTE!!!) ====== */
/* ============================================================================= */
Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'verified', 'role:super-admin', 'last.seen'])->group(function () {
    Route::get('/dashboard', [SuperAdminNewsController::class, 'dashboard'])->name('dashboard');

    // HANDLE NEWS ROUTES
    Route::resource('news', SuperAdminNewsController::class);
    Route::get('officer-account', [OfficerManagementController::class, 'officerAccount'])->name('news.officer-account');

    // EXPORT PDF MONTHLY & YEARLY (JANGAN MENGUBAH URUTAN ROUTE INI!!!)
    Route::get('news-report/{year}/{month}/pdf', [SuperAdminNewsReportController::class, 'exportMonthlyReport'])->name('news.monthly-report-pdf');
    Route::get('news-report/pdf', [SuperAdminNewsReportController::class, 'exportMonthlyReportByMonth'])->name('news.export-monthly-report');
    Route::get('news/export/monthly', [SuperAdminNewsReportController::class, 'exportMonthlyReportByOfficeOrSumberForm'])->name('news.export-monthly-report-filter');
    Route::get('news/export/yearly', [SuperAdminNewsReportController::class, 'exportYearlyReportByYear'])->name('news.export-yearly-report');
    Route::get('news/export/yearly/filter', [SuperAdminNewsReportController::class, 'exportYearlyReportByOfficeOrSumberForm'])->name('news.export-yearly-report-filter');

    /* ========== MONTHLY FILTER LIST ========== */
    // BY OFFICES
    Route::get('rekap/bulanan/kantor', [SuperAdminNewsFilterController::class, 'filterByOffice'])->name('rekap.bulanan.kantor');
    Route::get('rekap/bulanan/kantor/list', [SuperAdminNewsFilterController::class, 'filterOfficeList'])->name('news.filter-office.list');

    // BY SUMBERS
    Route::get('rekap/bulanan/sumber', [SuperAdminNewsFilterController::class, 'filterBySumber'])->name('rekap.bulanan.sumber');
    Route::get('rekap/bulanan/sumber/list', [SuperAdminNewsFilterController::class, 'filterSumberList'])->name('news.filter-sumber.list');

    // BY MONTH
    Route::get('rekap/bulanan', [SuperAdminNewsFilterController::class, 'filterByMonth'])->name('rekap.bulanan');
    Route::get('rekap/bulanan/list', [SuperAdminNewsFilterController::class, 'filterMonthlyList'])->name('news.filter-month.list');

    /* ========== YEARLY FILTER LIST ========== */
    // BY OFFICES
    Route::get('rekap/tahunan/kantor', [SuperAdminNewsFilterController::class, 'filterByOfficeYear'])->name('rekap.tahunan.kantor');
    Route::get('rekap/tahunan/kantor/list', [SuperAdminNewsFilterController::class, 'filterOfficeYearlyList'])->name('news.filter-office.yearly.list');

    // BY SUMBERS
    Route::get('rekap/tahunan/sumber', [SuperAdminNewsFilterController::class, 'filterBySumberYear'])->name('rekap.tahunan.sumber');
    Route::get('rekap/tahunan/sumber/list', [SuperAdminNewsFilterController::class, 'filterSumberYearlyList'])->name('news.filter-sumber.yearly.list');

    // BY YEAR
    Route::get('rekap/tahunan', [SuperAdminNewsFilterController::class, 'filterByYear'])->name('rekap.tahunan');
    Route::get('rekap/tahunan/list', [SuperAdminNewsFilterController::class, 'filterYearlyList'])->name('news.filter-year.list');

    // OFFICER ACCOUNT. AJAX ROUTER FOR UPDATE STATUS (ONLINE/OFFLINE)
    Route::get('officer-status', [OfficerManagementController::class, 'officerStatus'])->name('news.officer-status');

    // MANAGEMENT OFFICER ACCOUNT ROUTES==> ROUTE UNTUK MENGELOLA AKUN PETUGAS (role admin)
    Route::get('admins', [OfficerManagementController::class, 'indexAdmin'])->name('admins.index');
    Route::get('admins/create', [OfficerManagementController::class, 'createAdmin'])->name('admins.create');
    Route::post('admins', [OfficerManagementController::class, 'storeAdmin'])->name('admins.store');
    Route::get('admins/{user}/edit', [OfficerManagementController::class, 'editAdmin'])->name('admins.edit');
    Route::put('admins/{user}', [OfficerManagementController::class, 'updateAdmin'])->name('admins.update');
    Route::delete('admins/{user}', [OfficerManagementController::class, 'destroyAdmin'])->name('admins.destroy');
});


/* ====================================================================================== */
/* ====== ADMIN (OFFICER/PETUGAS) ROUTES. (WARNING : JANGAN MENGUBAH URUTAN ROUTE) ====== */
/* ====================================================================================== */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:admin', 'last.seen'])->group(function () {
    Route::get('/dashboard', [NewsController::class, 'dashboard'])->name('dashboard');

    // NEWS REPORT TABLE NEWS REPORT
    Route::resource('news', NewsController::class);

    // EXPORT PDF MONTHLY & YEARLY
    Route::get('news-report/{year}/{month}/pdf', [AdminNewsReportController::class, 'exportMonthlyReport'])->name('news.monthly-report-pdf');
    Route::get('news-report/pdf', [AdminNewsReportController::class, 'exportMonthlyReportByMonth'])->name('news.export-monthly-report');
    Route::get('news/export/monthly', [AdminNewsReportController::class, 'exportMonthlyReportByOfficeOrSumberForm'])->name('news.export-monthly-report-filter');
    Route::get('news/export/yearly', [AdminNewsReportController::class, 'exportYearlyReportByYear'])->name('news.export-yearly-report');
    Route::get('news/export/yearly/filter', [AdminNewsReportController::class, 'exportYearlyReportByOfficeOrSumberForm'])->name('news.export-yearly-report-filter');

    // ==== MONTHLY FILTER LIST ====
    /* ByOffices */
    Route::get('rekap/bulanan/kantor', [AdminNewsFilterController::class, 'filterByOffice'])->name('rekap.bulanan.kantor');
    Route::get('rekap/bulanan/kantor/list', [AdminNewsFilterController::class, 'filterOfficeList'])->name('news.filter-office.list');

    /* BySumbers */
    Route::get('rekap/bulanan/sumber', [AdminNewsFilterController::class, 'filterBySumber'])->name('rekap.bulanan.sumber');
    Route::get('rekap/bulanan/sumber/list', [AdminNewsFilterController::class, 'filterSumberList'])->name('news.filter-sumber.list');

    /* ByMonth */
    Route::get('rekap/bulanan', [AdminNewsFilterController::class, 'filterByMonth'])->name('rekap.bulanan');
    Route::get('rekap/bulanan/list', [AdminNewsFilterController::class, 'filterMonthlyList'])->name('news.filter-month.list');

    // ==== YEARLY FILTER LIST ====
    /* ByOffices */
    Route::get('rekap/tahunan/kantor', [AdminNewsFilterController::class, 'filterByOfficeYear'])->name('rekap.tahunan.kantor');
    Route::get('rekap/tahunan/kantor/list', [AdminNewsFilterController::class, 'filterOfficeYearlyList'])->name('news.filter-office.yearly.list');

    /* BySumbers */
    Route::get('rekap/tahunan/sumber', [AdminNewsFilterController::class, 'filterBySumberYear'])->name('rekap.tahunan.sumber');
    Route::get('rekap/tahunan/sumber/list', [AdminNewsFilterController::class, 'filterSumberYearlyList'])->name('news.filter-sumber.yearly.list');

    /* ByYear */
    Route::get('rekap/tahunan', [AdminNewsFilterController::class, 'filterByYear'])->name('rekap.tahunan');
    Route::get('rekap/tahunan/list', [AdminNewsFilterController::class, 'filterYearlyList'])->name('news.filter-year.list');

    // AJAX ROUTER FOR UPDATE STATUS (ONLINE/OFFLINE)
    Route::get('officer-status', [NewsController::class, 'officerStatus'])->name('news.officer-status');
});





// (OPSIONAL) JIKA TETAP MENGGUNAKAN ROLE USER
Route::prefix('user')->name('user.')->middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});

// PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/profile-admin', [ProfileController::class, 'profileAdmin'])->name('profile.profile-admin');
    Route::get('/profile/profile-super-admin', [ProfileController::class, 'profileSuperAdmin'])->name('profile.profile-super-admin');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// END ROUTES





/* ===================================================================== */
/* ====== USER ROUTES (OPSIONAL JIKA TETAP MENGGUNAKAN ROLE USER) ====== */
/* ===================================================================== */

// OPSIONAL JIKA MENGGUNAKAN ROLE USER !!!
Route::get('/user/services', [PageController::class, 'layanan'])->name('user.services');
Route::get('/user/about_us', [PageController::class, 'informasi'])->name('user.about_us');
Route::get('/user/galery', [PageController::class, 'galeri'])->name('user.galery');
Route::get('/user/contact', [PageController::class, 'kontak'])->name('user.contact');

// Group routes untuk news dengan prefix 'berita'
Route::prefix('berita')->name('news.')->group(function () {

    // Halaman utama berita dengan search dan filter
    // GET /berita → user.berita.blade.php
    Route::get('/', [UserNewsController::class, 'index'])->name('index');

    // AJAX route untuk loading berita (untuk live search/infinite scroll)
    // GET /berita/ajax/load
    Route::get('/ajax/load', [UserNewsController::class, 'ajaxIndex'])->name('ajax.index');

    // Detail berita berdasarkan ID
    // GET /berita/{news} → user.berita-detail.blade.php
    Route::get('/{news}', [UserNewsController::class, 'show'])->name('show');

});

// Berita berdasarkan kategori
// GET /berita/kategori/{category} → user.berita.blade.php
Route::get('/berita/kategori/{category}', [UserNewsController::class, 'byCategory'])
    ->name('news.category')
    ->where('category', '[a-zA-Z0-9\s&\-]+');

// Berita berdasarkan tahun
// GET /berita/tahun/{year} → user.berita.blade.php
Route::get('/berita/tahun/{year}', [UserNewsController::class, 'byYear'])
    ->name('news.year')
    ->where('year', '[0-9]{4}');

// Berita berdasarkan bulan dan tahun
// GET /berita/{year}/{month} → user.berita.blade.php
Route::get('/berita/{year}/{month}', [UserNewsController::class, 'byMonth'])
    ->name('news.month')
    ->where(['year' => '[0-9]{4}', 'month' => '[0-9]{2}']);

// Route untuk mendapatkan kategori (untuk dropdown AJAX)
Route::get('/api/berita/categories', [UserNewsController::class, 'getCategories'])
    ->name('news.api.categories');

// Route untuk mendapatkan statistik berita (untuk widget)
Route::get('/api/berita/stats', [UserNewsController::class, 'getStats'])
    ->name('news.api.stats');

// Routes dengan prefix 'news' (redirect ke 'berita')
Route::prefix('news')->group(function () {

    // Redirect ke route berita Indonesia
    Route::get('/', function () {
        return redirect()->route('news.index');
    });

    Route::get('/{news}', function ($news) {
        return redirect()->route('news.show', $news);
    });

});

// Jika ingin menggunakan slug instead of ID
Route::bind('news', function ($value) {
    // Coba cari berdasarkan ID terlebih dahulu
    if (is_numeric($value)) {
        return \App\Models\News::findOrFail($value);
    }

    // Jika bukan numeric, cari berdasarkan slug (jika ada field slug)
    return \App\Models\News::where('slug', $value)->firstOrFail();
});

// Route untuk mendapatkan kategori (jika dibutuhkan untuk AJAX)
Route::get('/api/news/categories', [UserNewsController::class, 'getCategories'])->name('news.categories');

// Berita berdasarkan kategori
Route::get('/berita/kategori/{category}', [UserNewsController::class, 'index'])
    ->name('news.category');

// Berita berdasarkan tahun
Route::get('/berita/tahun/{year}', [UserNewsController::class, 'index'])
    ->name('news.year')
    ->where('year', '[0-9]{4}');

// Berita berdasarkan bulan dan tahun
Route::get('/berita/{year}/{month}', [UserNewsController::class, 'index'])
    ->name('news.month')
    ->where(['year' => '[0-9]{4}', 'month' => '[0-9]{2}']);

Route::get('/sitemap-berita.xml', function () {
    $news = \App\Models\News::orderBy('updated_at', 'desc')->get();

    return response()->view('sitemap.news', compact('news'))
        ->header('Content-Type', 'application/xml');
})->name('news.sitemap');

require __DIR__ . '/auth.php';
