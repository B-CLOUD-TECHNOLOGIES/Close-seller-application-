    @extends('frontend.frontend-master')

    @section('main')
        <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">

        <div id="main-content">
            <!-- Header -->
            <header class="sticky-top bg-white shadow-sm p-3 z-3">
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn p-0" onclick="window.history.back();">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </button>
                    <h5 class="m-0 fw-semibold">My Cart</h5>
                    <div style="width: 24px;"></div> <!-- spacer -->
                </div>
            </header>

            <!-- Cart Items -->
            <main class="p-3">
                @if ($cartCount > 0)
                    <!-- Item 1 -->
                    @foreach ($itemsWithProducts as $item)
                        <div class="d-flex align-items-center justify-content-between bg-white rounded-3 shadow-sm p-3 mb-3 cart-item"
                            data-cart-item-id="{{ $item['cart_item_id'] }}" data-stock="{{ $item['stock_quantity'] }}"
                            data-unit-price="{{ $item['unit_price'] }}" data-size="{{ $item['size_name'] ?? '' }}">

                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $item['product_image'] }}" alt="{{ $item['product_name'] }}" class="rounded"
                                    width="60" height="60">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $item['product_name'] }}</h6>
                                    @if ($item['size_name'])
                                        <small class="text-muted d-block">Size: {{ $item['size_name'] }}</small>
                                    @endif
                                    <small class="text-muted">Available: {{ $item['stock_quantity'] }}</small>
                                    <div class="text-muted fw-semibold mt-1">
                                        ₦ <span class="item-total">{{ number_format($item['total_price']) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-light rounded-circle p-0 btn-decrease"
                                    style="width:32px;height:32px;">-</button>
                                <span class="item-quantity">{{ $item['quantity'] }}</span>
                                <button class="btn btn-light rounded-circle p-0 btn-increase"
                                    style="width:32px;height:32px;">+</button>
                                <button class="btn p-0 text-danger btn-remove"
                                    onclick="removeCartItem({{ $item['cart_item_id'] }})">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>

                            </div>
                        </div>
                    @endforeach



                    <!-- Order Summary -->
                    <div class="bg-white rounded-3 shadow-sm p-3 mt-4 mb-5" id="order-summary">
                        <h6 class="fw-semibold mb-3">Order Summary</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>₦<span id="subtotal">0.00</span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Charge (3%)</span>
                            <span>₦<span id="charge">0.00</span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Extra (if applicable)</span>
                            <span>₦<span id="extra">0.00</span></span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold border-top pt-2 mb-3">
                            <span>Total</span>
                            <span>₦<span id="total">0.00</span></span>
                        </div>
                        <button class="btn-outline-primary w-100 mb-2" style="background:#E0C9FF;color:#5A2DA0;" onclick="window.location.href='{{ url('/') }}'">
                            Continue Shopping
                        </button>
                        <button class="btn-primary w-100" onclick="window.location.href='{{ route('checkout') }}'" style="background:#6C3CF0;color:#fff;">Checkout</button>
                    </div>
                @else
                    <h6 class="text-center">You have an Empty Cart</h6>
                @endif
            </main>


            @include('frontend.footer')
        </div>





        <script>
            $(document).ready(function() {

                // ✅ Increase quantity
                $(document).on('click', '.btn-increase', function() {
                    let $item = $(this).closest('.cart-item');
                    let quantity = parseInt($item.find('.item-quantity').text());
                    let stock = parseInt($item.data('stock'));
                    let price = parseFloat($item.data('unit-price'));

                    if (quantity < stock) {
                        quantity++;
                        updateCartDisplay($item, quantity, price);
                    } else {
                        toastr.warning('You have reached the maximum stock quantity.');
                    }
                });

                // ✅ Decrease quantity
                $(document).on('click', '.btn-decrease', function() {
                    let $item = $(this).closest('.cart-item');
                    let quantity = parseInt($item.find('.item-quantity').text());
                    let price = parseFloat($item.data('unit-price'));

                    if (quantity > 1) {
                        quantity--;
                        updateCartDisplay($item, quantity, price);
                    }
                });

                // ✅ Function to update quantity and total in UI
                function updateCartDisplay($item, quantity, price) {
                    $item.find('.item-quantity').text(quantity);
                    let total = price * quantity;
                    $item.find('.item-total').text(total.toLocaleString());

                    // Optional: Send update to backend
                    $.ajax({
                        url: "{{ route('update.cart') }}",
                        type: 'POST',
                        data: {
                            cart_item_id: $item.data('cart-item-id'),
                            quantity: quantity,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "timeOut": "3000",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut",
                                    "preventDuplicates": true
                                };
                                toastr.success('Cart updated successfully');
                                updateCartCount();
                            }
                        },
                        error: function() {
                            toastr.error('Error updating cart. Please try again.');
                        }
                    });
                }


                function calculateOrderSummary() {
                    let subtotal = 0;

                    $('.cart-item').each(function() {
                        const itemTotal = parseFloat($(this).find('.item-total').text().replace(/,/g, '')) || 0;
                        subtotal += itemTotal;
                    });

                    // Calculate 3% charge
                    let charge = subtotal * (3 / 100);
                    let extra = 0;

                    // Cap at ₦3500
                    if (charge >= 3500) {
                        charge = 3500;
                    }

                    // Add ₦100 if subtotal > ₦2500
                    if (subtotal > 2500) {
                        charge += 100;
                        extra = 100;
                    }

                    const total = subtotal + charge;

                    // Update UI
                    $('#subtotal').text(subtotal.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    }));
                    $('#charge').text((charge - extra).toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    }));
                    $('#extra').text(extra.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    }));
                    $('#total').text(total.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    }));
                }

                // Run once on load
                calculateOrderSummary();

                // Recalculate when quantity changes
                $(document).on('click', '.btn-increase, .btn-decrease, .btn-remove', function() {
                    setTimeout(calculateOrderSummary, 300);
                });

            });



            function removeCartItem(cartItemId) {
                if (!confirm("Are you sure you want to remove this item from your cart?")) {
                    return;
                }

                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    type: "POST",
                    data: {
                        cart_item_id: cartItemId,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            location.reload();
                            // $(`.cart-item[data-cart-item-id='${cartItemId}']`).fadeOut(300, function() {
                            //     $(this).remove();
                            // });
                        } else {
                            toastr.error(response.message || 'Failed to remove item from cart.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            }
        </script>

        <script></script>


    @endsection
