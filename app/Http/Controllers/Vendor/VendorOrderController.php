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

class VendorOrderController extends Controller
{
   public function index()
    {
        return view('vendors.orders.index');
    }

    public function fetchOrders()
    {
        $vendor = auth('vendor')->user();

        // Fetch all order items that belong to this vendor’s products
        $orders = OrderItem::with([
            'product.mainImage', 
            'order.user'
        ])
        ->whereHas('product', function ($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })
        ->latest()
        ->get()
        ->map(function ($item) {
            $order = $item->order;

            // Map order status to readable form
            $statusText = match ((int)$order->status) {
                0 => 'Cancelled',
                1 => 'Processing',
                2 => 'In Progress',
                3 => 'Completed',
                default => 'Unknown',
            };

            // Assign CSS class for styling
            $statusClass = match ($statusText) {
                'Cancelled' => 'status-cancelled',
                'Processing', 'In Progress' => 'status-in-progress',
                'Completed' => 'status-completed',
                default => 'status-pending',
            };

            return [
                'id' => $item->id,
                'order_no' => $order->order_no ?? 'N/A',
                'buyer' => $order->user->name ?? $order->name ?? 'Anonymous',
                'status' => $statusText,
                'status_class' => $statusClass,
                'image' => $item->product && $item->product->mainImage
                    ? asset($item->product->mainImage->image_name)
                    : asset('vendors/assets/images/default-product.png'),
                'product_name' => $item->product->product_name ?? 'Unknown Product',
                'category' => $item->product->category->category_name ?? 'Uncategorized',
                'quantity' => $item->quantity,
                'price' => number_format($item->total_price, 2),
                'created_at' => $order->created_at->format('M d, Y'),
            ];
        });

        // Calculate stats
        $total = $orders->count();
        $completed = $orders->where('status', 'Completed')->count();
        $inProgress = $orders->filter(function ($order) {
            return in_array($order['status'] ?? '', ['Processing', 'In Progress']);
        })->count();
        $cancelled = $orders->where('status', 'Cancelled')->count();

        return response()->json([
            'stats' => [
                'total' => $total,
                'completed' => $completed,
                'inprogress' => $inProgress,
                'cancelled' => $cancelled,
            ],
            'orders' => $orders
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

    // Fetch tracking history for this specific order
    $tracking = OrderTracking::where('order_id', $order->id)
        ->orderBy('created_at')
        ->get();

    return view('vendors.orders.order-details', [
        'order' => $order,
        'item' => $orderItem, // Pass only this vendor’s item
        'tracking' => $tracking,
        'fullAddress' => $fullAddress,
    ]);
}
   public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:2,3', // 2=Dispatched, 3=Completed
    ]);

    $order = Orders::with(['items.product', 'user'])->findOrFail($id);
    $vendor = Auth::guard('vendor')->user();

    $order->status = $request->status;
    $order->save();

    // Track status update
    OrderTracking::create([
        'order_id' => $order->id,
        'product_id' => $order->items()->first()->product_id ?? null,
        'status' => $request->status,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);

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
            "/orders/{$order->id}",
            $messageForUser
        );
    }

    // ✅ Notify Vendor
    notification::insertRecord(
        $vendor->id,
        'vendor',
        $titleForVendor,
        "/vendor/order/{$order->id}",
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
