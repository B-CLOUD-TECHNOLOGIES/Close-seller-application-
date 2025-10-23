                       <button class="btn p-0 position-relative"
                            onclick="window.location.href='{{ route('view.cart') }}'">
                            <span class="material-symbols-outlined text-gray-700">shopping_cart</span>
                                <span
                                    class="cartCount position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange-notification text-white"
                                    style="font-size: 0.5rem; display: {{ $cartCount > 0 ? 'inline-block' : 'none' }}">{{ $cartCount }}
                                </span>
                        </button>