<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders;
use App\Models\OrderItem;
use App\Models\products;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class VendorDashboardController extends Controller
{
    /**
     * Display the vendor dashboard.
     */
   public function index()
{
    $vendor = Auth::guard('vendor')->user();

   $recentOrders = OrderItem::with([
        'product.mainImage',
        'order.user',
        'order.orderTrackings' => fn($q) => $q->latest(),
    ])
    ->whereHas('product', fn($q) => $q->where('vendor_id', $vendor->id))
    ->latest()
    ->get() // remove ->take(5)
    ->groupBy('order_id')
    ->map(function ($items) {
        $firstItem = $items->first();
        $order = $firstItem->order;

        $latestStatuses = $order->orderTrackings()
            ->select('product_id', DB::raw('MAX(id) as latest_id'))
            ->groupBy('product_id')
            ->pluck('latest_id')
            ->toArray();

        $statuses = \App\Models\OrderTracking::whereIn('id', $latestStatuses)
            ->pluck('status');

        if ($order->status == 0) {
            $statusText = 'Cancelled';
        } elseif ($statuses->isEmpty()) {
            $statusText = 'Pending';
        } elseif ($statuses->every(fn($s) => $s == 3)) {
            $statusText = 'Completed';
        } elseif ($statuses->contains(2)) {
            $statusText = 'In Progress';
        } elseif ($statuses->contains(1)) {
            $statusText = 'Processing';
        } else {
            $statusText = 'Pending';
        }

        $statusClass = match ($statusText) {
            'Cancelled' => 'bg-danger',
            'Processing' => 'bg-warning',
            'In Progress' => 'bg-primary',
            'Completed' => 'bg-success',
            default => 'bg-secondary',
        };

        return (object) [
            'id' => $order->id,
            'order_no' => $order->order_no ?? '#ORD-' . $order->id,
            'user' => $order->user,
            'status' => $statusText,
            'status_class' => $statusClass,
            'total_amount' => $order->total_amount,
        ];
    })
    ->values()
    ->take(5);

    // 🔹 Fetch vendor’s products with first image and monthly sales
    $vendorProducts = products::where('vendor_id', $vendor->id)
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($product) {
            $product->mainImage = $product->getFirstImage();
            $product->sales_count = OrderItem::where('product_id', $product->id)
                ->whereHas('order', fn($q) => $q->whereMonth('created_at', now()->month))
                ->sum('quantity');
            return $product;
        });

    return view('vendors.dashboard', compact('recentOrders', 'vendorProducts', 'vendor'));
}

    /**
     * Return live dashboard data for AJAX polling.
     */
    public function fetchDashboardData()
{
    $vendor = Auth::guard('vendor')->user();

    // 🧾 Total revenue (sum of vendor-related order items)
    $totalRevenue = OrderItem::whereHas('product', fn($q) => $q->where('vendor_id', $vendor->id))
        ->whereHas('order', fn($q) => $q->where('is_payment', true))
        ->sum('total_price'); // assuming your OrderItem table has an 'amount' column

    // 🟡 Pending orders count
    $pendingOrders = Orders::whereHas('items.product', fn($q) => $q->where('vendor_id', $vendor->id))
        ->whereIn('status', [1, 2]) // 1=Processing, 2=In progress
        ->count();

    $totalProducts = products::where('vendor_id', $vendor->id)
    ->where('status', 1)       // Only active products
    ->where('isdelete', 0)     // Exclude deleted ones
    ->count();

   // 📩 Messages (notifications)
    $unreadMessages = Notification::where('user_id', $vendor->id)
        ->where('user_type', 'vendor')
        ->where('is_read', 0)
        ->count();
    return response()->json([
        'success' => true,
        'data' => [
            'totalRevenue' => number_format($totalRevenue, 2),
            'pendingOrders' => $pendingOrders,
            'totalProducts' => $totalProducts,
            'unreadMessages' => $unreadMessages,
        ]
    ]);
}
}
