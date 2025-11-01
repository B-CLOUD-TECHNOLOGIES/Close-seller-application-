    @extends('frontend.frontend-master')

    @section('main')
        <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">

        <!-- Loading Placeholder -->
        {{-- <div id="loading-placeholder">
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
        </div> --}}

        <!-- Main Content -->
        <div id="main-content">
            <!-- Header -->
            <header class="sticky-top bg-white shadow-sm p-3 z-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="back-btn" onclick="window.history.back();">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </button>
                    </div>
                    <div class="d-flex flex-start align-items-center">
                        <form action="{{ route('product.search') }}" method="GET">
                            @csrf
                            <label for="searchBtn"
                                class="material-symbols-outlined position-absolute top-50 translate-middle-y ms-3 text-gray-500">Search</label>
                            <input type="text" name="search" class="form-control rounded-pill ps-5 search-input"
                                placeholder="Search for products..." autocomplete="search" value="">
                            <button type="submit" id="searchBtn" name="searcBtn" hidden></button>
                        </form>
                    </div>
                    <div class="d-flex align-items-center gap-3 shopping-cart-btn">
                        @include('frontend._cart-button')
                    </div>

                </div>
            </header>




            <!-- New Arrivals -->
            <div class="px-3 pt-4 mb-5 pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h6 fw-bold text-gray-800 mb-0">{{ $pageName }} </h3>
                    @if ($products->count() > 0)
                        <div class="d-flex gap-3 dropdown-container">

                            <div class="custom-dropdown">
                                <select id="sort-products" class="dropdown-select">
                                    <option value="" selected disabled>Sort by</option>
                                    <option value="newest">Newest</option>
                                    <option value="oldest">Oldest</option>
                                    <option value="low-high">Price: Low to High</option>
                                    <option value="high-low">Price: High to Low</option>
                                </select>
                            </div>
                        </div>
                    @endif
                </div>


                <div class="row mt-3 g-3" id="main-product">
                    <!-- Product 1 -->
                    @if ($products->count() > 0)
                        @foreach ($products as $product)
                            @php
                                $firstImage = $product->getFirstImage();
                                $productid = $product->id;
                                $inWishlist = Auth::check()
                                    ? \App\Models\productWishlist::isInWishlist($productid, Auth::id())
                                    : false;
                            @endphp

                            <div class="col-6 product-item" data-date="{{ $product->updated_at }}"
                                data-price="{{ $product->new_price }}">

                                <div class="card new-arrival-card border border-gray-200 rounded-3 overflow-hidden h-100">
                                    <button class="btn btn-light p-1 position-absolute top-0 end-0 m-2 z-2 rounded-circle"
                                        style="background: rgba(255,255,255,0.7);"
                                        onclick="window.location.href='{{ route('delete_wishlist', [$product->id]) }}'">
                                        {{-- 👇 Default heart state --}}
                                        @if ($inWishlist)
                                            <i class='heart-icon fa fa-heart' style='color: #7c3aed;font-size:1rem'></i>
                                        @else
                                            <i class='heart-icon fa fa-heart-o' style='color: #555;font-size:1rem'></i>
                                        @endif
                                    </button>

                                    <a href="{{ route('product.details', [
                                        $product->id,
                                        $product->product_name,
                                        $product->category_id,
                                        Str::slug($product->getCategory->category_name),
                                    ]) }}
"
                                        class="text-decoration-none">
                                        <div class="overflow-hidden">
                                            <img src="{{ !empty($firstImage) ? asset($firstImage->image_name) : asset('uploads/no_image.jpg') }}"
                                                class="new-arrival-img w-100" alt="{{ $product->product_name }}">
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title fs-12 fw-semibold text-gray-800">
                                                {{ $product->product_name }}
                                            </h6>
                                            <p class="card-text fw-bold text-purple-600 mb-1">
                                                ₦{{ number_format($product->new_price) }}</p>
                                            @if ($product->old_price)
                                                <small
                                                    class="card-text fw-bold text-secondary mb-1 text-decoration-line-through">₦{{ number_format($product->old_price) }}</small>

                                                @php
                                                    $discount = 0;
                                                    if (
                                                        $product->old_price > 0 &&
                                                        $product->new_price > 0 &&
                                                        $product->old_price > $product->new_price
                                                    ) {
                                                        $discount = round(
                                                            (($product->old_price - $product->new_price) /
                                                                $product->old_price) *
                                                                100,
                                                        );
                                                    }
                                                @endphp

                                                @if ($discount > 0)
                                                    <span class="badge bg-danger ms-2">-{{ $discount }}%</span>
                                                @endif
                                            @endif

                                            <div
                                                class="d-flex justify-content-between flex-wrap align-items-center mb-1 small">
                                                <div class="product-rating">
                                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                                    <span class="rating-text">{{ number_format($product->reviews_avg_rating, 1) ?? '0.0' }}</span>
                                                </div>

                                                <div class="product-location text-end">
                                                    <i class="fa fa-map-marker text-muted" aria-hidden="true"></i>
                                                    <span class="location-text">
                                                        {{ $product->location }}
                                                        {{-- {{ !empty($product->city) ? ' ,'. $product->city : "" }} --}}
                                                    </span>
                                                </div>
                                                <p hidden>{{ $product->updated_at }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h6 class="text-muted fw-bold">No Product(s) Available</h6>
                    @endif
                </div>
            </div>

            <!-- Fixed Footer Navigation -->
            @include('frontend.footer')
        </div>




        <script>
            $(document).ready(function() {
                $('#sort-products').on('change', function() {
                    const sortType = $(this).val();
                    const container = $('.row'); // adjust if your product cards are in another container
                    const products = $('#main-product .product-item').get();

                    if (sortType === 'newest') {
                        products.sort((a, b) => new Date($(b).data('date')) - new Date($(a).data('date')));
                    } else if (sortType === 'oldest') {
                        products.sort((a, b) => new Date($(a).data('date')) - new Date($(b).data('date')));
                    } else if (sortType === 'low-high') {
                        products.sort((a, b) => $(a).data('price') - $(b).data('price'));
                    } else if (sortType === 'high-low') {
                        products.sort((a, b) => $(b).data('price') - $(a).data('price'));
                    }

                    $.each(products, function(i, item) {
                        container.append(item);
                    });
                });
            });
        </script>

    @endsection
