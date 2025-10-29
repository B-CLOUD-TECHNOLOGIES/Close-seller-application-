<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\OrderTracking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class userOrderController extends Controller
{
    //
    public function usersOrders()
    {
        return view("users.orders.index");
    }


    // public function userFetchOrders()
    // {
    //     $user = Auth::user();

    //     $orders = Orders::with([
    //         'items.product.mainImage',
    //         'items.product.category',
    //         'orderTrackings' => fn($q) => $q->latest(),
    //     ])
    //         ->where('user_id', $user->id)
    //         ->latest()
    //         ->get()
    //         ->map(function ($order) {
    //             // 🔹 Collect all tracking statuses for this order
    //             $statuses = array_values($order->orderTrackings->pluck('status')->unique()->toArray());

    //             if (empty($statuses)) {
    //                 $trackingStatus = null;
    //             } elseif (in_array(0, $statuses, true)) {
    //                 $trackingStatus = 0;
    //             } elseif (count($statuses) === 1 && $statuses[0] == 3) {
    //                 $trackingStatus = 3;
    //             } elseif (in_array(2, $statuses, true) || in_array(1, $statuses, true)) {
    //                 $trackingStatus = 2;
    //             } else {
    //                 $trackingStatus = 1;
    //             }


    //             // 🔹 Convert numeric tracking to text
    //             $statusText = match ((string)$trackingStatus) {
    //                 '0' => 'Cancelled',
    //                 '1' => 'Processing',
    //                 '2' => 'In Progress',
    //                 '3' => 'Completed',
    //                 default => 'Pending',
    //             };

    //             // 🔹 Assign class
    //             $statusClass = match ($statusText) {
    //                 'Cancelled' => 'status-cancelled',
    //                 'Processing' => 'status-processing',
    //                 'In Progress' => 'status-in-progress',
    //                 'Completed' => 'status-completed',
    //                 default => 'status-pending',
    //             };

    //             // 🔹 Other order info
    //             $totalItems = $order->items->sum('quantity');
    //             $paymentStatus = $order->is_payment ? 'paid' : 'unpaid';

    //             return [
    //                 'id' => $order->id,
    //                 'order_no' => $order->order_no ?? 'N/A',
    //                 'buyer' => $order->user->name ?? $order->name ?? 'Anonymous',
    //                 'status' => $statusText,
    //                 'status_class' => $statusClass,
    //                 'total_amount' => $order->total_amount,
    //                 'total_items' => $totalItems,
    //                 'payment_status' => $paymentStatus,
    //                 'shipping_fee' => $order->shipping_amount ?? 0,
    //                 'created_at' => $order->created_at->toDateString(),
    //             ];
    //         });

    //     // ✅ Stats
    //     $total = $orders->count();
    //     $completed = $orders->where('status', 'Completed')->count();
    //     $inProgress = $orders->where('status', 'In Progress')->count();
    //     $processing = $orders->where('status', 'Processing')->count();
    //     $cancelled = $orders->where('status', 'Cancelled')->count();

    //     return response()->json([
    //         'stats' => [
    //             'total' => $total,
    //             'completed' => $completed,
    //             'inprogress' => $inProgress,
    //             'processing' => $processing,
    //             'cancelled' => $cancelled,
    //         ],
    //         'orders' => $orders,
    //     ]);
    // }


    public function userFetchOrders()
    {
        $user = Auth::user();

        $orders = Orders::with([
            'items.product.mainImage',
            'items.product.category',
            'orderTrackings' => fn($q) => $q->latest(),
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($order) {
                // =======================================
                // 🧠 Determine Order Status from Items
                // =======================================

                // Get the latest tracking status per product in the order
                $latestStatuses = $order->orderTrackings()
                    ->select('product_id', DB::raw('MAX(id) as latest_id'))
                    ->groupBy('product_id')
                    ->pluck('latest_id')
                    ->toArray();

                $statuses = OrderTracking::whereIn('id', $latestStatuses)
                    ->pluck('status');

                // 🧩 Determine overall order status
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

                // =======================================
                // 🎨 Assign CSS class based on status
                // =======================================
                $statusClass = match ($statusText) {
                    'Cancelled' => 'status-cancelled',
                    'Processing' => 'status-processing',
                    'In Progress' => 'status-in-progress',
                    'Completed' => 'status-completed',
                    default => 'status-pending',
                };

                // =======================================
                // 💰 Compute totals and metadata
                // =======================================
                $totalItems = $order->items->sum('quantity');
                $paymentStatus = $order->is_payment ? 'paid' : 'unpaid';

                return [
                    'id' => $order->id,
                    'order_no' => $order->order_no ?? 'N/A',
                    'buyer' => $order->user->name ?? $order->name ?? 'Anonymous',
                    'status' => $statusText,
                    'status_class' => $statusClass,
                    'total_amount' => $order->total_amount,
                    'total_items' => $totalItems,
                    'payment_status' => $paymentStatus,
                    'shipping_fee' => $order->shipping_amount ?? 0,
                    'created_at' => $order->created_at->toDateString(),
                ];
            });

        // =======================================
        // 📊 Compute Stats
        // =======================================
        $total = $orders->count();
        $completed = $orders->where('status', 'Completed')->count();
        $inProgress = $orders->where('status', 'In Progress')->count();
        $processing = $orders->where('status', 'Processing')->count();
        $cancelled = $orders->where('status', 'Cancelled')->count();

        return response()->json([
            'stats' => [
                'total' => $total,
                'completed' => $completed,
                'inprogress' => $inProgress,
                'processing' => $processing,
                'cancelled' => $cancelled,
            ],
            'orders' => $orders,
        ]);
    }



    public function userOrderSummary($orderId)
    {
        $user = Auth::user();

        // ✅ Fetch the order that belongs to the logged-in user (buyer)
        $order = Orders::with([
            'items.product.mainImage',
            'items.product.category',
            'orderTrackings' => fn($q) => $q->latest(),
        ])
            ->where('user_id', $user->id) // only fetch orders made by this user
            ->where('id', $orderId) // match the requested order
            ->first();

        // ❌ Handle case where the order doesn’t belong to the logged-in user
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found or access denied.');
        }

        // ✅ Return view with order details
        return view('users.orders.order-summary', compact('order'));
    }


    public function userFetchOrderItems($orderId)
    {
        $userId = auth('web')->id(); // Assuming 'web' guard for users

        // Load the order that belongs to this user
        $order = Orders::with([
            'items.product.category',
            'items.tracking' => fn($q) => $q->latest()
        ])
            ->where('user_id', $userId)
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or access denied'
            ], 404);
        }

        // Compute stats based on tracking status
        $stats = [
            'total' => $order->items->count(),
            'completed' => $order->items->filter(fn($i) => optional($i->tracking->first())->status == 3)->count(),
            'inprogress' => $order->items->filter(fn($i) => optional($i->tracking->first())->status == 2)->count(),
            'cancelled' => $order->items->filter(fn($i) => optional($i->tracking->first())->status == 0)->count(),
        ];

        // Status mapping
        $statusMap = [
            0 => 'Cancelled',
            1 => 'Order Placed',
            2 => 'Dispatched',
            3 => 'Completed'
        ];

        // Map items for JSON response
        $items = $order->items->map(function ($item) use ($statusMap, $order) {
            $latestTracking = $item->tracking->first();
            $statusCode = $latestTracking->status ?? null;
            $statusText = $statusMap[$statusCode] ?? 'Pending';

            $product = $item->product;
            $firstImage = $product?->getFirstImage();
            $imagePath = $firstImage ? asset($firstImage->image_name) : asset('vendors/assets/img/default-product.png');

            return [
                'id' => $item->id,
                'product_name' => $product->product_name ?? 'Unnamed Product',
                'category' => $product->category->name ?? 'N/A',
                'price' => number_format($item->price, 2),
                'quantity' => $item->quantity,
                'image' => $imagePath,
                'vendor' => $product->vendor->name ?? 'Unknown Vendor',
                'order_no' => $order->order_no,
                'status' => $statusText,
                'status_class' => strtolower(str_replace(' ', '-', $statusText)),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'orders' => $items,
        ]);
    }



    public function userShowOrderItem($orderItemId)
    {
        $user = Auth::guard('web')->user(); // Logged-in user (customer)

        // Fetch the order item with its order, product, and tracking info
        $orderItem = OrderItem::with([
            'order.orderTrackings' => fn($q) => $q->latest(),
            'product.category'
        ])
            ->whereHas('order', fn($q) => $q->where('user_id', $user->id)) // Ensure the order belongs to the user
            ->findOrFail($orderItemId);

        $order = $orderItem->order;

        // Combine address parts into a full readable address
        $fullAddress = trim(implode(', ', array_filter([
            $order->address,
            $order->city ?? null,
            $order->state ?? null,
            $order->country ?? null,
        ])));

        // Fetch tracking history for this specific product in that order
        $tracking = OrderTracking::where('order_id', $order->id)
            ->where('product_id', $orderItem->product_id)
            ->orderBy('created_at')
            ->get();


        // Get the latest tracking entry (for current status)
        $latestTracking = $tracking->last();
        if ($latestTracking) {
            $order->status = $latestTracking->status;
        }

        // Return the view with data
        return view('users.orders.order-item-details', [
            'order' => $order,
            'item' => $orderItem,
            'tracking' => $tracking,
            'fullAddress' => $fullAddress,
        ]);
    }
}
