    @extends('frontend.frontend-master')

    @section('main')
        <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">

        <!-- Loading Placeholder -->
        <div id="loading-placeholder">
            <!-- Skeleton Header -->
            <div class="skeleton skeleton-header"></div>

            <!-- Skeleton Search -->
            <div class="p-3">
                <div class="skeleton skeleton-search"></div>
            </div>

            <!-- Skeleton Banner -->
            <div class="skeleton skeleton-banner mx-3"></div>

            <!-- Skeleton Categories -->
            <div class="px-3 pt-4">
                <div class="skeleton skeleton-section-title mb-3"></div>
                <div class="d-flex gap-4 pb-3">
                    <div class="text-center flex-shrink-0">
                        <div class="skeleton skeleton-category-circle"></div>
                        <div class="skeleton skeleton-category-text"></div>
                    </div>
                    <div class="text-center flex-shrink-0">
                        <div class="skeleton skeleton-category-circle"></div>
                        <div class="skeleton skeleton-category-text"></div>
                    </div>
                    <div class="text-center flex-shrink-0">
                        <div class="skeleton skeleton-category-circle"></div>
                        <div class="skeleton skeleton-category-text"></div>
                    </div>
                </div>
            </div>

            <!-- Skeleton Pre-order Market -->
            <div class="px-3 pt-4">
                <div class="skeleton skeleton-section-title mb-3"></div>
                <div class="d-flex gap-3 pb-3">
                    <div class="skeleton-product-card flex-shrink-0" style="width: 160px;">
                        <div class="skeleton skeleton-product-image"></div>
                        <div class="p-2">
                            <div class="skeleton skeleton-product-title mb-2"></div>
                            <div class="skeleton skeleton-product-price mb-2"></div>
                            <div class="skeleton skeleton-product-rating"></div>
                        </div>
                    </div>
                    <div class="skeleton-product-card flex-shrink-0" style="width: 160px;">
                        <div class="skeleton skeleton-product-image"></div>
                        <div class="p-2">
                            <div class="skeleton skeleton-product-title mb-2"></div>
                            <div class="skeleton skeleton-product-price mb-2"></div>
                            <div class="skeleton skeleton-product-rating"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skeleton New Arrivals -->
            <div class="px-3 pt-4">
                <div class="skeleton skeleton-section-title mb-3"></div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="skeleton-product-card">
                            <div class="skeleton skeleton-new-arrival-image"></div>
                            <div class="p-2">
                                <div class="skeleton skeleton-product-title mb-2"></div>
                                <div class="skeleton skeleton-product-price mb-2"></div>
                                <div class="skeleton skeleton-product-rating"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skeleton-product-card">
                            <div class="skeleton skeleton-new-arrival-image"></div>
                            <div class="p-2">
                                <div class="skeleton skeleton-product-title mb-2"></div>
                                <div class="skeleton skeleton-product-price mb-2"></div>
                                <div class="skeleton skeleton-product-rating"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skeleton Footer -->
            <div class="fixed-bottom bg-white shadow-sm">
                <div class="container">
                    <div class="d-flex justify-content-around align-items-center py-3">
                        <div class="text-center">
                            <div class="skeleton rounded-circle mx-auto mb-1" style="width: 24px; height: 24px;"></div>
                            <div class="skeleton" style="width: 40px; height: 10px;"></div>
                        </div>
                        <div class="text-center">
                            <div class="skeleton rounded-circle mx-auto mb-1" style="width: 24px; height: 24px;"></div>
                            <div class="skeleton" style="width: 40px; height: 10px;"></div>
                        </div>
                        <div class="text-center">
                            <div class="skeleton rounded-circle mx-auto mb-1" style="width: 24px; height: 24px;"></div>
                            <div class="skeleton" style="width: 40px; height: 10px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main-content">
            <!-- Header -->
            <header class="sticky-top bg-white shadow-sm p-3 z-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h1 class="h5 fw-bold mb-0 text-purple-600">CloseSeller</h1>
                    </div>
                    <div class="d-flex align-items-center justify-content-around gap-3">
                        <button class="btn p-0 position-relative" onclick="window.location.href='{{ url('/notifications') }}'">
                            <span class="material-symbols-outlined text-gray-700">notifications</span>
                            @if ($unreadCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange-notification text-white"
                                    style="font-size: 0.5rem">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        @include('frontend._cart-button')
                    </div>
                </div>
            </header>

            <!-- Search Bar -->
            <div class="p-3">
                <div class="position-relative">
                    <form action="{{ route('product.search') }}" method="GET">
                        @csrf
                        <span
                            class="material-symbols-outlined position-absolute top-50 translate-middle-y ms-3 text-gray-500">search</span>
                        <input type="text" name="search" class="form-control rounded-pill ps-5 search-input"
                            placeholder="Search for products..." autocomplete="search">
                        <button type="submit" id="searchBtn" name="searchBtn" hidden></button>
                    </form>
                </div>
            </div>

            <!-- Banner Carousel -->
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('users/assets/images/banner.jpg') }}" class="d-block w-100"
                            alt="Promotional Banner" style="height: 192px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('users/assets/images/banner2.jpg') }}" class="d-block w-100"
                            alt="New Arrivals Banner" style="height: 192px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('users/assets/images/banner.jpg') }}" class="d-block w-100"
                            alt="Best Deals Banner" style="height: 192px; object-fit: cover;">
                    </div>
                </div>
                <div class="carousel-indicators position-absolute bottom-0 mb-2">
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
                </div>
            </div>

            <!-- Categories -->
            <div class="px-3 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 fw-bold text-gray-800 mb-0">Categories</h3>
                </div>
                <div class="category-scroll no-scrollbar">

                    @php
                        $colors = [
                            ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                            ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
                        ];
                    @endphp

                    @foreach ($categories as $index => $cat)
                        @php
                            $color = $colors[$index % 2]; // alternate between purple & orange
                        @endphp

                        <div class="category-item">
                            <a href="{{ route('product.categories', [$cat->id, Str::slug($cat->category_name)]) }}"
                                class="text-decoration-none">
                                <div class="category-icon-wrapper {{ $color['bg'] }}">
                                    <span class="material-symbols-outlined {{ $color['text'] }} category-icon">
                                        {{ $cat->image }}
                                    </span>
                                </div>
                                <p class="category-name">{{ $cat->category_name }}</p>
                            </a>
                        </div>
                    @endforeach




                </div>
            </div>

            <!-- Pre-order Market -->
            <div class="pt-4">
                <div class="px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h5 fw-bold text-gray-800 mb-0">Pre-order Market</h3>
                        <a href="#" class="text-decoration-none small fw-semibold text-purple-600">See All</a>
                    </div>
                </div>
                <div class="d-flex overflow-auto mt-3 pb-3 ps-3 no-scrollbar gap-3">
                    <!-- Product 1 -->
                    <div class="card product-card border border-gray-200 rounded-3 overflow-hidden flex-shrink-0"
                        style="width: 160px;">
                        <button class="btn btn-light p-1 position-absolute top-0 end-0 m-2 z-2 rounded-circle"
                            style="background: rgba(255,255,255,0.7);"
                            onclick="toggleHeart(this.querySelector('.heart-icon'))">
                            <i class='heart-icon fa fa-heart-o' style='color: #555;font-size:1rem'></i>
                        </button>

                        <a href="#" class="text-decoration-none">
                            <div class="overflow-hidden">
                                <img src="{{ asset('users/assets/images/1.jpg') }}" class="product-img w-100"
                                    alt="iPhone 15 Pro">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title fw-semibold text-gray-800 text-truncate">iPhone 15 Pro Max</h6>
                                <p class="card-text fw-bold text-purple-600 mb-1">
                                    ₦1,200,000
                                    <span class="discount-badge" style="background-color: orange;">
                                        -15%
                                    </span>
                                </p>

                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-1 small">
                                    <div class="product-rating">
                                        <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                        <span class="rating-text">4.8</span>
                                    </div>

                                    <div class="product-location text-end">
                                        <i class="fa fa-map-marker text-muted" aria-hidden="true"></i>
                                        <span class="location-text">Lagos</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Product 2 -->
                    <div class="card product-card border border-gray-200 rounded-3 overflow-hidden flex-shrink-0"
                        style="width: 160px;">
                        <button class="btn btn-light p-1 position-absolute top-0 end-0 m-2 z-2 rounded-circle"
                            style="background: rgba(255,255,255,0.7);"
                            onclick="toggleHeart(this.querySelector('.heart-icon'))">
                            <i class='heart-icon fa fa-heart-o' style='color: #555;font-size:1rem'></i>
                        </button>

                        <a href="#" class="text-decoration-none">
                            <div class="overflow-hidden">
                                <img src="{{ asset('users/assets/images/2.jpg') }}" class="product-img w-100"
                                    alt="MacBook Pro">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title fw-semibold text-gray-800 text-truncate">MacBook Pro M3</h6>
                                <p class="card-text fw-bold text-purple-600 mb-1">
                                    ₦2,500,000
                                    <span class="discount-badge" style="background-color: orange;">
                                        -10%
                                    </span>
                                </p>

                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-1 small">
                                    <div class="product-rating">
                                        <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                        <span class="rating-text">4.9</span>
                                    </div>

                                    <div class="product-location text-end">
                                        <i class="fa fa-map-marker text-muted" aria-hidden="true"></i>
                                        <span class="location-text">Abuja</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Product 3 -->
                    <div class="card product-card border border-gray-200 rounded-3 overflow-hidden flex-shrink-0"
                        style="width: 160px;">
                        <button class="btn btn-light p-1 position-absolute top-0 end-0 m-2 z-2 rounded-circle"
                            style="background: rgba(255,255,255,0.7);"
                            onclick="toggleHeart(this.querySelector('.heart-icon'))">
                            <i class='heart-icon fa fa-heart-o' style='color: #555;font-size:1rem'></i>
                        </button>

                        <a href="#" class="text-decoration-none">
                            <div class="overflow-hidden">
                                <img src="{{ asset('users/assets/images/11.jpg') }}" class="product-img w-100"
                                    alt="AirPods Pro">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title fw-semibold text-gray-800 text-truncate">AirPods Pro 2nd Gen</h6>
                                <p class="card-text fw-bold text-purple-600 mb-1">
                                    ₦350,000
                                    <span class="discount-badge" style="background-color: tomato;">
                                        -20%
                                    </span>
                                </p>

                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-1 small">
                                    <div class="product-rating">
                                        <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                        <span class="rating-text">4.7</span>
                                    </div>

                                    <div class="product-location text-end">
                                        <i class="fa fa-map-marker text-muted" aria-hidden="true"></i>
                                        <span class="location-text">Lagos</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- New Arrivals -->
            <div class="px-3 pt-4 mb-5 pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h5 fw-bold text-gray-800 mb-0">New Arrivals</h3>
                </div>
                <div class="row mt-3 g-3">
                    <!-- Product 1 -->
                    @if ($products->count() > 0)
                        @foreach ($products as $product)
                            @include('frontend._products')
                        @endforeach
                    @else
                        <h6 class="text-muted fw-bold">No Product(s) Available for this category</h6>
                    @endif

                </div>
            </div>

            <!-- Fixed Footer Navigation -->
            @include('frontend.footer')
        </div>
    @endsection
