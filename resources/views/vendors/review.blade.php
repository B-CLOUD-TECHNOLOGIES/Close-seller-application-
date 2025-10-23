@extends('vendors.vendor-masters')
@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/review.css') }}" />
<div class="header">
    <a href="{{ route('vendor.dashboard') }}" class="back-button">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z" fill="#1C1C1C" />
      </svg>
    </a>
    <h1>Customer Reviews</h1>
    <div class="header-spacer"></div>
  </div>

  <div class="stats-container">
    <div class="stat-card">
      <div class="stat-value">4.2</div>
      <div class="stat-label">Average Rating</div>
    </div>
    <div class="stat-card">
      <div class="stat-value">24</div>
      <div class="stat-label">Total Reviews</div>
    </div>
    <div class="stat-card">
      <div class="stat-value">86%</div>
      <div class="stat-label">Positive</div>
    </div>
  </div>

  <div class="filter-container">
    <button class="filter-btn active" data-filter="all">All Reviews</button>
    <button class="filter-btn" data-filter="5">5 Stars</button>
    <button class="filter-btn" data-filter="4">4 Stars</button>
    <button class="filter-btn" data-filter="3">3 Stars</button>
    <button class="filter-btn" data-filter="2">2 Stars</button>
    <button class="filter-btn" data-filter="1">1 Star</button>
  </div>

  <div class="reviews-container" id="reviewsList">
    <!-- Reviews will be dynamically inserted here -->
  </div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
    const reviewsList = document.getElementById('reviewsList');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const avgStat = document.querySelector('.stat-card:nth-child(1) .stat-value');
    const totalStat = document.querySelector('.stat-card:nth-child(2) .stat-value');
    const positiveStat = document.querySelector('.stat-card:nth-child(3) .stat-value');
    let reviews = [];

    // Fetch data from backend
    async function fetchReviews() {
        try {
        const response = await fetch(`{{ route('vendor.reviews.fetch') }}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await response.json();
        reviews = data.reviews || [];

        // Update stats
        avgStat.textContent = data.stats.average || 0;
        totalStat.textContent = data.stats.total || 0;
        positiveStat.textContent = data.stats.positive + '%';

        renderReviews();
        } catch (error) {
        console.error('Error fetching reviews:', error);
        reviewsList.innerHTML = `<div class="error-state">Failed to load reviews. Please refresh.</div>`;
        }
    }

    // Render stars
    function renderStars(rating) {
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
        starsHtml += i <= rating
            ? '<i class="fas fa-star star"></i>'
            : '<i class="far fa-star star"></i>';
        }
        return starsHtml;
    }

    // Render reviews
    function renderReviews(filter = 'all') {
        reviewsList.innerHTML = '';
        const filtered = filter === 'all'
        ? reviews
        : reviews.filter(r => r.stars === parseInt(filter));

        if (filtered.length === 0) {
        reviewsList.innerHTML = `
            <div class="empty-state">
            <div class="empty-icon"><i class="far fa-comment-alt"></i></div>
            <div class="empty-title">No reviews found</div>
            <div class="empty-text">There are no reviews matching your selected filter.</div>
            </div>`;
        return;
        }

        filtered.forEach(review => {
        const div = document.createElement('div');
        div.className = 'review-card';
        div.innerHTML = `
            <div class="review-header">
            <img src="${review.image}" alt="${review.product}" class="product-image">
            <div class="review-info">
                <div class="product-name">${review.product}</div>
                <div class="review-date">${review.date}</div>
                <div class="customer-name">Customer: ${review.customer}</div>
            </div>
            </div>
            <div class="stars-container">${renderStars(review.stars)}</div>
            <div class="review-text">${review.text}</div>
        `;
        reviewsList.appendChild(div);
        });
    }

    // Filter logic
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        renderReviews(btn.dataset.filter);
        });
    });

    // Load data
    await fetchReviews();
    });
</script>

@endsection