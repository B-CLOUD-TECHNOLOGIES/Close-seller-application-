@extends('vendors.vendor-masters')
@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/index.css') }}" />
      <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center fade-in">
            <h1>Welcome {{ ucfirst($vendor->firstname) }} 👋 </h1>
            <button class="settings-btn" onclick="window.location.href='{{ route('vendor.settings') }}'">
                <i class="fas fa-cog"></i>
            </button>
        </div>

        <div class="container-fluid px-3">
            <!-- Stats Row -->
            <div class="row stats-row fade-in">
                <div class="col-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-value" id="todayRevenue">₦0</div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up stat-icon"></i>
                            ₦<span id="revenueChange">0</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-value text-warning" id="pendingOrders">0</div>
                        <div class="stat-label">Pending Orders</div>
                        <div class="stat-change warning">
                            <i class="fas fa-clock stat-icon"></i>
                            <span id="pendingChange">This Month</span>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="stat-card">
                        <div class="stat-value" id="totalProducts">0</div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-change positive">
                            <i class="fas fa-box stat-icon"></i>
                            Active
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="stat-card">
                        <div class="stat-value text-info" id="messages">0</div>
                        <div class="stat-label">Messages</div>
                        <div class="stat-change">
                            <i class="fas fa-envelope stat-icon"></i>
                            <span id="unreadMessages">Unread</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions fade-in">
                <h5 class="section-title">Quick Actions</h5>

                <button class="action-btn btn-primary-custom" onclick="window.location.href='{{ route('vendor.add.products') }}'">
                    <i class="fas fa-plus me-2"></i>
                    Add New Product
                </button>

                <button class="action-btn btn-outline-custom" onclick="window.location.href='{{ route('vendor.orders') }}'">
                    <i class="fas fa-list me-2"></i>
                    View All Orders
                </button>

                <button class="action-btn btn-outline-custom" onclick="window.location.href='{{ route('vendor.transactions') }}'">
                    <i class="fas fa-bullhorn me-2"></i>
                    View Transactions
                </button>
            </div>
        </div>

        <!-- Recent Orders -->
        <!-- Recent Orders -->
       <div class="recent-orders fade-in">
                <h5 class="section-title">Recent Orders</h5>

                @forelse ($recentOrders as $order)
                    <div class="order-item">
                        <img 
                            src="{{ optional($order->user)->image 
                                ? asset($order->user->image)
                                : 'https://via.placeholder.com/40' }}" 
                            alt="{{ optional($order->user)->username ?? 'Unknown User' }}" 
                            class="customer-avatar">

                        <div class="customer-info flex-grow-1">
                            <h6>{{ optional($order->user)->username ?? 'Deleted User' }}</h6>
                            <div class="order-id">{{ $order->order_no }}</div>
                        </div>

                        <div class="text-end">
                            <div class="order-amount">₦{{ number_format($order->total_amount ?? 0, 2) }}</div>
                            <span class="badge {{ $order->status_class }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No recent orders found.</p>
                @endforelse
            </div>

            <!-- Product Preview -->
            <div class="product-preview fade-in">
                <h5 class="section-title">Your Products</h5>

                @forelse ($vendorProducts as $product)
                    <div class="product-item" onclick="window.location.href='{{ route('vendor.products') }}'">
                        <img 
                            src="{{ $product->mainImage && $product->mainImage->image_name 
                                ? asset( $product->mainImage->image_name)
                                : 'https://via.placeholder.com/60' }}" 
                            alt="{{ $product->product_name }}" 
                            class="product-image">

                        <div class="product-info flex-grow-1">
                            <h6>{{ $product->product_name }}</h6>
                            <div class="product-sales">
                                {{ $product->sales_count ?? 0 }} sales this month
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                @empty
                    <p class="text-muted">You have no products yet.</p>
                @endforelse
            </div>
                
        </div>
    </div>
 @include('vendors.body.footer') 


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    fetch("{{ route('vendor.index.data') }}")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const stats = data.data;
                document.getElementById("todayRevenue").textContent = "₦" + stats.totalRevenue;
                document.getElementById("pendingOrders").textContent = stats.pendingOrders;
                document.getElementById("totalProducts").textContent = stats.totalProducts;
                document.getElementById("messages").textContent = stats.unreadMessages;
            }
        })
        .catch(err => console.error("Error fetching dashboard data:", err));
});
</script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navigation Functions
               // Add click feedback to stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-2px)';
                }, 100);
            });
        });

        // Add pull-to-refresh functionality
        let startY = 0;
        let currentY = 0;
        let pullDistance = 0;

        document.addEventListener('touchstart', (e) => {
            startY = e.touches[0].pageY;
        });

        document.addEventListener('touchmove', (e) => {
            currentY = e.touches[0].pageY;
            pullDistance = currentY - startY;
            
            if (pullDistance > 100 && window.scrollY === 0) {
                document.querySelector('.header').style.transform = `translateY(${Math.min(pullDistance * 0.3, 30)}px)`;
                document.querySelector('.header').style.opacity = '0.8';
            }
        });

        document.addEventListener('touchend', () => {
            if (pullDistance > 100 && window.scrollY === 0) {
                // Trigger refresh
                location.reload();
            }
            
            // Reset header position
            document.querySelector('.header').style.transform = 'translateY(0)';
            document.querySelector('.header').style.opacity = '1';
            pullDistance = 0;
        });

        // Initialize animations on load
        window.addEventListener('load', () => {
            // Add staggered animation to cards
            const cards = document.querySelectorAll('.fade-in');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Settings button rotation on click
        document.querySelector('.settings-btn').addEventListener('click', function() {
            console.log('Settings clicked');
            this.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                this.style.transform = 'rotate(90deg)';
            }, 200);
            
            // Show settings menu or navigate
            
            // window.location.href = 'settings.php';
        });

        // Add haptic feedback for mobile devices
        function addHapticFeedback(element) {
            element.addEventListener('touchstart', () => {
                if ('vibrate' in navigator) {
                    navigator.vibrate(10);
                }
            });
        }

        // Apply haptic feedback to buttons
        document.querySelectorAll('.action-btn, .nav-item').forEach(addHapticFeedback);
    </script>
    @endsection