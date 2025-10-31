@extends('users.user-master')


@section('users')
    <link rel="stylesheet" href="{{ asset('users/assets/css/profile.css') }}">

    @php
        use App\Models\User;
        $id = Auth::user()->id;
        $user = User::find($id);

    @endphp

    <!-- Back Arrow -->
    <div class="container mt-3">
        <a href="{{ url('/') }}" class="back-link"><i class="fas fa-arrow-left"></i></a>
    </div>

    <!-- Profile Info -->
    <div class="text-center mt-3">
        <img src="{{ !empty($user->image) ? asset($user->image) : asset('uploads/no_image.png') }}" class="profile-img mb-2">
        <h5 class="profile-name">{{ $user->username }}</h5>
        <p class="text-muted mb-1">{{ $user->phone ?? '' }}</p>
        <button class="edit-btn" onclick="window.location.href='{{ route('edit.user.profile') }}'">
            <i class="fas fa-pen me-1"></i> Edit profile
        </button>
    </div>

    <!-- Menu Items -->
    <div class="container mt-4">
        <div class="list-group">

            <a href="{{ route('user.wishlist') }}" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-heart"></i></div>
                    <div>
                        <span class="menu-title">My Wishlist</span>
                        <br>
                        <small class="menu-sub">
                            View my wishlist
                        </small>
                    </div>
                </div>
                <i class="fas fa-chevron-right arrow"></i>
            </a>


            <a href="{{ route("user.transactions") }}" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-receipt"></i></div>
                    <div><span class="menu-title">Transactions</span><br><small class="menu-sub">See all
                            transactions</small></div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a>

            <a href="{{ route('users.orders') }}" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-shopping-bag"></i></div>
                    <div><span class="menu-title">My Orders</span><br><small class="menu-sub">View order history</small>
                    </div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a>

            <a href="{{ route('user.reviews') }}" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-star"></i></div>
                    <div><span class="menu-title">My Reviews</span><br><small class="menu-sub">View your reviews</small>
                    </div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a>

            {{-- <a href="#" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-sliders-h"></i></div>
                    <div><span class="menu-title">Preferences</span><br><small class="menu-sub">Notification
                            settings</small></div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a> --}}

            <a href="{{ route('user.change.password') }}" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-lock"></i></div>
                    <div><span class="menu-title">Security</span><br><small class="menu-sub">Change password</small></div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a>

            <a href="{{ route("user.faqs") }}" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-question-circle"></i></div>
                    <div><span class="menu-title">FAQs</span><br><small class="menu-sub">Common questions</small></div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a>

            <a href="{{ route('user.customer.support') }}" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-headset"></i></div>
                    <div><span class="menu-title">Help & Support</span><br><small class="menu-sub">Customer support</small>
                    </div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a>

            <a href="#" class="list-group-item d-flex align-items-center justify-content-between mb-3 menu-item">
                <div class="d-flex align-items-center">
                    <div class="icon-box"><i class="fas fa-info-circle"></i></div>
                    <div><span class="menu-title">About Us</span><br><small class="menu-sub">App information</small></div>
                </div><i class="fas fa-chevron-right arrow"></i>
            </a>

        </div>
    </div>

    <!-- Logout -->
    <div class="container text-center mt-4 mb-4">
        <a href="{{ route('user_logout') }}" id="logout"
            class="logout-btn d-block w-100 text-white text-decoration-none">Logout</a>
    </div>
@endsection
