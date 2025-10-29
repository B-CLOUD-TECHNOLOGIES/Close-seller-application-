@extends('vendors.vendor-masters')
@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/orderDispatched.css') }}" />

<main>
    <!-- Header -->
    <div class="order-head">
        <a class="arrow-back-a" href="javascript:history.back()">
            <svg class="arrow-back" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#701d9d" />
            </svg>
        </a>
        <div class="head-text">
            <p class="head-text-order">Order Details</p>
        </div>
    </div>

    <!-- Order Details Card -->
    <div class="order-detail fadeIn">
        <div class="order-card-header">
            <div id="statusBadge" class="order-status-badge">
                <span class="material-symbols-outlined" style="font-size: 14px;">local_shipping</span>
                @php
                    $statusText = match($order->status) {
                        1 => 'Processing',
                        2 => 'Dispatched',
                        3 => 'Delivered',
                        default => 'Pending'
                    };
                @endphp
                {{ $statusText }}
            </div>
            <div id="orderNo" class="order-id">#{{ $order->order_no }}</div>
        </div>

        <div class="order-content">
           <div class="order-item-section">
                <div class="order-item-img-container">
                    <img class="order-item-img"
                        src="{{ asset($item->product->getImage->first()->image_name ?? 'default-product.png') }}"
                        alt="{{ $item->product->product_name }}">
                </div>
                <div class="order-item-info">
                    <h3 class="order-item-name">{{ $item->product->product_name }}</h3>
                    <div class="order-price">
                        <span class="naira-symbol">₦</span>
                        <span>{{ number_format($item->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="order-details-grid">
                <div class="detail-item">
                    <span class="detail-label">Buyer Name</span>
                    <span class="detail-value">{{ $order->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date Ordered</span>
                    <span class="detail-value">{{ $order->created_at->format('d/m/Y') }}</span>
                </div>
                {{-- Show color only if available --}}
                @if(!empty($item->color_name))
                    <div class="detail-item">
                        <span class="detail-label">Color</span>
                        <span class="detail-value">{{ $item->color_name }}</span>
                    </div>
                @endif

                {{-- Show size only if available --}}
                @if(!empty($item->size_name))
                    <div class="detail-item">
                        <span class="detail-label">Size</span>
                        <span class="detail-value">{{ $item->size_name }}</span>
                    </div>
                @endif

                {{-- Show size amount only if greater than 0 --}}
                @if(!empty($item->size_amount) && $item->size_amount > 0)
                    <div class="detail-item">
                        <span class="detail-label">Size Amount</span>
                        <span class="detail-value">₦{{ number_format($item->size_amount, 2) }}</span>
                    </div>
                @endif
                <div class="detail-item">
                    <span class="detail-label">Quantity</span>
                    <span class="detail-value">{{ $item->quantity ?? 0 }}</span>
                </div> 
            </div>

            <div class="order-details-grid mt-3">
                <div class="detail-item">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">{{ ucfirst($order->payment_method) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Delivery Address</span>
                    <span class="detail-value">{{ $fullAddress }}</span>
                </div>
            </div>
            <div class="total-amount">
                <div class="label">Total Amount</div>
                <div id="totalAmount" class="amount">₦{{ number_format($item->total_price, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Order Tracking -->
    <div class="order-tracking fadeIn">
        <div class="tracking-header">
            <div class="tracking-icon">
                <span class="material-symbols-outlined" style="font-size: 16px;">timeline</span>
            </div>
            <h2>Order Tracking</h2>
        </div>

        <!-- Dispatch Step -->
        <div id="dispatchStep" class="tracking-step {{ $order->status >= 2 ? 'completed' : 'active pulse' }}">
            <div class="step-content">
                <div class="step-header">
                    <div class="step-icon dispatch">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <div class="step-info">
                        <h3>Ready for Dispatch</h3>
                        <p>Please confirm if order has been dispatched</p>
                    </div>
                </div>

                @if($order->status < 2)
                    <a href="#confirm-dispatch" class="step-button" id="btnOpenDispatchModal">Confirm Dispatch</a>
                @else
                    <button class="step-button" disabled>Dispatched</button>
                @endif
            </div>
        </div>

        <div class="step-connector">
            <div id="connectorLine" class="connector-line {{ $order->status >= 3 ? 'active' : '' }}"></div>
        </div>

        <!-- Delivery Step -->
        <div id="deliveryStep" class="tracking-step {{ $order->status == 3 ? 'completed' : '' }}">
            <div class="step-content">
                <div class="step-header">
                    <div class="step-icon delivery">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    <div class="step-info">
                        <h3>Order Delivered</h3>
                        <p>Please confirm if order has been delivered</p>
                    </div>
                </div>

                @if($order->status == 2)
                    <a href="#confirm-delivery" class="step-button" id="btnOpenDeliveryModal">Confirm Delivery</a>
                @elseif($order->status == 3)
                    <button class="step-button" disabled>Delivered</button>
                @else
                    <button class="step-button" disabled>Awaiting Dispatch</button>
                @endif
            </div>
        </div>

        @if($order->status == 3)
            <div id="deliveryConfirmation" class="delivery-confirmation fadeIn">
                <span class="material-symbols-outlined">check_circle</span>
                <div style="font-weight: 600; font-size: 16px;">Delivery Confirmed!</div>
                <div style="font-size: 14px; opacity: 0.9; margin-top: 4px;">Order completed successfully</div>
            </div>
        @endif
    </div>

    <!-- Order History -->
    <div class="order-history fadeIn" style="margin-top:20px;">
        <div class="tracking-header">
            <div class="tracking-icon">
                <span class="material-symbols-outlined" style="font-size: 16px;">history</span>
            </div>
            <h2>Order History</h2>
        </div>

        <div id="historyContainer">
            @if($tracking->count())
                <ul class="history-timeline" id="historyTimeline">
                    @foreach($tracking as $t)
                        <li class="history-item" data-status="{{ $t->status }}">
                            <div class="history-status">
                                {{ $t->status == 1 ? 'Placed' : ($t->status == 2 ? 'Dispatched' : ($t->status == 3 ? 'Completed' : 'Unknown')) }}
                            </div>
                            <div class="history-time">{{ $t->created_at->format('d M, Y h:i A') }}</div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="text-align:center; color:gray;">No history available.</p>
            @endif
        </div>
    </div>

    <!-- Dispatch Confirmation Modal -->
    <div id="confirm-dispatch" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <span class="material-symbols-outlined">local_shipping</span>
                    <h3>Confirm Dispatch</h3>
                </div>
                <p>Are you sure you want to confirm that this order has been dispatched?</p>
            </div>
            <div class="modal-actions">
                <a href="#" class="modal-btn cancel" onclick="closeModal()">Cancel</a>
                <button id="confirmDispatchBtn" class="modal-btn confirm">Yes, Confirm</button>
            </div>
        </div>
    </div>

    <!-- Delivery Confirmation Modal -->
    <div id="confirm-delivery" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-outlined">done_all</span>
                <h3>Confirm Delivery</h3>
                <p>Are you sure you want to confirm that this order has been delivered?</p>
            </div>
            <div class="modal-actions">
                <a href="#" class="modal-btn cancel" onclick="closeModal()">Cancel</a>
                <button id="confirmDeliveryBtn" class="modal-btn confirm">Yes, Delivered</button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success" class="modal success-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-outlined">celebration</span>
                <h3>Congratulations!</h3>
                <p>Order has been successfully completed and delivered</p>
            </div>
            <a href="{{ route('vendor.orders.order-index') }}" class="modal-btn success-btn">Back to Orders</a>
        </div>
    </div>
</main>

<script>
    const orderId = {{ $order->id }};
    const csrf = "{{ csrf_token() }}";

    // open modal by id (sets hash to use :target style if desired)
    function openModalById(id) {
        // set hash so CSS modal:target shows it, also keep reference for JS
        location.hash = id;
        // also ensure modal displays if user doesn't use :target styles
        const el = document.getElementById(id.replace('#',''));
        if (el) el.style.display = 'flex';
    }

    function closeModal() {
        // clear hash
        history.pushState("", document.title, window.location.pathname + window.location.search);
        // hide modals
        document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
    }

    // hook buttons that open modals (anchors already point to hash)
    document.getElementById('btnOpenDispatchModal')?.addEventListener('click', (e) => {
        e.preventDefault();
        openModalById('#confirm-dispatch');
    });
    document.getElementById('btnOpenDeliveryModal')?.addEventListener('click', (e) => {
        e.preventDefault();
        openModalById('#confirm-delivery');
    });

    // confirm dispatch
    document.getElementById('confirmDispatchBtn')?.addEventListener('click', async (e) => {
        e.preventDefault();
        await performStatusUpdate(2); // 2 = Dispatched
    });

    // confirm delivery
    document.getElementById('confirmDeliveryBtn')?.addEventListener('click', async (e) => {
        e.preventDefault();
        await performStatusUpdate(3); // 3 = Completed / Delivered
    });

    async function performStatusUpdate(statusToSet) {
        try {
            // disable buttons to avoid double clicks
            document.querySelectorAll('.modal .modal-btn').forEach(b => b.disabled = true);

            const res = await fetch("{{ route('vendor.order.update-item-status', ['id' => $item->id]) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: statusToSet })
            });

            const body = await res.json();

            if (!res.ok) {
                alert(body.message || 'Failed to update order');
                closeModal();
                document.querySelectorAll('.modal .modal-btn').forEach(b => b.disabled = false);
                return;
            }

            // success - update UI in place
            updateUIAfterStatusChange(statusToSet, body.message || 'Updated successfully');

            // close modals and show success for delivered
            closeModal();

            if (statusToSet === 3) {
                // show success modal briefly
                document.getElementById('success').style.display = 'flex';
                setTimeout(() => {
                    // optional auto-hide:
                    // document.getElementById('success').style.display = 'none';
                }, 2500);
            }

        } catch (err) {
            console.error(err);
            alert('An error occurred. Try again.');
            closeModal();
        } finally {
            document.querySelectorAll('.modal .modal-btn').forEach(b => b.disabled = false);
        }
    }

    function updateUIAfterStatusChange(status, message) {
        // 1 Processing, 2 Dispatched, 3 Completed
        const badge = document.getElementById('statusBadge');
        const dispatchStep = document.getElementById('dispatchStep');
        const deliveryStep = document.getElementById('deliveryStep');
        const connectorLine = document.getElementById('connectorLine');

        if (status === 2) {
    // ✅ Update the status badge
    badge.innerHTML = `
        <span class="material-symbols-outlined" style="font-size: 14px;">local_shipping</span>
        Dispatched
    `;
    badge.style.background = "rgba(0, 123, 255, 0.12)";
    badge.style.color = "#007bff";

    // ✅ Mark dispatch step as completed and lock the button
    dispatchStep.classList.remove('active', 'pulse');
    dispatchStep.classList.add('completed');

    const dispatchBtn = dispatchStep.querySelector('.step-button');
    if (dispatchBtn) {
        dispatchBtn.outerHTML = `<button class="step-button" disabled>Dispatched</button>`;
    }

    // ✅ Activate delivery step
    deliveryStep.classList.remove('completed');
    deliveryStep.classList.add('active', 'pulse');

    const deliveryBtn = deliveryStep.querySelector('.step-button');
    if (deliveryBtn) {
        deliveryBtn.removeAttribute('disabled');
        deliveryBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModalById('#confirm-delivery');
        });
    }

    // ✅ Update order history section
    appendHistoryItem(2);

    // ✅ Provide quick visual feedback
    console.log("Order dispatched successfully.");
}
        // small toast/alert (you can replace with nicer toast)
        if (message) {
            // simple in-page notification: alert — replace with your toaster if available
            // alert(message);
            console.log(message);
        }
    }

    function appendHistoryItem(status) {
        const map = {1:'Placed',2:'Dispatched',3:'Completed'};
        const now = new Date();
        const formatted = now.toLocaleString(undefined, { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
        const li = document.createElement('li');
        li.className = 'history-item';
        li.dataset.status = status;
        li.innerHTML = `<div class="history-status">${map[status] ?? 'Unknown'}</div><div class="history-time">${formatted}</div>`;

        const timeline = document.getElementById('historyTimeline');
        if (timeline) {
            timeline.appendChild(li);
        } else {
            const container = document.getElementById('historyContainer');
            container.innerHTML = `<ul class="history-timeline" id="historyTimeline"></ul>`;
            document.getElementById('historyTimeline').appendChild(li);
        }
    }

    // close modal when clicking outside (same behavior as your previous code)
    document.addEventListener('click', (e) => {
        if (e.target.classList && e.target.classList.contains('modal')) {
            closeModal();
        }
    });

    // initialize modal visibility for :target fallback
    document.querySelectorAll('.modal').forEach(m => {
        // if browser navigated to hash (so user clicked anchor), show it
        if (location.hash && location.hash === '#' + m.id) {
            m.style.display = 'flex';
        }
    });
</script>
@endsection
