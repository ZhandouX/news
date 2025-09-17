<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    
    public function boot(): void
    {
        Paginator::useBootstrapFive(); 
        // SETUP LOCAL DATE (ID)
        Carbon::setLocale('id');
        App::setLocale('id');
    }
}
