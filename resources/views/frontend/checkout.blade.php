@section('main')
    @extends('frontend.frontend-master')

    <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('users/assets/css/checkout.css') }}">

    <div id="main-content">
        <!-- Header -->
        <header class="sticky-top bg-white shadow-sm p-3 z-3">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn p-0" onclick="window.history.back();">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <h5 class="m-0 fw-semibold">Checkout</h5>
                <div style="width: 24px;"></div> <!-- spacer -->
            </div>
        </header>

        <!-- Cart Items -->
        <main class="p-3 mb-5">


            <form action="{{ route('place.order') }}" id="theForm" method="POST">
                @csrf

                <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                <!-- Shipping Address -->
                <div class="checkout-section mb-4">
                    <h6>Shipping Address</h6>
                    <input type="text" name="name" class="form-control mb-2" placeholder="Full Name"
                        value="{{ $getAddress->name ?? '' }}">
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email Address"
                        value="{{ $getAddress->email ?? '' }}">
                    <input type="text" name="address" class="form-control mb-2" placeholder="Home Address"
                        value="{{ $getAddress->address ?? '' }}">
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" name="city" class="form-control" placeholder="City"
                            value="{{ $getAddress->city ?? '' }}">
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone Number"
                            value="{{ $getAddress->phone ?? '' }}">
                    </div>
                    <!-- Country as a select -->
                    <select class="form-select mb-2" name="state">
                        @php
                            $getState = $getAddress->state ?? '';
                        @endphp
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}" {{ $getState == $state->name ? 'selected' : '' }}>
                                {{ $state->name }}</option>
                        @endforeach
                    </select>

                    <!-- Country as a select -->
                    <select class="form-select" name="country">
                        <option value="NIgeria" selected>Nigeria</option>
                    </select>
                </div>

                <!-- Shipping Method -->
                <div class="checkout-section mb-4">
                    <h6>Shipping Method</h6>

                    <label class="shipping-option active">
                        <div class="shipping-left">
                            <input type="radio" name="shipping" checked>
                            <div>
                                <strong>Standard</strong>
                                <small class="text-muted">4-5 business days</small>
                            </div>
                        </div>
                        <span class="fw-semibold">Free</span>
                    </label>

                    {{-- <label class="shipping-option">
                        <div class="shipping-left">
                            <input type="radio" name="shipping">
                            <div>
                                <strong>Express</strong>
                                <small class="text-muted">1-2 business days</small>
                            </div>
                        </div>
                        <span class="fw-semibold">$15.00</span>
                    </label> --}}
                </div>


                <!-- Payment Options -->
                <div class="checkout-section mb-4">
                    <h6>Payment</h6>

                    <label class="payment-option active">
                        <div class="payment-left">
                            <input type="radio" name="payment" checked value="paystack">
                            <strong>Paystack</strong>
                        </div>
                        <img src="{{ asset('users/assets/images/paystack.png') }}" alt="Paystack" width="80"
                            height="20">
                    </label>

                    <label class="payment-option">
                        <div class="payment-left">
                            <input type="radio" name="payment" value="credit card">
                            <strong>Credit Card</strong>
                        </div>
                        <span class="material-symbols-outlined">credit_card</span>
                    </label>

                    <label class="payment-option">
                        <div class="payment-left">
                            <input type="radio" name="payment" value="opay">
                            <strong>OPay</strong>
                        </div>
                        <img src="{{ asset('users/assets/images/opay.png') }}" alt="OPay" style="height:16px;">
                    </label>

                    <label class="payment-option">
                        <div class="payment-left">
                            <input type="radio" name="payment" value="stripe">
                            <strong>Stripe</strong>
                        </div>
                        <span class="fa-brands fa-stripe fs-2" style="color: #7c3aed;"></span>
                    </label>

                </div>


                <!-- Pay Button -->
                <button type="submit" class="pay-btn spin-btn">
                    <span class="btn-text">Pay ₦ {{ number_format($total, 2) }} </span>
                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                </button>

            </form>

        </main>




    </div>

    <script>
        // Toggle active shipping option
        document.querySelectorAll('.shipping-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.shipping-option').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });

        // Payment option toggle
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', () => {
                // remove active class from all
                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('active'));
                // add active class to the clicked one
                option.classList.add('active');
                // check its radio input
                option.querySelector('input').checked = true;
            });
        });


        document.getElementById('phone').addEventListener('input', function(event) {
            let value = event.target.value;
            let newValue = value.replace(/[^+0-9]/g, '');

            if (newValue.indexOf('+') !== -1) {
                newValue = newValue.replace(/\+/g, '');
                newValue = '+' + newValue;
            }

            if (newValue.length > 14) {
                newValue = newValue.substring(0, 14);
            }

            event.target.value = newValue;
        });
    </script>
@endsection
