<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Color;
use App\Models\Location;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\products;
use App\Models\productSizes;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Example;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size_id' => 'nullable|exists:product_sizes,id',
            'color_id' => 'nullable|exists:colors,id',
        ]);

        // Check authentication
        if (!Auth::guard('web')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login first to add items to your cart.'
            ], 401);
        }

        $user_id = Auth::id();
        $cart = Cart::firstOrCreate(['user_id' => $user_id]);

        // Get the product and base price
        $product = products::findOrFail($request->product_id);
        $totalPrice = $product->new_price ?? 0;

        // Handle size pricing
        $attributes = [];
        if (!empty($request->size_id)) {
            $size = productSizes::find($request->size_id);
            $sizePrice = $size ? ($size->price ?? 0) : 0;
            $totalPrice += $sizePrice;
        }

        // Handle color if provided
        if (!empty($request->color_id)) {
            $color = Color::find($request->color_id);
        }

        // Add or update item using your helper function

        $cartItem = $cart->addItem(
            $request->product_id,
            $request->quantity,
            $totalPrice,
            [
                'size_id' => $request->size_id,
                'size_name' => $size->name ?? null,
                'color_id' => $request->color_id,
                'color_name' => $color->color ?? null,
            ]
        );


        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully.',
            'data' => [
                'cart_item' => $cartItem,
                'cart_total' => $cart->items()->sum(DB::raw('quantity * price'))
            ]
        ]);
    }


    public function cartCountUpdate()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $cartCount = $cart ? $cart->items()->count() : 0;
        } else {
            $cartCount = 0;
        }

        return response()->json(['count' => $cartCount]);
    }


    public function viewCart()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with(['items.product'])
            ->first();

        if (!$cart) {
            return view('frontend.cart', ['itemsWithProducts' => collect()]);
        }

        $cartItems = $cart->items;

        $data['itemsWithProducts'] = $cartItems->map(function ($item) {
            $product = $item->product;

            if (!$product) {
                return null; // skip invalid cart items
            }

            // Get updated product price
            $basePrice = $product->new_price ?? 0;

            // Decode attributes from JSON
            $attributes = is_array($item->attributes) ? $item->attributes : json_decode($item->attributes, true) ?? [];


            $sizePrice = 0;
            $sizeName = null;

            // ✅ Fetch latest size price if exists
            if (!empty($attributes['size_id'])) {
                $size = productSizes::find($attributes['size_id']);
                if ($size) {
                    $sizePrice = $size->price ?? 0;
                    $sizeName = $size->name ?? null;
                }
            }

            // ✅ Recalculate total price based on updated values
            $unitPrice = $basePrice + $sizePrice;
            $totalPrice = $unitPrice * $item->quantity;

            // ✅ Get image
            $image = $product->getFirstImage();

            return [
                'cart_item_id' => $item->id,
                'quantity' => $item->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'category_id' => $product->category_id,
                'stock_quantity' => $product->stock_quantity,
                'size_name' => $sizeName,
                'product_image' => $image ? asset($image->image_name) : asset('uploads/no_image.jpg'),
            ];
        })->filter(); // removes nulls if any invalid product

        $data['cartCount'] = $data['itemsWithProducts']->count();

        return view('frontend.cart', $data);
    }



    // CartController.php
    public function removeItem(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);

        $cartItem = CartItem::find($request->cart_item_id);

        if ($cartItem && $cartItem->cart->user_id === Auth::id()) {
            $cartItem->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Item removed from your cart successfully.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized or invalid item.'
        ], 403);
    }


    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user_id = Auth::id();
        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->whereHas('cart', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found or unauthorized.'
            ], 404);
        }

        // ✅ Check product stock before updating
        $product = $cartItem->product;
        if ($product && $request->quantity > $product->stock_quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Requested quantity exceeds available stock.'
            ], 400);
        }

        // ✅ Get updated price (base + size price if applicable)
        $attributes = is_array($cartItem->attributes)
            ? $cartItem->attributes
            : json_decode($cartItem->attributes, true);

        $basePrice = $product->new_price ?? 0;
        $sizePrice = 0;

        if (!empty($attributes['size_id'])) {
            $size = productSizes::find($attributes['size_id']);
            $sizePrice = $size ? ($size->price ?? 0) : 0;
        }

        $unitPrice = $basePrice + $sizePrice;

        // ✅ Update quantity and price
        $cartItem->update([
            'quantity' => $request->quantity,
            'price' => $unitPrice,
        ]);

        // ✅ Return new totals
        $cart = $cartItem->cart;
        $cartTotal = $cart->items()->sum(DB::raw('quantity * price'));

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated successfully.',
            'data' => [
                'cart_item_id' => $cartItem->id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $unitPrice,
                'item_total' => $cartItem->quantity * $unitPrice,
                'cart_total' => $cartTotal,
            ]
        ]);
    }


    public function Checkout()
    {

        $states = Location::orderBy('name', 'ASC')->get();

        $user = Auth::user();

        $name = $user ? $user->username : '';

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to proceed to checkout.');
        }

        $getAddress = ShippingAddress::where('user_id', $user->id)->first();


        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        // ✅ Calculate subtotal
        $subtotal = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            if (!$product) continue;

            $attributes = is_array($item->attributes)
                ? $item->attributes
                : json_decode($item->attributes, true);

            $basePrice = $product->new_price ?? 0;
            $sizePrice = 0;

            if (!empty($attributes['size_id'])) {
                $size = productSizes::find($attributes['size_id']);
                $sizePrice = $size ? ($size->price ?? 0) : 0;
            }

            $unitPrice = $basePrice + $sizePrice;
            $subtotal += $unitPrice * $item->quantity;
        }

        // ✅ Calculate 3% charge
        $charge = $subtotal * (3 / 100);
        $extra = 0;

        // Cap at ₦3500
        if ($charge >= 3500) {
            $charge = 3500;
        }

        // Add ₦100 if subtotal > ₦2500
        if ($subtotal > 2500) {
            $charge += 100;
            $extra = 100;
        }

        // ✅ Calculate final total
        $total = $subtotal + $charge;

        // ✅ Store session data (for verification/payment)
        session([
            'checkout_subtotal' => $subtotal,
            'checkout_charge' => $charge,
            'checkout_extra' => $extra,
            'checkout_total' => $total,
        ]);


        // ✅ Return to checkout page
        return view('frontend.checkout', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'charge' => $charge,
            'extra' => $extra,
            'total' => $total,
            'states' => $states,
            'name' => $name,
            'getAddress' => $getAddress,
        ]);
    }


    public function placeOrder(Request $request)
    {
        try {
            Log::info('🛒 Checkout process started', [
                'user_id' => Auth::id(),
                'payload' => $request->all()
            ]);

            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'state' => 'required',
                'country' => 'required',
                'payment' => 'required',
                'subtotal' => 'required',
            ]);

            if ($request->payment !== 'paystack') {
                Log::warning('❌ Invalid payment method attempt', [
                    'user_id' => Auth::id(),
                    'payment' => $request->payment
                ]);

                return back()->with([
                    'message' => "This payment method is currently unavailable.",
                    'alert-type' => 'error'
                ]);
            }

            $sessionTotal = session()->get('checkout_subtotal');
            if (!$sessionTotal) {
                Log::warning('⚠️ Session total missing', [
                    'user_id' => Auth::id()
                ]);

                return back()->with([
                    'message' => 'Checkout session expired. Please refresh your cart and try again.',
                    'alert-type' => 'error'
                ]);
            }

            $postedTotal = (float) str_replace(',', '', $request->subtotal);
            $serverTotal = (float) $sessionTotal;

            if (round($postedTotal, 2) !== round($serverTotal, 2)) {
                Log::error('🚨 Total mismatch detected', [
                    'user_id' => Auth::id(),
                    'posted_total' => $postedTotal,
                    'server_total' => $serverTotal
                ]);

                return back()->with([
                    'message' => "Total mismatch detected. You can’t trick the system 😉",
                    'alert-type' => 'error'
                ]);
            }

            $user = Auth::user();

            try {
                ShippingAddress::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                    ]
                );
            } catch (\Throwable $e) {
                Log::error('❌ Shipping address save failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);

                return back()->with([
                    'message' => 'Failed to save shipping address. Please try again.',
                    'alert-type' => 'error'
                ]);
            }

            DB::beginTransaction();

            try {
                $orderNo = 'ORD-' . strtoupper(Str::random(8));
                $order = Orders::create([
                    'order_no' => $orderNo,
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'state' => $request->state,
                    'city' => $request->city,
                    'country' => $request->country,
                    'total_amount' => number_format($serverTotal, 2, '.', ''),
                    'payment_method' => $request->payment,
                    'status' => 1,
                    'is_payment' => 0,
                ]);

                Log::info('🧾 Order created successfully', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'user_id' => $user->id
                ]);

                $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

                if (!$cart || $cart->items->isEmpty()) {
                    Log::warning('🛒 Cart empty at order placement', ['user_id' => $user->id]);
                    throw new \Exception('Cart is empty');
                }

                foreach ($cart->items as $cartItem) {
                    try {
                        $sizes = productSizes::find($cartItem->attributes['size_id']);

                        OrderItem::create([
                            'order_id' => $order->id,
                            'cart_id' => $cart->id,
                            'product_id' => $cartItem->product_id,
                            'quantity' => $cartItem->quantity,
                            'price' => $cartItem->price,
                            'color_name' => $cartItem->attributes['color_name'] ?? '',
                            'size_name' => $cartItem->attributes['size_name'] ?? '',
                            'size_amount' => $sizes->price ?? 0,
                            'total_price' => (int)$cartItem->price * (int)$cartItem->quantity,
                        ]);
                    } catch (\Throwable $e) {
                        Log::error('❌ Failed to add order item', [
                            'order_id' => $order->id,
                            'product_id' => $cartItem->product_id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                DB::commit();

                Log::info('✅ Order placed successfully, redirecting to Paystack', [
                    'order_id' => $order->id,
                    'user_id' => $user->id
                ]);

                return redirect()->route('security.check', ['order_id' => base64_encode($order->id)]);
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('❌ Order placement failed during transaction', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);

                return back()->with([
                    'message' => 'An error occurred while placing your order. Please try again.',
                    'alert-type' => 'error'
                ]);
            }
        } catch (\Throwable $e) {
            Log::critical('💥 Unexpected checkout failure', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with([
                'message' => 'Unexpected error occurred. Please try again.',
                'alert-type' => 'error'
            ]);
        }
    }



    public function securityCheck($order_id)
    {
        $orderid = $order_id;
        return view("frontend.security-check", compact("orderid"));
    }


public function securityVerify(Request $request)
{
    $request->validate([
        "password" => "required",
        "order_id" => "required",
    ]);

    $user = Auth::user();

    // ✅ Verify password
    if (!Hash::check($request->password, $user->password)) {
        return back()->with([
            'message' => 'Incorrect password. Please try again.',
            'alert-type' => 'error'
        ]);
    }

    $orderId = base64_decode($request->order_id);

    $order = Orders::where('user_id', $user->id)->find($orderId);

    if (!$order) {
        return back()->with([
            'message' => 'Invalid order or access denied.',
            'alert-type' => 'error'
        ]);
    }

    // Log::info('Order verified:', ['order' => $order]);

    // ✅ Redirect based on payment method
    if ($order->payment_method == 'paystack') {
        return redirect()->route('paystack.initialize', ['order_id' => $request->order_id]);
    } elseif ($order->payment_method == 'opay') {
        // redirect to opay
    } elseif ($order->payment_method == 'stripe') {
        // redirect to stripe
    } else {
        // handle credit card or other methods
    }
}

}
