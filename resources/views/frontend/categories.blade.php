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
            <header
                class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom bg-white shadow-sm position-sticky top-0">
                <button class="btn btn-link text-dark p-0" onclick="window.location.href='{{ route('index') }}'">
                    <span class="material-symbols-outlined fs-4">arrow_back</span>
                </button>
                <h1 class="h6 fw-semibold m-0">All Categories</h1>
                <div style="width: 32px;"></div>
            </header>


            <!-- New Arrivals -->
            <div class="px-3 pt-4 mb-5 pb-3">
                <!-- Category Item -->
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

                    <a href="{{ route('product.categories', [$cat->id, Str::slug($cat->category_name)]) }}"
                        class="d-flex align-items-center justify-content-between p-3 bg-white category-card text-decoration-none text-dark shadow-sm mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box bg-light">
                                <span class="material-symbols-outlined {{ $color['text'] }} category-icon">
                                   {{ $cat->image }}
                                </span>
                            </div>
                            <div>
                                <h2 class="category-title text-muted mb-0 h6">{{ $cat->category_name }}</h2>
                                <p class="category-items mb-0">{{ $cat->getProductCount->count() }} item</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-muted">chevron_right</span>
                    </a>
                @endforeach




            </div>

            <!-- Fixed Footer Navigation -->
            @include('frontend.footer')
        </div>
    @endsection
