@extends('vendors.vendor-masters')
@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/orderDispatched.css') }}" />

<main>
    <!-- Header -->
    <div class="order-head">
        <a class="arrow-back-a" href="javascript:history.back()">
            <svg class="arrow-back" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#701d9d" />
            </svg>
        </a>
        <div class="head-text">
            <p class="head-text-order">Order Details</p>
        </div>
    </div>

    <!-- Order Details Card -->
    <div class="order-detail fadeIn">
        <div class="order-card-header">
            <div id="statusBadge" class="order-status-badge">
                <span class="material-symbols-outlined" style="font-size: 14px;">local_shipping</span>
                @php
                    $statusText = match($order->status) {
                        1 => 'Processing',
                        2 => 'Dispatched',
                        3 => 'Delivered',
                        default => 'Pending'
                    };
                @endphp
                {{ $statusText }}
            </div>
            <div id="orderNo" class="order-id">#{{ $order->order_no }}</div>
        </div>

        <div class="order-content">
           <div class="order-item-section">
                <div class="order-item-img-container">
                    <img class="order-item-img"
                        src="{{ asset($item->product->getImage->first()->image_name ?? 'default-product.png') }}"
                        alt="{{ $item->product->product_name }}">
                </div>
                <div class="order-item-info">
                    <h3 class="order-item-name">{{ $item->product->product_name }}</h3>
                    <div class="order-price">
                        <span class="naira-symbol">₦</span>
                        <span>{{ number_format($item->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="order-details-grid">
                <div class="detail-item">
                    <span class="detail-label">Buyer Name</span>
                    <span class="detail-value">{{ $order->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date Ordered</span>
                    <span class="detail-value">{{ $order->created_at->format('d/m/Y') }}</span>
                </div>
                {{-- Show color only if available --}}
                @if(!empty($item->color_name))
                    <div class="detail-item">
                        <span class="detail-label">Color</span>
                        <span class="detail-value">{{ $item->color_name }}</span>
                    </div>
                @endif

                {{-- Show size only if available --}}
                @if(!empty($item->size_name))
                    <div class="detail-item">
                        <span class="detail-label">Size</span>
                        <span class="detail-value">{{ $item->size_name }}</span>
                    </div>
                @endif

                {{-- Show size amount only if greater than 0 --}}
                @if(!empty($item->size_amount) && $item->size_amount > 0)
                    <div class="detail-item">
                        <span class="detail-label">Size Amount</span>
                        <span class="detail-value">₦{{ number_format($item->size_amount, 2) }}</span>
                    </div>
                @endif
                <div class="detail-item">
                    <span class="detail-label">Quantity</span>
                    <span class="detail-value">{{ $item->quantity ?? 0 }}</span>
                </div> 
            </div>

            <div class="order-details-grid mt-3">
                <div class="detail-item">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">{{ ucfirst($order->payment_method) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Delivery Address</span>
                    <span class="detail-value">{{ $fullAddress }}</span>
                </div>
            </div>
            <div class="total-amount">
                <div class="label">Total Amount</div>
                <div id="totalAmount" class="amount">₦{{ number_format($order->total_amount, 2) }}</div>
            </div>
        </div>
    </div>



    <!-- Order History -->
    <div class="order-history fadeIn" style="margin-top:20px;">
        <div class="tracking-header">
            <div class="tracking-icon">
                <span class="material-symbols-outlined" style="font-size: 16px;">history</span>
            </div>
            <h2>Order History</h2>
        </div>

        <div id="historyContainer">
            @if($tracking->count())
                <ul class="history-timeline" id="historyTimeline">
                    @foreach($tracking as $t)
                        <li class="history-item" data-status="{{ $t->status }}">
                            <div class="history-status">
                                {{ $t->status == 1 ? 'Placed' : ($t->status == 2 ? 'Dispatched' : ($t->status == 3 ? 'Completed' : 'Unknown')) }}
                            </div>
                            <div class="history-time">{{ $t->created_at->format('d M, Y h:i A') }}</div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="text-align:center; color:gray;">No history available.</p>
            @endif
        </div>
    </div>


</main>


@endsection
