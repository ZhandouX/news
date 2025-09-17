<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class UserNewsController extends Controller
{
    // INDEX
    public function index(Request $request)
    {
        $query = News::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }
        
        // Year filter
        if ($request->filled('year')) {
            $query->whereYear('news_date', $request->input('year'));
        }
        
        // Month filter
        if ($request->filled('month')) {
            $query->whereMonth('news_date', $request->input('month'));
        }
        
        // Order by news date (newest first)
        $query->orderBy('news_date', 'desc')
              ->orderBy('created_at', 'desc');
        
        // Paginate results
        $news = $query->paginate(12)->withQueryString();
        
        // Return view with correct path: resources/views/user/berita.blade.php
        return view('user.berita', compact('news'));
    }
    
    // SHOW
    public function show(News $news)
    {
        // Get related news (same category, excluding current news)
        $relatedNews = News::where('category', $news->category)
                          ->where('id', '!=', $news->id)
                          ->orderBy('news_date', 'desc')
                          ->limit(4)
                          ->get();
        
        // Get latest news for sidebar
        $latestNews = News::orderBy('news_date', 'desc')
                         ->where('id', '!=', $news->id)
                         ->limit(5)
                         ->get();
        
        // Return view for news detail: resources/views/user/berita-detail.blade.php
        return view('user.detail-berita', compact('news', 'relatedNews', 'latestNews'));
    }
    
    // AJAX INDEX
    public function ajaxIndex(Request $request)
    {
        $query = News::query();
        
        // Apply same filters as index method
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }
        
        if ($request->filled('year')) {
            $query->whereYear('news_date', $request->input('year'));
        }
        
        if ($request->filled('month')) {
            $query->whereMonth('news_date', $request->input('month'));
        }
        
        $news = $query->orderBy('news_date', 'desc')
                     ->orderBy('created_at', 'desc')
                     ->paginate(12)
                     ->withQueryString();
        
        return response()->json([
            'success' => true,
            'data' => $news,
            'html' => view('layouts.partials_user.card-news', compact('news'))->render()
        ]);
    }
    
    // CATEGORY FILTER
    public function byCategory(Request $request, $category)
    {
        // Set category in request for reuse of index logic
        $request->merge(['category' => $category]);
        
        // Reuse index method logic
        return $this->index($request);
    }
    
    //FILTER YEAR
    public function byYear(Request $request, $year)
    {
        // Set year in request for reuse of index logic
        $request->merge(['year' => $year]);
        
        // Reuse index method logic
        return $this->index($request);
    }
    
    // FILTER MONTH
    public function byMonth(Request $request, $year, $month)
    {
        // Set year and month in request for reuse of index logic
        $request->merge(['year' => $year, 'month' => $month]);
        
        // Reuse index method logic
        return $this->index($request);
    }
    
    // CATEGORY DROPDOWN
    public function getCategories()
    {
        $categories = [
            'Politik',
            'Ekonomi & Bisnis',
            'Hukum & Kriminal',
            'Olahraga',
            'Teknologi',
            'Hiburan',
            'Pendidikan',
            'Kesehatan',
            'Lingkungan',
            'Internasional',
            'Gaya Hidup',
            'Opini & Editorial'
        ];
        
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
    
    // STATS FOR DASHBOARD WIDGET
    public function getStats()
    {
        $stats = [
            'total' => News::count(),
            'this_month' => News::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count(),
            'popular_category' => News::select('category')
                                     ->groupBy('category')
                                     ->orderByRaw('COUNT(*) DESC')
                                     ->first(),
            'latest_date' => News::latest('news_date')->value('news_date')
        ];
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}