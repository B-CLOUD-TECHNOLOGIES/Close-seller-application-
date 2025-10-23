<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\notification;
use App\Models\productWishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user_id = Auth::user()->id;

        // ✅ Check if user had a product they tried to wishlist before login
        if (session()->has('intended_wishlist_product')) {
            $productId = session('intended_wishlist_product');

            // Add it to wishlist if not already there
            if (empty(productWishlist::checkAlready($productId, $user_id))) {
                productWishlist::create([
                    'user_id' => $user_id,
                    'product_id' => $productId,
                ]);
            }

            // Clear the session key
            session()->forget('intended_wishlist_product');
        }

        // ✅ Notification for login success
        $notification = [
            'message' => 'User Login Successfully',
            'alert-type' => 'success'
        ];

        // ✅ Log the login notification
        return redirect()->route('index')->with($notification);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
