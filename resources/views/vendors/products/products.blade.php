@extends('vendors.vendor-masters')

@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/products.css') }}" />

    <div class="header">
        <div class="header-content">
            <a onclick="window.history.back()" class="back-btn">
            <i class="fas fa-arrow-left"></i> <span>Back</span>
            </a>

            <div class="search-container">
            <input type="text" class="search-input" placeholder="Search products..." id="searchInput">
            <i class="fas fa-search search-icon"></i>
            </div>

            <a href="{{ route('vendor.add.products') }}" class="add-product-btn">
            <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <!-- Tabs Container -->
    <div class="tabs-container">
        <!-- Tab Navigation -->
        <div class="tabs-nav">
            <button class="tab-btn active" data-tab="active">
            <i class="fas fa-check-circle tab-icon"></i>
            <span>Active Products</span>
            <span class="tab-badge">{{ count($activeProducts) }}</span>
            </button>

            <button class="tab-btn" data-tab="declined">
            <i class="fas fa-times-circle tab-icon"></i>
            <span>Declined Products</span>
            <span class="tab-badge" style="background: var(--danger-color);">{{ count($declinedProducts) }}</span>
            </button>
        </div>

        <!-- Active Products -->
        <div class="tab-content active" id="active-tab">
            <div class="products-grid">
            @forelse($activeProducts as $product)
            <div class="product-card" 
                data-product-name="{{ strtolower($product->product_name) }}"
                data-product-price="{{ $product->new_price }}"
                data-product-quantity="{{ $product->stock_quantity }}"
                data-product-unit="{{ strtolower($product->unit) }}"
                data-product-location="{{ strtolower($product->location) }}">
                
                <div class="product-main">
                <img src="{{ asset($product->getImage->first()->image_name ?? 'https://via.placeholder.com/150') }}" alt="Product" class="product-image">
                <div class="product-info">
                    <h3 class="product-name">{{ $product->product_name }}</h3>
                    <div class="product-price">₦{{ number_format($product->new_price, 0) }}</div>
                    <div class="product-details">
                    <div class="detail-item"><i class="fas fa-boxes detail-icon"></i> {{ $product->stock_quantity }} quantities</div>
                    <div class="detail-item"><i class="fas fa-weight detail-icon"></i> Unit ({{ $product->unit }})</div>
                    <div class="detail-item"><i class="fas fa-map-marker-alt detail-icon"></i> {{ $product->location }}</div>
                    </div>
                </div>
                </div>

                <div class="product-actions">
                <a href="{{ route('vendor.edit.product', ['productid' => $product->id]) }}" class="action-btn edit-btn">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="action-btn top-btn">
                    <i class="fas fa-arrow-up"></i> Top
                </button>
                </div>
            </div>
            @empty
                <p class="text-center text-muted">No active products found.</p>
            @endforelse
            </div>
        </div>

        <!-- Declined Products -->
        <div class="tab-content" id="declined-tab">
            <div class="products-grid">
            @forelse($declinedProducts as $product)
            <div class="product-card" 
                data-product-name="{{ strtolower($product->product_name) }}"
                data-product-price="{{ $product->new_price }}"
                data-product-quantity="{{ $product->stock_quantity }}"
                data-product-unit="{{ strtolower($product->unit) }}"
                data-product-location="{{ strtolower($product->location) }}">
                
                <div class="product-main">
                <img src="{{ asset($product->getImage->first()->image_name ?? 'https://via.placeholder.com/150') }}" alt="Product" class="product-image">
                <div class="product-info">
                    <h3 class="product-name">{{ $product->product_name }}</h3>
                    <div class="product-price">₦{{ number_format($product->new_price, 0) }}</div>
                    <div class="product-details">
                    <div class="detail-item"><i class="fas fa-boxes detail-icon"></i> {{ $product->stock_quantity }} quantities</div>
                    <div class="detail-item"><i class="fas fa-weight detail-icon"></i> Unit ({{ $product->unit }})</div>
                    <div class="detail-item"><i class="fas fa-map-marker-alt detail-icon"></i> {{ $product->location }}</div>
                    </div>
                </div>
                </div>

                <div class="product-actions">
                <a href="{{ route('vendor.edit.product', ['productid' => $product->id]) }}" class="action-btn edit-btn">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="#" class="action-btn appeal-btn">
                    <i class="fas fa-gavel"></i> Appeal
                </a>
                </div>
            </div>
            @empty
                <p class="text-center text-muted">No declined products found.</p>
            @endforelse
            </div>
        </div>
    </div>
 @include('vendors.body.footer') 
    <script>
        // Tab functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(this.dataset.tab + '-tab').classList.add('active');
        });
        });

        // Search functionality
        let filterTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(() => {
            const searchText = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
            const matches = Object.values(card.dataset).some(value => value.includes(searchText));
            card.style.display = matches ? 'block' : 'none';
            });
        }, 300);
        });
    </script>
@endsection