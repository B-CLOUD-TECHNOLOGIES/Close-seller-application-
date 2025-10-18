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

    <link rel="stylesheet" href="{{ asset('users/assets/css/notification-index.css') }}" />
    <link rel="stylesheet" href="{{ asset('users/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">
</head>

<body>
    <div class="product_heading">
        @if (Auth::guard('web')->check())
            <button onclick="window.location.href='{{ route('user.dashboard') }}'">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K"
                    alt="Back" />
            </button>
        @elseif (Auth::guard('vendor')->check())
            <button onclick="window.location.href='{{ route('vendor.dashboard') }}'">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K"
                    alt="Back" />
            </button>
        @endif




        <h1>Notifications</h1>
        <p>&nbsp;</p>
    </div>

    <!-- Mark All as Read -->
    <div class="mark-all">
        <a href="#" class="mark-link">
            Mark all as read
        </a>
    </div>

    <section class="product_messages spTX" id="notification-list">
        @if ($notifications)
            @foreach ($notifications as $item)
                <a href="{{ route('notifications.details', $item->id) }}">
                    {{-- {{ !empty($item->url) ? $item->url : 'javascript:;' }} --}}
                    <article class="notification-card ${isUnread ? 'notification-unread' : 'notification-read'}">
                        <div class="notification-content">
                            <div class="notification-text">
                                <h1 class="notification-title"
                                    style="{{ $item->is_read == 0 ? 'color:#55048e;font-weight:bolder;' : 'color:grey;' }}">
                                    {{ $item->title }}
                                </h1>
                                <h4 class="notification-message">
                                    {{ Str::limit($item->message, 80) }}
                                </h4>
                            </div>
                            <div class="notification-time">
                                @if ($item->is_read == 0)
                                    <div class="notification-indicator"></div>
                                @endif
                                <h5 class="notification-date">
                                    {{ \Carbon\Carbon::parse($item->created_at)->isToday() ? 'Today' : \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                </h5>

                                <h5 class="notification-hour">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('g:iA') }}
                                </h5>

                            </div>
                        </div>
                    </article>
                </a>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="#701d9d" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="#701d9d" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="empty-state-title">No notifications yet</h3>
                <p class="empty-state-message">When you receive orders, reviews, or important updates, they'll appear
                    here.
                </p>
            </div>


        @endif
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add entrance animations for notification cards
            $('.notification-card').each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                });
                setTimeout(() => {
                    $(this).css({
                        'transition': 'opacity 0.6s ease, transform 0.6s ease',
                        'opacity': '1',
                        'transform': 'translateY(0)'
                    });
                }, index * 100);
            });

            // Add click animation for notification cards
            $('.notification-card').on('click', function() {
                $(this).css('transform', 'scale(0.98)');
                setTimeout(() => {
                    $(this).css('transform', 'translateY(-3px) scale(1)');
                }, 150);
            });
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

        // CSS for loading animation
        const style = document.createElement('style');
        style.textContent = `
          @keyframes spin {
             from { transform: rotate(0deg); }
             to { transform: rotate(360deg); }
          }
       `;
        document.head.appendChild(style);
    </script>
</body>

</html>
