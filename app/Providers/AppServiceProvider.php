<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
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
        View::composer('layouts.frontend.app', function ($view) {
            $categories = Category::orderBy('created_at', 'asc')->get();
            $view->with('categories', $categories);
        });
        URL::forceScheme('https');
    }
}
