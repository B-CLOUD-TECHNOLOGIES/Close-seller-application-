<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\products;
use App\Models\productWishlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class userController extends Controller
{
    public function userUpdateProfile(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'username'  => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'gender'    => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // ✅ Get the authenticated user model (not just ID)
            $user_id = Auth::user()->id;

            $user = User::find($user_id);

            // ✅ Update basic info
            $user->username  = $request->username;
            $user->firstname = $request->firstname;
            $user->lastname  = $request->lastname;
            $user->phone     = $request->phone;
            $user->gender    = $request->gender;

            Log::info("User updating profile: " . $user->id);

            // ✅ Handle image upload if provided
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/users'), $imageName);
                $user->image = 'uploads/users/' . $imageName;
            }

            $user->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Profile updated successfully',
                'user'    => $user,
            ]);
        } catch (\Exception $e) {
            Log::error('User update error', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function editUserProfile()
    {
        return view('users.profile.edit-profile');
    }


    public function UserDashboard()
    {
        return view("users.dashboard");
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
