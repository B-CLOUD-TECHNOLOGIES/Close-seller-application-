@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/order-index.css') }}" />

<main>
  <!-- Header -->
  <div class="order-head">
    <a class="arrow-back-a" href="javascript:history.back()">
      <svg class="arrow-back" width="20" height="20" viewBox="0 0 24 24" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
          fill="#460475" />
      </svg>
    </a>
    <div class="search-bar">
      <span>All Orders</span>
    </div>
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
      <div class="stat-label">Completed</div>
    </div>
    <div class="stat-card">
      <div class="stat-number" id="inprogress-orders">0</div>
      <div class="stat-label">In Progress</div>
    </div>
    <div class="stat-card">
      <div class="stat-number" id="processing-orders">0</div>
      <div class="stat-label">Processing</div>
    </div>
    <div class="stat-card">
      <div class="stat-number" id="cancelled-orders">0</div>
      <div class="stat-label">Cancelled</div>
    </div>
  </div>

  <!-- Filter Tabs -->
  <div class="order-list">
    <ul>
      <li><a class="li-a active" href="#" data-filter="all">All</a></li>
      <li><a class="li-a inactive" href="#" data-filter="Completed">Completed</a></li>
      <li><a class="li-a inactive" href="#" data-filter="In Progress">In Progress</a></li>
      <li><a class="li-a inactive" href="#" data-filter="Processing">Processing</a></li>
      <li><a class="li-a inactive" href="#" data-filter="Cancelled">Cancelled</a></li>
    </ul>
  </div>

  <!-- Orders List -->
  <div class="order-item-detail-all" id="all-orders"></div>

  <!-- Empty State -->
  <div class="empty-state hidden" id="empty-state">
    <div class="empty-state-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm10 16H4V8h16v12z"
          fill="#701d9d" />
      </svg>
    </div>
    <h3 class="empty-state-title">No Orders Found</h3>
    <p class="empty-state-message">There are no orders matching your current filter selection.</p>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const ordersContainer = document.getElementById('all-orders');
  const emptyState = document.getElementById('empty-state');
  const filterLinks = document.querySelectorAll('.li-a');

  // Fetch orders
  fetch("{{ route('vendor.fetch.orders') }}")
    .then(res => res.json())
    .then(data => {
      renderStats(data.stats);
      renderOrders(data.orders);
      setupFilters();
    })
    .catch(err => console.error('Error fetching orders:', err));

  // Render stats
  function renderStats(stats) {
    document.getElementById('total-orders').textContent = stats.total;
    document.getElementById('completed-orders').textContent = stats.completed;
    document.getElementById('inprogress-orders').textContent = stats.inprogress;
    document.getElementById('processing-orders').textContent = stats.processing;
    document.getElementById('cancelled-orders').textContent = stats.cancelled;
  }

  // Render order cards
  function renderOrders(orders) {
  ordersContainer.innerHTML = '';

  if (orders.length === 0) {
    emptyState.classList.remove('hidden');
    return;
  }

  orders.forEach(order => {
    const card = document.createElement('div');
    card.className = 'order-card';
    card.setAttribute('data-status', order.status.toLowerCase());

    // Format date (optional — ensures readable format)
    const formattedDate = new Date(order.created_at).toLocaleDateString('en-US', {
      month: 'long',
      day: 'numeric',
      year: 'numeric'
    });

    // Format numbers with commas
    const formatCurrency = num => new Intl.NumberFormat('en-NG', {
      style: 'currency',
      currency: 'NGN',
      minimumFractionDigits: 0
    }).format(num);

    // Payment badge based on payment_status
    const paymentBadge =
      order.payment_status === 'paid'
        ? `
        <span class="payment-badge paid">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"
              fill="currentColor"/>
          </svg>
          Paid
        </span>`
        : `
        <span class="payment-badge unpaid">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10
            10-4.48 10-10S17.52 2 12 2zm0 17.93C7.06
            19.43 4 15.36 4 12c0-4.42 3.58-8 8-8s8
            3.58 8 8c0 3.36-3.06 7.43-8 7.93zM11
            6h2v6h-2zm0 8h2v2h-2z" fill="currentColor"/>
          </svg>
          Unpaid
        </span>`;

    card.innerHTML = `
      <div class="order-header">
        <div class="order-id-section">
          <div class="order-id">Order <span class="order-id-code">#${order.order_no}</span></div>
          <div class="order-date">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M19 4H5C3.9 4 3 4.9 3 6V20C3 21.1
              3.9 22 5 22H19C20.1 22 21 21.1
              21 20V6C21 4.9 20.1 4 19
              4ZM19 20H5V10H19V20ZM19 8H5V6H19V8Z"
              fill="currentColor"/>
            </svg>
            ${formattedDate}
          </div>
        </div>
        <div class="order-status-badge status-${order.status.toLowerCase()}">
          ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
        </div>
      </div>

      <div class="order-body">
        <div class="order-info-item">
          <span class="info-label">Total Amount</span>
          <span class="info-value price">${formatCurrency(order.total_amount)}</span>
        </div>
        <div class="order-info-item">
          <span class="info-label">Items</span>
          <span class="info-value">${order.total_items} Products</span>
        </div>
        <div class="order-info-item">
          <span class="info-label">Payment</span>
          ${paymentBadge}
        </div>
        <div class="order-info-item">
          <span class="info-label">Shipping</span>
          <span class="info-value">${formatCurrency(order.shipping_fee)}</span>
        </div>
      </div>

      <div class="order-footer">
        <div class="customer-info">
          Customer: <span class="customer-name">${order.buyer}</span>
        </div>
        <a href="/vendors/order-summary/${order.id}" class="view-details-btn">
          View Details
        </a>
      </div>
    `;

    ordersContainer.appendChild(card);
  });

  emptyState.classList.add('hidden');
}


  // Filter functionality
  function setupFilters() {
    const orderCards = document.querySelectorAll('.order-card');
    filterLinks.forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();

        filterLinks.forEach(l => {
          l.classList.remove('active');
          l.classList.add('inactive');
        });
        this.classList.add('active');

        const filter = this.dataset.filter;
        let visibleCount = 0;

        orderCards.forEach(card => {
          if (filter === 'all' || card.dataset.status === filter) {
            card.classList.remove('hidden');
            visibleCount++;
          } else {
            card.classList.add('hidden');
          }
        });

        if (visibleCount === 0) {
          emptyState.classList.remove('hidden');
        } else {
          emptyState.classList.add('hidden');
        }
      });
    });
  }
});
</script>
@endsection
