<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class userOrderController extends Controller
{
    //
    public function usersOrders()
    {
        return view("users.orders.index");
    }


    public function userFetchOrders()
    {
        $user = Auth::user();

        // ✅ Fetch all orders made by the logged-in user
        $orders = Orders::with([
            'items.product.mainImage',
            'items.product.category',
            'orderTrackings' => fn($q) => $q->latest(),
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($order) {
                // Get latest tracking
                $latestTracking = $order->orderTrackings->first();
                $trackingStatus = $latestTracking ? $latestTracking->status : null;

                // Map tracking status to readable format
                $statusText = match ((string)$trackingStatus) {
                    '0', 'cancelled', 'Canceled', 'Cancelled' => 'Cancelled',
                    '1', 'placed', 'Placed', 'processing', 'Processing' => 'Processing',
                    '2', 'dispatched', 'in_progress', 'In Progress' => 'In Progress',
                    '3', 'completed', 'Completed' => 'Completed',
                    default => 'Pending',
                };

                // Assign CSS class for frontend styling
                $statusClass = match ($statusText) {
                    'Cancelled' => 'status-cancelled',
                    'Processing' => 'status-processing',
                    'In Progress' => 'status-in-progress',
                    'Completed' => 'status-completed',
                    default => 'status-pending',
                };

                // Calculate order totals
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

        // ✅ Stats
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
}
