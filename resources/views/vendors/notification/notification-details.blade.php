@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/notifications.css') }}" />

@php
    use Illuminate\Support\Carbon;
@endphp

<!-- Header -->
<div class="product_heading">
    <button onclick="window.history.back()">
        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="Back" />
    </button>
    <h1>Notification</h1>
    <p>&nbsp;</p>
</div>

<!-- Back to Notifications -->
<div class="back-to-notifications">
    <a href="{{ route('vendor.notifications') }}" class="back-link">
        ← Back to all notifications
    </a>
</div>

<!-- Notification Content -->
<div class="notification-container">
    <!-- Status Indicator -->
    <div class="notification-status">
        {{ $notification->is_read ? 'Read' : 'Unread' }}
    </div>

    <!-- Header -->
    <div class="notification-header notification-type-order">
        <div class="notification-icon">
            @if($notification->type === 'order')
                📦
            @elseif($notification->type === 'review')
                ⭐
            @elseif($notification->type === 'system')
                ⚙️
            @else
                🔔
            @endif
        </div>
        
        <h1 class="notification-title">{{ $notification->title }}</h1>
        
        <div class="notification-meta">
            <span class="notification-date">
                {{ Carbon::parse($notification->created_at)->format('M d, Y') }}
            </span>
            <span class="notification-time">
                {{ Carbon::parse($notification->created_at)->format('h:i A') }}
            </span>

            @if(!$notification->is_read)
                <span class="notification-badge">New</span>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="notification-content">
        <div class="notification-message">
            {{ $notification->message }}
        </div>
    </div>

    <!-- Action -->
    @if($notification->action_url)
        <div class="notification-actions">
            <a href="{{ $notification->action_url }}" target="_blank" class="action-button">
                Take Action
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.notification-container');
    container.style.opacity = '0';
    container.style.transform = 'translateY(20px)';

    setTimeout(() => {
        container.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
    }, 100);

    // Animate button
    const actionButton = document.querySelector('.action-button');
    if (actionButton) {
        actionButton.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'translateY(-2px) scale(1)';
            }, 150);
        });
    }

    // Auto fade out badge
    setTimeout(() => {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.style.transition = 'opacity 0.5s ease';
            badge.style.opacity = '0.5';
        }
    }, 3000);
});
</script>
@endsection
