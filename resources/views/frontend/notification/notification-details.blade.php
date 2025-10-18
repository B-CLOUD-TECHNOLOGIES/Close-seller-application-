<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - CloseSeller</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/706f90924a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('users/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('users/assets/css/notifications.css') }}" />

</head>

<body>
    <div class="product_heading">
        <button onclick="window.location.href='{{ route('notifications') }}'">
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K"
                alt="Back" />
        </button>
        <h1>Notifications</h1>
        <p>&nbsp;</p>
    </div>

    <!-- Mark All as Read -->
    <div class="back-to-notifications">
        <a href="{{ route('notifications') }}" class="back-link">
            Back to all notifications
        </a>
    </div>

    <!-- Notification Content -->
    <div class="notification-container">
        <!-- Status Indicator -->
        <div class="notification-status">
            Read
        </div>

        <!-- Header -->
        <div class="notification-header notification-type-order">
            <div class="notification-icon">
                📦
            </div>

            <h1 class="notification-title">{{ $notify->title }}</h1>

            <div class="notification-meta">
                <span class="notification-date">
                    {{ \Carbon\Carbon::parse($notify->created_at)->format('M d, Y') }}
                </span>
                <span class="notification-time">
                    {{ \Carbon\Carbon::parse($notify->created_at)->format('g:iA') }}
                </span>
                <span class="notification-badge">
                    New
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="notification-content">
            <div class="notification-message">
                {{ $notify->message }}
            </div>
        </div>

        <!-- Actions -->
        @if (!empty($notify->url))
            <div class="notification-actions">
                <a href="{{ $notify->url }}" class="action-button">
                    View
                </a>
            </div>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth entrance animation
            const container = document.querySelector('.notification-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';

            setTimeout(() => {
                container.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);

            // Add interaction feedback for action button
            const actionButton = document.querySelector('.action-button');
            if (actionButton) {
                actionButton.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-2px) scale(1)';
                    }, 150);
                });
            }

            // Auto-hide the "New" badge after a few seconds
            setTimeout(() => {
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    badge.style.transition = 'opacity 0.5s ease';
                    badge.style.opacity = '0.5';
                }
            }, 3000);
        });

        // Add smooth scrolling for better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
