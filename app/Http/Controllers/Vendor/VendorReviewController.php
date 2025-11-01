<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\productReviews;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VendorReviewController extends Controller
{
    public function index()
    {
        return view('vendors.review');
    }

    public function fetchReviews()
    {
        $vendor = auth('vendor')->user();

        $reviews = productReviews::with([
            'product.mainImage',
            'user'
        ])
        ->whereHas('product', function ($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })
        ->latest()
        ->get()
        ->map(function ($review) {
            return [
                'id' => $review->id,
                'product' => $review->product->product_name ?? 'Unknown Product', 
                'customer' => $review->user->username ?? 'Anonymous',
                'date' => $review->created_at->format('M j, Y'),
                'stars' => $review->rating,
                'text' => $review->review,
                'image' => $review->product && $review->product->mainImage
                ? (Str::contains($review->product->mainImage->image_name, 'uploads/products')
                    ? asset($review->product->mainImage->image_name)
                    : asset('uploads/products/' . $review->product->mainImage->image_name))
                : asset('vendors/assets/images/default-product.png'),
            ];
        });

        $averageRating = round($reviews->avg('stars'), 1);
        $totalReviews = $reviews->count();
        $positivePercent = $totalReviews > 0
            ? round(($reviews->where('stars', '>=', 4)->count() / $totalReviews) * 100)
            : 0;

        return response()->json([
            'stats' => [
                'average' => $averageRating,
                'total' => $totalReviews,
                'positive' => $positivePercent
            ],
            'reviews' => $reviews
        ]);
    }
}