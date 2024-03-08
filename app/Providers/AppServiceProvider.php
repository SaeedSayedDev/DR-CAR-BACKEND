<?php

namespace App\Providers;

use App\Models\Media;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        
        $noneImage = Media::where('type', 'none')->value('image');
        $app_logo = Media::where('type', 'logo')->value('image');

        View::share(compact('noneImage', 'app_logo'));
    }
}
