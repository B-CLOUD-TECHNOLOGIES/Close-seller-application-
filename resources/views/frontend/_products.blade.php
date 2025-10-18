                            @php
                                $firstImage = $product->getFirstImage();
                            @endphp

                            <div class="col-6 product-item" data-date="{{ $product->updated_at }}"
                                data-price="{{ $product->new_price }}">
                                <div
                                    class="card new-arrival-card border border-gray-200 rounded-3 overflow-hidden h-100">
                                    <button
                                        class="btn btn-light p-1 position-absolute top-0 end-0 m-2 z-2 rounded-circle"
                                        style="background: rgba(255,255,255,0.7);"
                                        onclick="toggleHeart(this.querySelector('.heart-icon'))">
                                        <i class='heart-icon fa fa-heart-o' style='color: #555;font-size:1rem'></i>
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
                                                    <span class="rating-text">4.6</span>
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
