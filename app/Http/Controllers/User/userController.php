<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\products;
use App\Models\productWishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class userController extends Controller
{
    public function UserDashboard()
    {
        return view("users.profile");
    }


    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Successfully Logged out',
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);
    }


    public function getUserProductWishlist()
    {
        $data['products'] = productWishlist::getUserProductWishlist();
        $data['pageName'] = "My Wishlist";
        Log::info('products: ' . $data['products']);

        return view('frontend.wishlist', $data);
    }


    public function deleteWishlist($id)
    {
        $deleteMyWishList = productWishlist::deleteRecord($id, Auth::user()->id);
        $data['products'] = productWishlist::getUserProductWishlist();
        $data['pageName'] = "My Wishlist";
        $notification = array(
            'message' => 'Product Succesfully removed',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function WuishListStatus()
    {
        if (!Auth::check()) {
            return response()->json(['wishlist' => []]);
        }

        $wishlistProductIds = productWishlist::where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return response()->json(['wishlist' => $wishlistProductIds]);
    }
}
