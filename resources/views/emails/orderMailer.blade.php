<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - {{ config('app.name') }}</title>
</head>
<body style="font-family: 'Poppins', sans-serif; background-color: #f9f9ff; color: #333; padding: 30px;">

    <div style="max-width: 700px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background-color: #713899; color: #fff; text-align: center; padding: 25px;">
            <h1 style="margin: 0;">{{ config('app.name') }}</h1>
        </div>

        <!-- Invoice Header -->
        <div style="padding: 25px;">
            <h2 style="color: #333;">Order Details</h2>
            <p><b>Order No:</b> {{ $getOrder->order_no }}</p>
            <p><b>Date of Purchase:</b> {{ $createdAt->format('F j, Y') }} at {{ $createdAt->format('h:i A') }}</p>
        </div>

        <!-- Greeting -->
        <div style="padding: 0 25px 25px;">
            <p>Dear {{ $getOrder->name }},</p>
            <p>Thank you for your recent purchase. Please find your order details below:</p>
        </div>

        <!-- Order Table -->
        <div style="padding: 0 25px 25px;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background-color: #f1f0ff; color: #333;">
                        <th style="padding: 10px; text-align: left;">Item</th>
                        <th style="padding: 10px; text-align: left;">Quantity</th>
                        <th style="padding: 10px; text-align: left;">Price (₦)</th>
                        <th style="padding: 10px; text-align: left;">Total (₦)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subTotal = 0; @endphp
                    @foreach ($orderItems as $item)
                        @php
                            $product = $item->product; // ✅ Correct relationship call
                            $firstImage = $product?->getFirstImage();
                            $imagePath = $firstImage ? asset($firstImage->image_name) : asset("uploads/no_image.jpg");

                            $total = $item->total_price * $item->quantity;
                            $subTotal += $total;
                        @endphp
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">
                                <img src="{{ $imagePath }}" alt="{{ $product->product_name ?? 'Product Image' }}" style="max-width: 80px; height: auto; display: block; margin-bottom: 8px;">
                                <strong>{{ $product->product_name ?? 'Unknown Product' }}</strong><br>
                                @if(!empty($item->color_name))
                                    Color: {{ $item->color_name }}
                                @endif
                                <br>
                                @if(!empty($item->size_name))
                                    Size: {{ $item->size_name }}<br>
                                    Size Amount: ₦{{ number_format($item->size_amount, 2) }}
                                @endif
                            </td>
                            <td style="padding: 10px;">{{ $item->quantity }}</td>
                            <td style="padding: 10px;">₦{{ number_format($item->price, 2) }}</td>
                            <td style="padding: 10px;">₦{{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div style="padding: 0 25px 25px;">
            <div style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px;">
                <p><b>Subtotal:</b> ₦{{ number_format($subTotal, 2) }}</p>
                <p><b>Shipping Fee:</b> ₦{{ number_format($getOrder->shipping_amount, 2) }}</p>
                <p><b>Total Amount:</b> ₦{{ number_format($getOrder->total_amount, 2) }}</p>
                <p><b>Payment Method:</b> <i style="text-transform: capitalize;">{{ $getOrder->payment_method }}</i></p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f1f0ff; padding: 20px; text-align: left;">
            <p>Thank you for choosing <b>{{ config('app.name') }}</b>! We appreciate your business.</p>
            <p>If you have any questions, reach us at 
                <a href="mailto:support@example.com" style="color: #713899;">support@example.com</a>.
            </p>
            <p style="margin-top: 20px; font-weight: 600;">Best Regards,</p>
            <h4 style="margin: 5px 0 0; color: #713899;">{{ config('app.name') }}</h4>
        </div>

        <div style="background-color: #713899; color: #fff; text-align: center; padding: 15px;">
            <small>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
        </div>
    </div>
</body>
</html>
