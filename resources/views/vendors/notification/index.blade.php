@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/notification-index.css') }}" />

<div class="product_heading">
   <button onclick="window.location.href='{{ route('vendor.dashboard') }}'">
      <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="Back" />
   </button>
   <h1>Notifications</h1>
   <p>&nbsp;</p>
</div>

<!-- Mark All as Read -->
<div class="mark-all">
   <a href="#" class="mark-link">Mark all as read</a>
</div>

<section class="product_messages spTX" id="notification-list">
   @if ($notifications->isEmpty())
      <div class="empty-state">
         <div class="empty-state-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
               <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"
                     stroke="#701d9d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
               <path d="M13.73 21a2 2 0 0 1-3.46 0"
                     stroke="#701d9d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
         </div>
         <h3 class="empty-state-title">No notifications yet</h3>
         <p class="empty-state-message">
            When you receive orders, reviews, or important updates, they'll appear here.
         </p>
      </div>
   @else
      @foreach ($notifications as $notification)
         <a href="{{ route('vendor.notifications.show', $notification->id) }}">
            <article class="notification-card {{ !$notification->is_read ? 'notification-unread' : 'notification-read' }}">
               <div class="notification-content">
                  <div class="notification-text">
                     <h1 class="notification-title"
                         style="{{ !$notification->is_read ? 'color:#55048e;font-weight:bolder;' : 'color:grey;' }}">
                         {{ $notification->title }}
                     </h1>
                     <h4 class="notification-message">
                         {{ \Illuminate\Support\Str::limit($notification->message, 80) }}
                     </h4>
                  </div>
                  <div class="notification-time">
                     @if (!$notification->is_read)
                        <div class="notification-indicator"></div>
                     @endif
                     <h5 class="notification-date">{{ $notification->created_at->format('M d') }}</h5>
                     <h5 class="notification-hour">{{ $notification->created_at->format('h:ia') }}</h5>
                  </div>
               </div>
            </article>
         </a>
      @endforeach
   @endif
</section>

{{-- <div id="bottombar-placeholder"></div> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
   // AJAX: Mark all as read
   $('.mark-link').on('click', function(e) {
      e.preventDefault();

      fetch("{{ route('vendor.notifications.markAll') }}", {
         method: "POST",
         headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
         }
      })
      .then(res => res.json())
      .then(data => {
         if (data.status === 'success') {
            $('.notification-card').removeClass('notification-unread').addClass('notification-read');
            $('.notification-title').css('color', 'grey').css('font-weight', 'normal');
            $('.notification-indicator').remove();
            custom_alert('success', data.message);
         }
      });
   });

   // Toast notification
   function custom_alert(type, message) {
      $('.toaster_alert').remove();
      let alerthtml = `
         <div class="toaster_alert ${type}">
            <div class="toaster_content">
                <p class="toaster_message">${message}</p>
                <button class="toaster_close">&times;</button>
            </div>
         </div>
      `;
      $('body').append(alerthtml);
      setTimeout(() => {
         $('.toaster_alert').fadeOut(300, function() {
            $(this).remove();
         });
      }, 5000);
      $('.toaster_close').on('click', function() {
         $(this).closest('.toaster_alert').fadeOut(300, function() {
            $(this).remove();
         });
      });
   }

   // Load bottom bar
   fetch("{{ asset('vendors/assets/html/bottombar.html') }}")
      .then(response => response.text())
      .then(data => {
         document.getElementById("bottombar-placeholder").innerHTML = data;
      });

   // Entrance animation
   $(document).ready(function() {
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

      $('.notification-card').on('click', function() {
         $(this).css('transform', 'scale(0.98)');
         setTimeout(() => {
            $(this).css('transform', 'translateY(-3px) scale(1)');
         }, 150);
      });
   });
</script>

@endsection
