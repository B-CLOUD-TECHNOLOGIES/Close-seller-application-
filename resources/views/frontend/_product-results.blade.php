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
                        <button class="btn p-0 position-relative"
                            onclick="window.location.href='./src/frontend/buyer/views/checkout/checkout.php'">
                            <span class="material-symbols-outlined text-gray-700">shopping_cart</span>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange-notification text-white"
                                style="font-size: 0.5rem">
                                4
                            </span>
                        </button>
                    </div>

                </div>
            </header>




            <!-- New Arrivals -->
            <div class="px-3 pt-4 mb-5 pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h6 fw-bold text-gray-800 mb-0">{{ $pageName }} </h3>
                    <div class="d-flex gap-3 dropdown-container">

                        {{-- <!-- Sort Dropdown -->
                        <div class="dropdown">
                            <button class="dropdown-btn">Sort ▾</button>
                            <div class="dropdown-content">
                                <a href="#">Newest</a>
                                <a href="#">Oldest</a>
                                <a href="#">Price: Low to High</a>
                                <a href="#">Price: High to Low</a>
                            </div>
                        </div> --}}

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
                </div>


                <div class="row mt-3 g-3" id="main-product">
                    <!-- Product 1 -->
                    @if ($products->count() > 0)
                        @foreach ($products as $product)
                            @include('frontend._products')
                        @endforeach
                    @else
                        <h6 class="text-muted fw-bold">No Product(s) Available</h6>
                    @endif
                </div>


                <!-- you might also like -->
                <div class="row mt-3 g-3">
                    <h6 class="h6 fw-bold text-gray-800 mb-0">You may also like</h6>
                    <!-- Product 1 -->
                    @if ($otherProducts->count() > 0)
                        @foreach ($otherProducts as $product)
                            @include('frontend._products')
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