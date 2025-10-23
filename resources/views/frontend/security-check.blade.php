@section('main')
    @extends('frontend.frontend-master')

    <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('users/assets/css/checkout.css') }}">
    <style>
        .card {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div id="main-content">
        <!-- Header -->
        {{-- <header class="sticky-top bg-white shadow-sm p-3 z-3">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn p-0" onclick="window.history.back();">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <h5 class="m-0 fw-semibold">Verification</h5>
                <div style="width: 24px;"></div> <!-- spacer -->
            </div>
        </header> --}}

        <!-- Cart Items -->
        <main>
            <section class="d-flex align-items-center justify-content-center min-vh-100">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 420px; width: 100%;">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fa-solid fa-shield-halved fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Security Check</h4>
                        <p class="text-muted small">Please confirm your password to continue with payment</p>
                    </div>

                    <form action="{{ route('security.verify') }}" method="POST" id="theForm">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $orderid }}">
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Enter Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa-solid fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password"
                                    placeholder="********" required name="password">
                                <span class="input-group-text bg-white border-start-0">
                                    <span class="material-icons text-secondary toggle-password"
                                        style="cursor:pointer;">visibility</span>
                                </span>
                            </div>
                            @error('password')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn-outline-primary py-2 fw-semibold spin-btn">
                                <span class="btn-text"> Continue to Payment</span>
                                <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('checkout') }}" class="text-decoration-none small text-secondary">
                                <i class="fa-solid fa-arrow-left me-1"></i> Back to Checkout
                            </a>
                        </div>
                    </form>
                </div>
            </section>




        </main>




    </div>


    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                const input = $('#password');
                const icon = $(this);
                const isPassword = input.attr('type') === 'password';

                // Toggle input type
                input.attr('type', isPassword ? 'text' : 'password');

                // Toggle icon text between visibility and visibility_off
                icon.text(isPassword ? 'visibility_off' : 'visibility');
            });
        })
    </script>
@endsection
