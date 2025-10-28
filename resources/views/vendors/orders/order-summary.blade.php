@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/summarystyle.css') }}" />

<main style="margin-bottom: 100px;">
    <!-- Header -->
    <div class="order-head">
        <a class="arrow-back-a" href="javascript:history.back()">
            <svg class="arrow-back" width="20" height="20" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#460475" />
            </svg>
        </a>
        <div class="search-bar"><span>Order Summary</span></div>
        <div style="width: 44px;"></div>
    </div>

    <!-- Order Statistics -->
    <div class="order-stats">
        <div class="stat-card">
            <div class="stat-number" id="total-orders">0</div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="completed-orders">0</div>
            <div class="stat-label">Delivered</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="inprogress-orders">0</div>
            <div class="stat-label">In Transit</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="cancelled-orders">0</div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>

    {{-- <!-- Filter Tabs -->
    <div class="order-list">
        <ul>
            <li><a class="li-a active" href="#" data-filter="all">All Orders</a></li>
            <li><a class="li-a inactive" href="#" data-filter="pending">Pending</a></li>
            <li><a class="li-a inactive" href="#" data-filter="inprogress">In Progress</a></li>
            <li><a class="li-a inactive" href="#" data-filter="cancelled">Cancelled</a></li>
            <li><a class="li-a inactive" href="#" data-filter="cancelled">Cancelled</a></li>
            <li><a class="li-a inactive" href="#" data-filter="cancelled">Cancelled</a></li>
        </ul>
    </div> --}}
    {{-- <div class="order-list">
        <ul>
            <li><a class="li-a active" href="#" data-filter="all">All</a></li>
            <li><a class="li-a inactive" href="#" data-filter="pending">Pending</a></li>
            <li><a class="li-a inactive" href="#" data-filter="processing">Processing</a></li>
            <li><a class="li-a inactive" href="#" data-filter="dispatched">Dispatched</a></li>
            <li><a class="li-a inactive" href="#" data-filter="delivered">Delivered</a></li>
            <li><a class="li-a inactive" href="#" data-filter="cancelled">Cancelled</a></li>
        </ul>
    </div> --}}

    <!-- Orders List -->
    <div class="order-item-detail-all" id="all-orders"></div>
</main>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('all-orders');
    const filterLinks = document.querySelectorAll('.li-a');

    let orders = []; // store orders globally

    try {
        const response = await fetch("{{ route('vendor.fetch.order-items', $order->id) }}");
        const data = await response.json();

        // 🟢 Update stats
        document.getElementById('total-orders').textContent = data.stats.total;
        document.getElementById('completed-orders').textContent = data.stats.completed;
        document.getElementById('inprogress-orders').textContent = data.stats.inprogress;
        document.getElementById('cancelled-orders').textContent = data.stats.cancelled;

        orders = data.orders;

        if (orders.length === 0) {
            container.innerHTML = `<p style="text-align:center; color:gray;">No orders found.</p>`;
            return;
        }

        renderOrders('all');

    } catch (error) {
        container.innerHTML = `<p style="text-align:center; color:red;">Error loading orders.</p>`;
        console.error(error);
    }

    // 🧩 Filter handler
    filterLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const filter = link.getAttribute('data-filter');

            // Update active state
            filterLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            renderOrders(filter);
        });
    });

    // 🧩 Function to render orders based on filter
    // 🧩 Render Orders Function
    function renderOrders(filter) {
        let filtered = [];

        switch (filter) {
            case 'pending':
                filtered = orders.filter(o => o.status.toLowerCase() === 'pending');
                break;
            case 'processing':
                filtered = orders.filter(o => o.status.toLowerCase() === 'processing');
                break;
            case 'dispatched':
                filtered = orders.filter(o => o.status.toLowerCase() === 'dispatched');
                break;
            case 'delivered':
                filtered = orders.filter(o => o.status.toLowerCase() === 'delivered');
                break;
            case 'cancelled':
                filtered = orders.filter(o => o.status.toLowerCase() === 'cancelled');
                break;
            default:
                filtered = orders;
        }

        if (filtered.length === 0) {
            container.innerHTML = `<p style="text-align:center; color:gray;">No ${filter} orders found.</p>`;
            return;
        }

       container.innerHTML = filtered.map(order => `
            <div class="order-detail" data-status="${order.status.toLowerCase()}">
                <div class="order-item">
                    <img class="order-item-img" src="${order.image}" alt="${order.product_name}">
                    <div class="quantity-badge">${order.quantity}</div>
                </div>
                <div class="order-item-info">
                    <div class="order-item-detail">
                        <p class="order-item-name">${order.product_name}</p>
                        <span class="order-item-category">${order.category}</span>
                        <div class="order-item-cost">
                            <span class="naira-svg">₦</span>
                            <p>${order.price}</p>
                        </div>
                        <p class="order-item-buyer-name">Buyer: ${order.buyer}</p>
                        <p class="order-item-id">Order ID: <span class="order-item-id-code">#${order.order_no}</span></p>
                    </div>
                    <div class="order-item-status">
                        <p class="order-item-status-text status-${order.status_class}">${order.status}</p>
                        ${order.status !== 'Cancelled' ? 
                            `<a class="order-item-status-btn" href="${'{{ url('/vendors/order') }}'}/${order.id}">View Details</a>` 
                            : ''
                        }
                    </div>
                </div>
            </div>
        `).join('');
    }
});
</script>


@include('vendors.body.footer')
@endsection
