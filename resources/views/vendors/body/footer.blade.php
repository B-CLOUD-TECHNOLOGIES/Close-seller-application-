    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <a href="index.html" class="nav-item d-block">
                        <div class="nav-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="nav-label">Dashboard</div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('vendor.products') }}"
                     class="nav-item d-block {{ request()->routeIs('vendor.products') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="nav-label">Products</div>
                    </a>
                </div>
                <div class="col">
                    <div class="add-border">
                        <a href="{{ route('vendor.add.products') }}" class="nav-item add-btn d-block
                        {{ request()->routeIs('vendor.add.products') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <!-- removed the label here -->
                        </a>
                    </div>
                </div>
                <!-- <div class="col">
                <a href="order-summary.html" class="nav-item d-block position-relative">
                    <div class="nav-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="nav-badge">2</span>
                    </div>
                    <div class="nav-label">Orders</div>
                </a>
            </div> -->
                <div class="col">
                    <a href="chat/inbox.html" class="nav-item d-block position-relative">
                        <div class="nav-icon">
                            <i class="fas fa-envelope"></i>
                            <div class="notification-dot"></div>
                        </div>
                        <div class="nav-label">Messages</div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('vendor.dashboard') }}" class="nav-item d-block position-relative
                    {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas far fa-user-circle"></i>

                        </div>
                        <div class="nav-label">Me</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
