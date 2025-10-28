<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use MusheAbdulHakim\Paystack\Paystack;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(Paystack::class, function ($app) {
            $secret = config('paystack.secret_key');
            return new Paystack($secret);
        });
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $notifications = collect();
            $unreadCount = 0;
            $cartCount = 0; // ✅ initialize

            if (Auth::guard('web')->check()) {
                // ✅ Notifications for users
                $notifications = notification::where('user_type', 'user')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

                $unreadCount = $notifications->where('is_read', 0)->count();

                // ✅ Cart count for users
                $cart = Cart::where('user_id', Auth::id())->first();
                $cartCount = $cart ? $cart->items()->count() : 0;
            } elseif (Auth::guard('vendor')->check()) {
                // ✅ Notifications for vendors
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
                'cartCount' => $cartCount, // ✅ make available globally
            ]);
        });
    }
}
