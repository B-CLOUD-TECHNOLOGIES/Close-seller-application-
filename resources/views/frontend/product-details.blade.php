    @extends('frontend.frontend-master')

    @section('main')
        <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">
        <link rel="stylesheet" href="{{ asset('users/assets/css/product-details.css') }}">

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

        @php
            $productid = $product->id;
            $inWishlist = Auth::check() ? \App\Models\productWishlist::isInWishlist($productid, Auth::id()) : false;
            $stock_quantity = $product->stock_quantity;
        @endphp
        <!-- Main Content -->
        <div id="main-content">
            <!-- Header -->
            <div class="product-container">
                <!-- Header -->
                <div class="product-header py-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <button class="back-btn" onclick="window.history.back();">
                                    <span class="material-symbols-outlined">arrow_back</span>
                                </button>
                            </div>
                            <div class="col text-center">
                                <h2 class="h6 mb-0 fw-bold">Product Details</h2>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex justify-content-center">
                                    <button class="action-btn" onclick="window.location.href='{{ url('/') }}'">
                                        <span class="material-symbols-outlined d-block nav-icon"
                                            style='font-size:1.5rem'>home</span>
                                    </button>
                                    <button class="action-btn favorite-toggle"
                                        onclick="toggleHeart(this.querySelector('.heart-icon'), {{ $productid }})">
                                        @if ($inWishlist)
                                            <i class='heart-icon fa fa-heart' style='color: #7c3aed;font-size:1rem'></i>
                                        @else
                                            <i class='heart-icon fa fa-heart-o' style='color: #555;font-size:1rem'></i>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Carousel -->
                <div class="image-carousel" id="imageCarousel">
                    <div class="carousel-container" id="carouselContainer">
                        @foreach ($productImages as $image)
                            <div class="carousel-slide">
                                <img src="{{ asset($image->image_name) }}" alt="Product Image 1">
                            </div>
                        @endforeach
                    </div>
                    <div class="carousel-indicators" id="carouselIndicators">
                        <div class="indicator active" data-slide="0"></div>
                        <div class="indicator" data-slide="1"></div>
                        <div class="indicator" data-slide="2"></div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <h1 class="product-title">{{ $product->product_name }}</h1>
                    <div class="d-flex align-items-center">
                        <span class="product-price">₦{{ number_format($product->new_price) }}</span>
                        @if ($product->old_price)
                            <span class="old-price">₦{{ $product->old_price }}</span>
                        @endif
                    </div>
                    <div class="product-locations">
                        <span class="material-symbols-outlined me-2" style="font-size: 16px;">location_on</span>
                        <span>{{ $product->location }}{{ !empty($product->city) ? ', ' . $product->city : '' }}</span>
                    </div>
                    <p class="stock-status {{ $product->stock_quantity <= 0 ? 'out-of-stock' : 'in-stock' }} ">
                        {{ $product->stock_quantity <= 0
                            ? 'Out of Stock'
                            : ($product->stock_quantity == 1
                                ? '1 item left'
                                : $product->stock_quantity . ' items left') }}
                    </p>
                </div>

                <!-- Vendor Section -->
                <div class="vendor-section">
                    <div class="d-flex align-items-center">
                        <div class="vendor-avatar">

                            @if ($vendorType == 'Vendor')
                                <img src="{{ !empty($vendor->image) ? asset($vendor->image) : asset('uploads/no_image.png') }}"
                                    class="rounded-circle"
                                    style="width:50px;height:50px;object-fit:cover;object-position:top;"
                                    alt="{{ $vendorName }}">
                            @else
                                <img src="{{ asset('uploads/no_image.png') }}" class="rounded-circle"
                                    style="width:50px;height:50px;object-fit:cover;object-position:top;"
                                    alt="{{ $vendorName }}">
                            @endif

                        </div>
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-1">{{ $vendorName }}</p>
                            <div class="vendor-rating">
                                <span class="material-symbols-outlined text-warning me-1"
                                    style="font-size: 16px;">star</span>
                                <span>4.5 (24 reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selection Section -->
                <div class="selection-section bg-body">
                    <form id="theForm" method="POST">
                        @csrf

                        <input type="hidden" value="{{ $product->id }}" name="product_id">

                        @if ($productSizes->count() >= 1)
                            <div class="selection-group">
                                <label class="form-label">Size</label>
                                <select name="size_id" id="size_id" class="form-select" {{ 'required' }}>
                                    <option value="" selected disabled>Select a Size</option>
                                    @foreach ($productSizes as $size)
                                        <option value="{{ $size->id }}"
                                            data-price="{{ !empty($size->price) ? $size->price : 0 }}">{{ $size->name }}
                                            (₦{{ number_format($size->price) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif


                        @if ($product->getColor->count() >= 1)
                            <div class="selection-group">
                                <label class="form-label">Color</label>
                                <select name="color_id" id="color_id" class="form-select" {{ 'required' }}>
                                    <option value="" selected disabled>Select Color</option>
                                    @foreach ($product->getColor as $color)
                                        <option value="{{ $color->getProductColor->id }}">
                                            {{ $color->getProductColor->color }} </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif




                        <div class="selection-group">
                            <label class="form-label">Quantity</label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn minus">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">remove</span>
                                </button>
                                <input type="number" name="quantity" id="quantity" class="quantity-input" value="1"
                                    min="1" max="{{ $product->stock_quantity }}" readonly>
                                <button type="button" class="quantity-btn plus">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Description -->
                <div class="description-section bg-body">
                    <div class="collapsible-header" onclick="toggleSection(this)">
                        <h6>Description</h6>
                        <span class="material-symbols-outlined expand-icon">expand_more</span>
                    </div>
                    <div class="collapsible-content active">
                        <p class="text-muted mb-0">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>

                <!-- Reviews & Ratings -->
                <div class="reviews-section">
                    <h6 class="fw-bold mb-3">Reviews & Ratings</h6>
                    <div class="rating-summary">
                        <div class="rating-number">4.5</div>
                        <div>
                            <div class="rating-stars">
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star_half</span>
                                <span class="material-symbols-outlined text-muted">star</span>
                            </div>
                            <small class="text-muted">(24 reviews)</small>
                        </div>
                    </div>

                    <div class="rating-breakdown">
                        <div class="rating-row">
                            <span class="small text-muted">5</span>
                            <div class="rating-bar">
                                <div class="rating-fill" style="width: 70%;"></div>
                            </div>
                            <span class="small text-muted">70%</span>
                        </div>
                        <div class="rating-row">
                            <span class="small text-muted">4</span>
                            <div class="rating-bar">
                                <div class="rating-fill" style="width: 20%;"></div>
                            </div>
                            <span class="small text-muted">20%</span>
                        </div>
                        <div class="rating-row">
                            <span class="small text-muted">3</span>
                            <div class="rating-bar">
                                <div class="rating-fill" style="width: 5%;"></div>
                            </div>
                            <span class="small text-muted">5%</span>
                        </div>
                        <div class="rating-row">
                            <span class="small text-muted">2</span>
                            <div class="rating-bar">
                                <div class="rating-fill" style="width: 3%;"></div>
                            </div>
                            <span class="small text-muted">3%</span>
                        </div>
                        <div class="rating-row">
                            <span class="small text-muted">1</span>
                            <div class="rating-bar">
                                <div class="rating-fill" style="width: 2%;"></div>
                            </div>
                            <span class="small text-muted">2%</span>
                        </div>
                    </div>

                    <div id="reviews-container"></div>
                </div>

                <!-- Message Vendor -->
                <!-- <div class="message-section">
                                                                                <h6 class="fw-bold mb-3">Message Vendor</h6>
                                                                                <form action="#">
                                                                                    <textarea name="message" class="message-textarea" placeholder="Type your message..." required></textarea>
                                                                                    <button type="submit" class="btn btn-outline-primary">Send Message</button>
                                                                                </form>
                                                                            </div> -->

                <!-- Related Products -->
                <div class="px-3 pt-4 mb-5 pb-4 bg-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h5 fw-bold text-gray-800 mb-0">You May Also like</h3>
                    </div>
                    <div class="row mt-3 g-3">
                        <!-- Product 1 -->
                        @foreach ($relatedProducts as $product)
                            @include('frontend._products')
                        @endforeach


                    </div>
                </div>
            </div>

            <!-- Fullscreen Carousel -->
            <div class="fullscreen-carousel" id="fullscreenCarousel">
                <div class="fullscreen-container" id="fullscreenContainer">

                    <!-- Close button -->
                    <button class="fullscreen-close" id="fullscreenClose">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <!-- Prev button -->
                    <button class="fullscreen-nav fullscreen-prev" id="fullscreenPrev">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>

                    <!-- Next button -->
                    <button class="fullscreen-nav fullscreen-next" id="fullscreenNext">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>

                    <!-- ✅ Slides wrapper (only this gets cleared in JS) -->
                    <div class="fullscreen-slides" id="fullscreenSlides">
                        <!-- Slides will be injected dynamically -->
                    </div>

                    <!-- Indicators wrapper -->
                    <div class="fullscreen-indicators" id="fullscreenIndicators">
                        <!-- Indicators will be added dynamically -->
                    </div>
                </div>
            </div>




            <!-- Fixed Bottom Actions -->
            <div class="bottom-actions">
                <div class="bottom-buttons">
                    <button class="btn-outline-primary" onclick="scrollToMessage()">
                        <span class="material-symbols-outlined" style="font-size: 14px;">chat</span>
                        Chat with {{ $vendorType == 'Vendor' ? $vendorType : 'Closeseller' }}
                    </button>
                    @if ($stock_quantity > 0)
                        <button class="btn-primary spin-btn addProductToCart" type="submit" form="theForm"
                            name="addProductToCart">
                            <span class="material-symbols-outlined" style="font-size: 14px;">shopping_cart</span>
                            <span class="btn-text">{{ $isAdded ? 'Update' : 'Add to' }} {{ $stock_quantity }} Cart</span>
                            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    @else
                        <button class="btn-primary spin-btn addProductToCart" type="button" {{ 'disabled' }}>
                            <span class="material-symbols-outlined" style="font-size: 14px;">shopping_cart</span>
                            <span class="btn-text">Out of Stock</span>
                            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    @endif


                    <button class="btn p-0 position-relative" onclick="window.location.href='{{ route('view.cart') }}'">
                        <span class="material-symbols-outlined text-gray-700">shopping_cart</span>
                        <!-- Modify existing badge color -->
                        <span
                            class="cartCount start-100 translate-middle notification-badge rounded-pill bg-orange-notification text-white"
                            style="font-size: 0.5rem;top:7px; display: {{ $cartCount > 0 ? 'inline-block' : 'none' }}">{{ $cartCount }}
                        </span>
                    </button>
                </div>
            </div>

        </div>


        <script src="{{ asset('users/assets/js/script.js') }}"></script>
        <script>
            // ✅ Handle cart form submission
            $('#theForm').on('submit', function(e) {
                e.preventDefault();

                let formData = Object.fromEntries(new FormData(this));

                $.ajax({
                    url: "{{ route('add.to.cart') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        updateCartCount(); // refresh count dynamically

                        // ✅ Update button state after adding to cart
                        let $button = $('.addProductToCart');
                        // $button.attr('type', 'button');
                        // $button.prop('disabled', true);
                        $button.find('.btn-text').text('Update Cart');
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            // Parse and show clean error message
                            let res = JSON.parse(xhr.responseText);
                            toastr.warning(res.message || 'Please log in first.');

                            // Redirect to login after 2 seconds
                            setTimeout(() => {
                                window.location.href = "{{ route('login') }}";
                            }, 2000);
                        } else {
                            // For other types of errors
                            console.error(xhr.responseText);
                            toastr.error('Something went wrong, please try again.');
                        }
                    }
                });
            });
        </script>





        <script>
            // Full-screen carousel functionality
            class FullScreenCarousel {
                constructor() {
                    this.carousel = document.getElementById('fullscreenCarousel');
                    this.slidesWrapper = document.getElementById('fullscreenSlides'); // ✅ separate slides wrapper
                    this.closeBtn = document.getElementById('fullscreenClose');
                    this.prevBtn = document.getElementById('fullscreenPrev');
                    this.nextBtn = document.getElementById('fullscreenNext');
                    this.indicatorsContainer = document.getElementById('fullscreenIndicators');
                    this.slides = [];
                    this.indicators = [];
                    this.currentSlide = 0;
                    this.touchStartX = 0;
                    this.touchEndX = 0;

                    this.initEvents();
                }

                initEvents() {
                    this.closeBtn.addEventListener('click', () => this.hide());
                    this.carousel.addEventListener('click', (e) => {
                        if (e.target === this.carousel) this.hide();
                    });

                    this.prevBtn.addEventListener('click', () => this.prev());
                    this.nextBtn.addEventListener('click', () => this.next());

                    document.addEventListener('keydown', (e) => {
                        if (this.carousel.classList.contains('active')) {
                            if (e.key === 'Escape') this.hide();
                            if (e.key === 'ArrowLeft') this.prev();
                            if (e.key === 'ArrowRight') this.next();
                        }
                    });

                    this.slidesWrapper.addEventListener('touchstart', (e) => {
                        this.touchStartX = e.changedTouches[0].screenX;
                    }, {
                        passive: true
                    });

                    this.slidesWrapper.addEventListener('touchend', (e) => {
                        this.touchEndX = e.changedTouches[0].screenX;
                        this.handleSwipe();
                    }, {
                        passive: true
                    });
                }

                handleSwipe() {
                    const minSwipeDistance = 50;
                    const distance = this.touchStartX - this.touchEndX;

                    if (Math.abs(distance) < minSwipeDistance) return;
                    if (distance > 0) this.next();
                    else this.prev();
                }

                createSlides(images, startIndex) {
                    // ✅ only clear slides + indicators, NOT controls
                    this.slidesWrapper.innerHTML = '';
                    this.indicatorsContainer.innerHTML = '';
                    this.slides = [];
                    this.indicators = [];

                    images.forEach((image, index) => {
                        const slide = document.createElement('div');
                        slide.className = 'fullscreen-slide';
                        slide.innerHTML = `<img src="${image.src}" alt="${image.alt}">`;
                        this.slidesWrapper.appendChild(slide);
                        this.slides.push(slide);

                        const indicator = document.createElement('div');
                        indicator.className = 'fullscreen-indicator';
                        indicator.dataset.index = index;
                        indicator.addEventListener('click', () => this.goToSlide(index));
                        this.indicatorsContainer.appendChild(indicator);
                        this.indicators.push(indicator);
                    });

                    this.currentSlide = startIndex;
                    this.updateSlides();
                }

                updateSlides() {
                    this.slides.forEach((slide, index) => {
                        slide.classList.toggle('active', index === this.currentSlide);
                    });

                    this.indicators.forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === this.currentSlide);
                    });
                }

                goToSlide(index) {
                    if (index < 0) index = this.slides.length - 1;
                    if (index >= this.slides.length) index = 0;
                    this.currentSlide = index;
                    this.updateSlides();
                }

                next() {
                    this.goToSlide(this.currentSlide + 1);
                }
                prev() {
                    this.goToSlide(this.currentSlide - 1);
                }

                show(images, startIndex) {
                    this.createSlides(images, startIndex);
                    this.carousel.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }

                hide() {
                    this.carousel.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            const fullScreenCarousel = new FullScreenCarousel();


            // Image Carousel with Touch Support
            class ImageCarousel {
                constructor(carouselElement) {
                    this.carousel = carouselElement;
                    this.container = carouselElement.querySelector('#carouselContainer');
                    this.indicators = carouselElement.querySelectorAll('.indicator');
                    this.slides = carouselElement.querySelectorAll('.carousel-slide');
                    this.currentSlide = 0;
                    this.slideWidth = 100;
                    this.init();
                }

                init() {
                    this.setupTouchEvents();
                    this.setupIndicators();
                }

                setupTouchEvents() {
                    let startX = 0,
                        currentX = 0,
                        isDragging = false;

                    this.carousel.addEventListener('touchstart', (e) => {
                        startX = e.touches[0].clientX;
                        isDragging = true;
                    });

                    this.carousel.addEventListener('touchmove', (e) => {
                        if (!isDragging) return;
                        e.preventDefault();
                        currentX = e.touches[0].clientX;
                    });

                    this.carousel.addEventListener('touchend', () => {
                        if (!isDragging) return;
                        isDragging = false;
                        const diff = startX - currentX;
                        const threshold = 50;
                        if (diff > threshold && this.currentSlide < this.slides.length - 1) {
                            this.goToSlide(this.currentSlide + 1);
                        } else if (diff < -threshold && this.currentSlide > 0) {
                            this.goToSlide(this.currentSlide - 1);
                        }
                    });
                }

                setupIndicators() {
                    this.indicators.forEach((indicator, index) => {
                        indicator.addEventListener('click', () => this.goToSlide(index));
                    });
                }

                goToSlide(slideIndex) {
                    this.currentSlide = slideIndex;
                    const translateX = -slideIndex * this.slideWidth;
                    this.container.style.transform = `translateX(${translateX}%)`;

                    this.indicators.forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === slideIndex);
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const carousel = new ImageCarousel(document.getElementById('imageCarousel'));
                const carouselSlides = document.querySelectorAll('.carousel-slide');
                const images = [];

                carouselSlides.forEach((slide, index) => {
                    const img = slide.querySelector('img');
                    images.push({
                        src: img.src,
                        alt: img.alt
                    });
                    slide.style.cursor = 'pointer';
                    slide.addEventListener('click', () => {
                        fullScreenCarousel.show(images, index);
                    });
                });

                const mainProductImage = document.querySelector('.product-image');
                if (mainProductImage) {
                    mainProductImage.style.cursor = 'pointer';
                    mainProductImage.addEventListener('click', () => {
                        fullScreenCarousel.show(images, 0);
                    });
                }

                const minusBtn = document.querySelector('.quantity-btn.minus');
                const plusBtn = document.querySelector('.quantity-btn.plus');
                const quantityInput = document.querySelector('.quantity-input');

                if (minusBtn && plusBtn && quantityInput) {
                    minusBtn.addEventListener('click', () => {
                        const currentValue = parseInt(quantityInput.value);
                        if (currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                        }
                    });

                    plusBtn.addEventListener('click', () => {
                        const currentValue = parseInt(quantityInput.value);
                        const maxValue = parseInt(quantityInput.getAttribute('max'));
                        if (currentValue < maxValue) {
                            quantityInput.value = currentValue + 1;
                        }
                    });
                }
            });

            $(document).ready(function() {
                function numberFormat(number, decimals = 0) {
                    return new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: decimals,
                        maximumFractionDigits: decimals,
                    }).format(number);
                }

                $('.getSizePrice').change(function() {
                    var productPrice = '<?php echo $product->new_price; ?>';
                    var price = $('option:selected', this).attr('data-price');
                    let total = parseFloat(productPrice) + parseFloat(price);
                    $('.product-price').html('₦' + numberFormat(total));
                });

                setTimeout(function() {
                    dismissAlert();
                }, 3000);
            });

            function toggleSection(header) {
                const content = header.nextElementSibling;
                const icon = header.querySelector('.expand-icon');
                content.classList.toggle('active');
                icon.classList.toggle('rotated');
            }

            function scrollToMessage() {
                document.querySelector('.message-section').scrollIntoView({
                    behavior: 'smooth'
                });
            }

            function dismissAlert() {
                const alert = document.getElementById('autoDismissAlert');
                if (alert) {
                    alert.style.animation = 'fadeOut 0.5s ease-out';
                    setTimeout(() => alert.remove(), 500);
                }
            }

            function generateStarRating(rating) {
                const maxStars = 5;
                let starsHTML = '';
                for (let i = 1; i <= maxStars; i++) {
                    if (i <= Math.floor(rating)) {
                        starsHTML += `<span class="material-symbols-outlined">star</span>`;
                    } else if (i === Math.ceil(rating) && rating % 1 >= 0.5) {
                        starsHTML += `<span class="material-symbols-outlined">star_half</span>`;
                    } else {
                        starsHTML += `<span class="material-symbols-outlined text-muted">star</span>`;
                    }
                }
                return starsHTML;
            }


            function fetchAndDisplayReviews() {
                const productId = new URLSearchParams(window.location.search).get('product_id');

                if (!productId) {
                    console.error('Product ID is missing.');
                    return;
                }

                $.ajax({
                    url: `../../reviews/get_reviews.php?product_id=${productId}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(reviews) {
                        console.log('Getting reviews...');

                        const reviewsContainer = $('#reviews-container');
                        reviewsContainer.empty();

                        if (reviews.length === 0) {
                            reviewsContainer.html(
                                '<p class="text-muted text-center py-3">No reviews available yet.</p>');
                            return;
                        }

                        // Show only first 3 reviews initially
                        const reviewsToShow = reviews.slice(0, 3);

                        reviewsToShow.forEach(review => {
                            const reviewDiv = `
                    <div class="review-item">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-name">${review.reviewer_name || 'Anonymous'}</div>
                                <div class="review-rating">
                                    ${generateStarRating(review.rating)}
                                </div>
                            </div>
                            <div class="review-date">
                                ${new Date(review.review_date).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit'
                        })}
                            </div>
                        </div>
                        <div class="review-content">
                            ${review.review_text || 'No review text provided.'}
                        </div>
                    </div>
                `;
                            reviewsContainer.append(reviewDiv);
                        });

                        // Show "View All Reviews" button if there are more than 3 reviews
                        if (reviews.length > 3) {
                            const viewAllBtn = `
                    <button class="view-all-reviews mt-3" onclick="showAllReviews(${productId})">
                        View All ${reviews.length} Reviews
                    </button>
                `;
                            reviewsContainer.append(viewAllBtn);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching reviews:', error);
                        $('#reviews-container').html(
                            '<p class="text-danger text-center py-3">Error loading reviews.</p>');
                    }
                });
            }

            function showAllReviews(productId) {
                window.location.href = `../../show-reviews.php?product_id=${productId}`;
            }

            // Initialize reviews when document is ready
            $(document).ready(function() {
                fetchAndDisplayReviews();
            });

            fetchAndDisplayReviews();
        </script>
        <script>
            $(document).ready(function() {
                $('#theForm').on('submit', function() {
                    var $btn = $(this).find('.spin-btn');
                    var $spinner = $btn.find('.spinner-border');
                    var $text = $btn.find('.btn-text');

                    // Disable button to prevent multiple submissions
                    $btn.prop('disabled', true);
                    $text.addClass('d-none'); // hide text
                    $spinner.removeClass('d-none'); // show spinner

                    // Let the form continue submitting normally
                });
            });
        </script>
    @endsection
