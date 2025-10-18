<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
            $notifications = collect(); // empty collection
            $unreadCount = 0;

            if (Auth::guard('web')->check()) {
                $notifications = notification::where('user_type', 'user')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->take(10) // optional: limit for performance
                    ->get();

                $unreadCount = $notifications->where('is_read', 0)->count();
            } elseif (Auth::guard('vendor')->check()) {
                $notifications = notification::where('user_type', 'vendor')
                    ->where('user_id', Auth::guard('vendor')->id())
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

                $unreadCount = $notifications->where('is_read', 0)->count();
            }

            $view->with([
                'notifications' => $notifications,
                'unreadCount' => $unreadCount,
            ]);
        });
    }
}
