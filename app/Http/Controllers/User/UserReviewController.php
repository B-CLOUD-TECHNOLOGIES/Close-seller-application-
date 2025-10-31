<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\notification;
use App\Models\Orders;
use App\Models\productReviews;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserReviewController extends Controller
{
    //

    public function userReviews()
    {
        return view("users.reviews.index");
    }


    public function userFetchReviews()
    {
        $user = Auth::user();

        // Step 1: Get all product IDs from successful orders only
        $orderedProductIds = Orders::where('user_id', $user->id)
            ->where('is_payment', 1) // ✅ Only paid orders
            ->where('status', 3)     // ✅ Only delivered or completed orders
            ->with('items')
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product_id')
            ->unique()
            ->values();


        // Step 2: Get all product IDs the user has reviewed
        $reviewedProductIds = productReviews::where('user_id', $user->id)
            ->pluck('product_id')
            ->unique()
            ->values();

        // Step 3: Fetch all ordered products (with main image + category)
        $products = products::with(['mainImage', 'Category'])
            ->whereIn('id', $orderedProductIds)
            ->get();

        // Step 4: Fetch all reviews keyed by product_id
        $reviews = productReviews::where('user_id', $user->id)
            ->with('product')
            ->get()
            ->keyBy('product_id');

        // Step 5: Combine data — mark each product as reviewed or pending
        $data = $products->map(function ($product) use ($reviews) {
            $review = $reviews->get($product->id);

            return [
                'product_id' => $product->id,
                'product_name' => $product->product_name ?? '',
                'image' => asset($product->mainImage->image) ?? asset("uploads/no_image.jpg"),
                'category' => $product->Category->name ?? 'Uncategorized',
                'is_reviewed' => (bool) $review,
                'rating' => $review->rating ?? null,
                'review_text' => $review->review ?? null,
                'review_date' => $review ? optional($review->created_at)->format('M d, Y') : null
            ];
        });

        Log::info("Naea oo: " . $data);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function SubmitReviews(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // Get the successful order (not just a boolean)
        $order = Orders::where('user_id', $user->id)
            ->where('is_payment', 1)
            ->where('status', 3)
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
            ->latest()
            ->first(); // ✅ fetch the latest matching order

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only review products you have successfully purchased.',
            ], 403);
        }



        // Save or update the review
        $review = productReviews::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ],
            [
                'order_id' => $order->id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        $product = products::find($request->product_id);
        if ($product->product_owner === "Vendor") {
            // ✅ Notify the vendor
            notification::insertRecord(
                $product->vendor_id,
                'vendor',
                'New Product Review',
                url("/vendors/reviews"),
                'A customer has submitted a review for your product: ' . $product->product_name,
                false // not admin
            );
        } else {
            // ✅ Notify the admin
            notification::insertRecord(
                null,
                'admin',
                'New Product Review',
                url("/admin/reviews/"),
                'A customer has submitted a review for the product: ' . $product->product_name,
                true // is admin
            );
        }



        return response()->json([
            'status' => 'success',
            'message' => 'Review submitted successfully!',
            'review' => $review,
        ]);
    }
}
