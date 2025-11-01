@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/transaction-index.css') }}" />
 <!-- Top Bar -->
  <div class="top-bar">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
       <a class="arrow-back-a" href="javascript:history.back()">
            <svg class="arrow-back" width="20" height="20" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
                fill="#460475" />
            </svg>
        </a>
        <h5 class="fw-semibold mb-0" style="color: var(--purple);">Transactions</h5>
      </div>
      <!-- Removed search bar as requested -->
    </div>
  </div>

  <!-- Date Filter Section -->
  <div class="filter-section">
    <h6 class="fw-semibold mb-3">Filter by Date Range</h6>
    <div class="date-filter-container">
      <div class="date-input-group">
        <label for="startDate">Start Date</label>
        <input type="date" id="startDate" class="date-input">
      </div>
      <div class="date-input-group">
        <label for="endDate">End Date</label>
        <input type="date" id="endDate" class="date-input">
      </div>
      <button id="applyFilter" class="apply-filter-btn">
        Apply Filter
      </button>
    </div>
  </div>

  <!-- Transaction List -->
  <div class="transaction-list-container" id="transaction-list"></div>

  <!-- Empty State (hidden by default) -->
  <div class="empty-state hidden" id="empty-state">
    <div class="empty-state-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm10 16H4V8h16v12z" fill="#701d9d"/>
      </svg>
    </div>
    <h3 class="empty-state-title">No Transactions Found</h3>
    <p class="empty-state-message">There are no transactions matching your current filter selection.</p>
  </div>

  <!-- Total Button -->
  <div class="total-section" style="margin-bottom: 100px;">
    <button id="calculateBtn" class="total-btn">
      Total: <span id="totalAmount">₦0.00</span>
    </button>
  </div>
    @include('vendors.body.footer') 

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
        document.addEventListener("DOMContentLoaded", () => {
            const transactionList = document.getElementById('transaction-list');
            const totalAmountSpan = document.getElementById('totalAmount');
            const applyFilterBtn = document.getElementById('applyFilter');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const emptyState = document.getElementById('empty-state');

            let currentList = [];

            async function fetchTransactions(startDate = '', endDate = '') {
                try {
                    const response = await fetch(`/vendors/fetch-transactions?startDate=${startDate}&endDate=${endDate}`);
                    const data = await response.json();

                    if (!data.success) throw new Error(data.message || 'Failed to load');

                    currentList = data.transactions;
                    renderTransactions(currentList);
                    updateTotalAmount(); // ✅ Automatically update total
                } catch (error) {
                    console.error(error);
                }
            }

            function renderTransactions(list) {
                transactionList.innerHTML = '';
                if (list.length === 0) {
                    emptyState.classList.remove('hidden');
                    totalAmountSpan.textContent = '₦0';
                    return;
                }

                emptyState.classList.add('hidden');

                list.forEach(t => {
                    const isCanceled = t.status.toLowerCase().includes('cancel');
                    const card = document.createElement('div');
                    card.className = 'transaction-card';
                    card.innerHTML = `
                        <div class="transaction-header">
                            <div class="transaction-id-section">
                                <div class="transaction-id">
                                    Transaction <span class="transaction-id-code">#${t.transactionId}</span>
                                </div>
                                <div class="transaction-date">${new Date(t.date).toDateString()}</div>
                            </div>
                            <div class="transaction-status-badge ${isCanceled ? 'status-canceled' : 'status-successful'}">
                                ${t.status}
                            </div>
                        </div>
                        <div class="transaction-body">
                            <div class="transaction-info-item">
                                <span class="info-label">Amount</span>
                                <span class="info-value price">₦${t.amount.toLocaleString()}</span>
                            </div>
                            <div class="transaction-info-item">
                                <span class="info-label">Order Id</span>
                                <span class="info-value">${t.orderNo}</span>
                            </div>
                            <div class="transaction-info-item">
                                <span class="info-label">Payment</span>
                                <span class="payment-badge ${t.isPayment ? 'paid' : 'unpaid'}">
                                    ${t.isPayment ? 'Paid' : 'Unpaid'}
                                </span>
                            </div>
                        </div>

                       ${!isCanceled ? `
                        <div class="transaction-footer">
                            <button class="total-btn view-details-btn" data-order-id="${t.orderId}">
                                View Details
                            </button>
                        </div>` : ''}
                    `;
                    transactionList.appendChild(card);
                });

                // Attach event listeners to "View Details" buttons
                document.querySelectorAll('.view-details-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const orderId = e.target.getAttribute('data-order-id');
                        // Navigate to transaction detail page
                        window.location.href = `/vendors/transactions/${orderId}`;
                    });
                });
            }

            // ✅ Auto update total without button click
            function updateTotalAmount() {
                const total = currentList.reduce((sum, t) => sum + t.amount, 0);
                totalAmountSpan.textContent = `₦${total.toLocaleString()}`;
            }

            // Filter handler
            applyFilterBtn.addEventListener('click', () => {
                fetchTransactions(startDateInput.value, endDateInput.value);
            });

            // ✅ Initial load
            fetchTransactions();
        });
</script>

  @endsection
