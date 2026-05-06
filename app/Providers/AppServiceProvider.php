<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use App\Observers\UserObserver;
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
        Paginator::useBootstrap();
        View::composer(['layouts.frontend.app', 'layouts.user.app'], function ($view) {

            $categories = Category::where('status', 'show')
                ->orderBy('created_at', 'asc')
                ->get();

            $amenities = Amenity::orderBy('created_at', 'asc')->get();

            $notifications = collect();
            $unreadCount = 0;

            if (Auth::check()) {
                $notifications = Auth::user()
                    ->notifications()
                    ->latest()
                    ->take(10)
                    ->get();

                $unreadCount = Auth::user()
                    ->unreadNotifications()
                    ->count();
            }

            $view->with([
                'categories' => $categories,
                'headerNotifications' => $notifications,
                'headerNotificationCount' => $unreadCount,
                'amenities' => $amenities,
            ]);
        });
        // URL::forceScheme('https');
        User::observe(UserObserver::class);
    }
}
