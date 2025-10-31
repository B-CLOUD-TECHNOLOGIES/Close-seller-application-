<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderTracking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\notification;
use Illuminate\Support\Facades\DB;

class VendorOrderController extends Controller
{
    public function index()
    {
        return view('vendors.orders.order-index');
    }
    public function orderIndex()
    {
        return view('vendors.orders.order-index');
    }

    //    public function fetchOrders()
    // {
    //     $vendor = auth('vendor')->user();

    //     // Fetch all order items that belong to this vendor’s products
    //     $orders = OrderItem::with([
    //         'product.mainImage',
    //         'order.user'
    //     ])
    //     ->whereHas('product', function ($q) use ($vendor) {
    //         $q->where('vendor_id', $vendor->id);
    //     })
    //     ->latest()
    //     ->get()
    //     ->map(function ($item) {
    //         $order = $item->order;

    //         // ✅ Fetch the most recent tracking status for this order
    //         $latestTracking = OrderTracking::where('order_id', $order->id)
    //             ->orderByDesc('created_at')
    //             ->first();

    //         // If tracking exists, use that status, otherwise fallback to order->status
    //         $statusCode = $latestTracking->status ?? $order->status;

    //         // Map numeric status to readable text
    //         $statusText = match ((int)$statusCode) {
    //             0 => 'Cancelled',
    //             1 => 'Processing',
    //             2 => 'Dispatched',
    //             3 => 'Delivered',
    //             default => 'Pending',
    //         };

    //         // Assign CSS class for styling
    //         $statusClass = match ($statusText) {
    //             'Cancelled' => 'status-cancelled',
    //             'Processing', 'Dispatched' => 'status-in-progress',
    //             'Delivered' => 'status-completed',
    //             default => 'status-pending',
    //         };

    //         return [
    //             'id' => $item->id,
    //             'order_no' => $order->order_no ?? 'N/A',
    //             'buyer' => $order->user->name ?? $order->name ?? 'Anonymous',
    //             'status' => $statusText,
    //             'status_class' => $statusClass,
    //             'image' => $item->product && $item->product->mainImage
    //                 ? asset($item->product->mainImage->image_name)
    //                 : asset('vendors/assets/images/default-product.png'),
    //             'product_name' => $item->product->product_name ?? 'Unknown Product',
    //             'category' => $item->product->category->category_name ?? 'Uncategorized',
    //             'quantity' => $item->quantity,
    //             'price' => number_format($item->total_price, 2),
    //             'created_at' => $order->created_at->format('M d, Y'),
    //         ];
    //     });

    //     // ✅ Calculate summary stats
    //     $total = $orders->count();
    //     $completed = $orders->where('status', 'Delivered')->count();
    //     $inProgress = $orders->filter(function ($order) {
    //         return in_array($order['status'], ['Processing', 'Dispatched']);
    //     })->count();
    //     $cancelled = $orders->where('status', 'Cancelled')->count();

    //     return response()->json([
    //         'stats' => [
    //             'total' => $total,
    //             'completed' => $completed,
    //             'inprogress' => $inProgress,
    //             'cancelled' => $cancelled,
    //         ],
    //         'orders' => $orders
    //     ]);
    // }
    public function fetchOrders()
    {
        $vendor = auth('vendor')->user();

        $orders = OrderItem::with([
            'product.mainImage',
            'product.category',
            'order.user',
            'order.orderTrackings' => fn($q) => $q->latest(),
        ])
            ->whereHas('product', fn($q) => $q->where('vendor_id', $vendor->id))
            ->latest()
            ->get()
            ->groupBy('order_id')
            ->map(function ($items, $orderId) {
                $firstItem = $items->first();
                $order = $firstItem->order;

                // =======================================
                // 🧠 Determine Order Status from Items
                // =======================================

                // Collect the *latest tracking status* for each product in the order
                $latestStatuses = $order->orderTrackings()
                    ->select('product_id', DB::raw('MAX(id) as latest_id'))
                    ->groupBy('product_id')
                    ->pluck('latest_id')
                    ->toArray();

                $statuses = OrderTracking::whereIn('id', $latestStatuses)
                    ->pluck('status');

                // 🧩 Decide overall order status
                if ($order->status == 0) {
                    // Cancelled (unsuccessful payment)
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
                $totalItems = $items->sum('quantity');
                $isPaid = (bool) $order->is_payment;
                $paymentStatus = $isPaid ? 'paid' : 'unpaid';

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
            })->values();

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

    public function orderSummary($orderId)
    {
        $vendor = auth('vendor')->user();

        // Find the order that includes items belonging to this vendor
        $order = Orders::with([
            'items.product',
            'user',
            'orderTrackings' => function ($q) {
                $q->latest();
            }
        ])
            ->whereHas('items.product', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id);
            })
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found or access denied.');
        }

        return view('vendors.orders.order-summary', compact('order'));
    }

    public function fetchOrderItems($orderId)
    {
        $vendorId = auth('vendor')->id();

        // Load order with only items that belong to this vendor
        $order = Orders::with([
            'items.product.category',
            'items.tracking' => function ($q) {
                $q->latest();
            }
        ])
            ->whereHas('items.product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found or access denied'], 404);
        }

        // Filter items belonging to the vendor
        $filteredItems = $order->items->filter(fn($i) => $i->product && $i->product->vendor_id == $vendorId);

        // Compute stats based on tracking status
        $stats = [
            'total' => $filteredItems->count(),
            'completed' => $filteredItems->filter(fn($i) => optional($i->tracking->first())->status == 3)->count(),
            'inprogress' => $filteredItems->filter(fn($i) => optional($i->tracking->first())->status == 2)->count(),
            'cancelled' => $filteredItems->filter(fn($i) => optional($i->tracking->first())->status == 0)->count(),
        ];

        // Status code mapping
        $statusMap = [
            0 => 'Cancelled',
            1 => 'Order Placed',
            2 => 'Dispatched',
            3 => 'Completed'
        ];

        // Map items with readable data
        $items = $filteredItems->map(function ($item) use ($statusMap) {
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
                'buyer' => $item->order->name ?? 'Unknown Buyer',
                'order_no' => $item->order->order_no ?? '',
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


    public function show($id)
    {
        $vendor = Auth::guard('vendor')->user();

        // Fetch the single order item that belongs to this vendor
        $orderItem = OrderItem::with(['order.user', 'product'])
            ->whereHas('product', function ($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })
            ->findOrFail($id);

        $order = $orderItem->order;

        // Combine address parts
        $fullAddress = trim(implode(', ', array_filter([
            $order->address,
            $order->city ?? null,
            $order->state ?? null,
            $order->country ?? null,
        ])));

        // Fetch tracking history (for timeline)
        $tracking = OrderTracking::where('order_id', $order->id)
            ->where('product_id', $orderItem->product_id)
            ->orderBy('created_at')
            ->get();

        // ✅ Get latest tracking status (if any)
        $latestTracking = OrderTracking::where('order_id', $order->id)
            ->where('product_id', $orderItem->product_id)
            ->latest('created_at')
            ->first();

        // ✅ If tracking exists, override order->status
        if ($latestTracking) {
            $order->status = $latestTracking->status;
        }

        return view('vendors.orders.order-details', [
            'order' => $order,
            'item' => $orderItem,
            'tracking' => $tracking,
            'fullAddress' => $fullAddress,
        ]);
    }

    public function updateItemStatus(Request $request, $id)
    {
        $vendor = Auth::guard('vendor')->user();

        $orderItem = OrderItem::with(['order', 'product'])
            ->whereHas('product', fn($q) => $q->where('vendor_id', $vendor->id))
            ->findOrFail($id);

        $order = $orderItem->order; // ✅ define $order before using it

        // Record new tracking entry for this specific item
        OrderTracking::create([
            'order_id' => $orderItem->order_id,
            'product_id' => $orderItem->product_id,
            'status' => $request->status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Optionally update the order’s overall status if all items are completed
        $allStatuses = OrderTracking::where('order_id', $orderItem->order_id)
            ->pluck('status');

        if ($allStatuses->every(fn($s) => $s == 3)) {
            $order->update(['status' => 3]);
        }

        // ===================================
        // 🔔 SEND NOTIFICATIONS
        // ===================================
        $statusText = $request->status == 2 ? 'Dispatched' : 'Delivered';
        $titleForUser = "Order #{$order->order_no} {$statusText}";
        $titleForVendor = "You {$statusText} an Order #{$order->order_no}";

        $messageForUser = $request->status == 2
            ? "Your order #{$order->order_no} has been dispatched and is on its way."
            : "Your order #{$order->order_no} has been delivered successfully.";

        $messageForVendor = $request->status == 2
            ? "You have dispatched order #{$order->order_no} to the buyer."
            : "You have completed delivery for order #{$order->order_no}.";

        // ✅ Notify Buyer
        if ($order->user) {
            notification::insertRecord(
                $order->user->id,
                'user',
                $titleForUser,
                url('users/order/summary/' . $order->id),
                $messageForUser
            );
        }

        // ✅ Notify Vendor
        notification::insertRecord(
            $vendor->id,
            'vendor',
            $titleForVendor,
            url("vendors/order-summary/{$order->id}"),
            $messageForVendor
        );

        return response()->json([
            'success' => true,
            'message' => $request->status == 2
                ? 'Order dispatched successfully and notifications sent.'
                : 'Order delivered successfully and notifications sent.',
        ]);
    }
}
