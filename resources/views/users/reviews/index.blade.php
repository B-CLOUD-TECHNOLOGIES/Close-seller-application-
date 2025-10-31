@extends('vendors.vendor-masters')

@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/review.css') }}" />
    <link rel="stylesheet" href="{{ asset('users/assets/css/rateupPage.css') }}" />

    <div class="header align-items-end">
        <a href="#" onclick="window.history.back();" class="back-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z"
                    fill="#1C1C1C" />
            </svg>
        </a>
        <h1>My Reviews</h1>
        <div class="header-spacer"></div>
    </div>

    <div class="filter-container">
        <button class="filter-btn active" data-filter="all">All Reviews</button>
        <button class="filter-btn" data-filter="unreviewed">Unreviewed</button>
        <button class="filter-btn" data-filter="reviewed">Reviewed</button>
        <button class="filter-btn" data-filter="5">5 Stars</button>
        <button class="filter-btn" data-filter="4">4 Stars</button>
        <button class="filter-btn" data-filter="3">3 Stars</button>
        <button class="filter-btn" data-filter="2">2 Stars</button>
        <button class="filter-btn" data-filter="1">1 Star</button>
    </div>

    <div class="reviews-container" id="reviewsList">
        <!-- Reviews will be dynamically inserted here -->
    </div>

    <style>
        .modal {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.6);
            position: fixed;
            inset: 0;
            z-index: 1000;
            transition: opacity 0.3s ease;
        }

        .modal.hidden {
            display: none;
        }

        .modal-content {
            background: #fff;
            padding: 2rem;
            width: 90%;
            max-width: 450px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: pop 0.3s ease;
        }

        @keyframes pop {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 15px;
            font-size: 1.5rem;
            color: #555;
            cursor: pointer;
        }

        .star-container i {
            font-size: 1.4rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-container i.active,
        .fa-star {
            color: orange;
        }

        .form-group {
            margin-top: 1rem;
        }

        #reviewText {
            width: 100%;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 0.6rem;
            resize: none;
        }

        #reviewText:focus {
            outline: 2px solid purple;
            border-color: purple;
            box-shadow: 0 0 5px rgba(128, 0, 128, 0.3);
        }
    </style>

    <!-- Review Modal -->
    <div id="reviewModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-btn">&times;</span>

            <h3 class="modal-title">Write a Review</h3>

            <form id="reviewForm">
                <input type="hidden" id="reviewProductId" name="product_id" value="">

                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <div id="starContainer" class="star-container mt-2">
                        <!-- Stars will be dynamically rendered -->
                    </div>
                </div>

                <div class="form-group">
                    <label for="reviewText">Your Review:</label>
                    <textarea id="reviewText" name="review" rows="4" placeholder="Write your review here..." required></textarea>
                </div>

                <button type="submit" class="view-details-btn-1 mt-2 fw-semibold">Submit Review</button>
            </form>
        </div>
    </div>






    <script>
        const modal = document.getElementById('reviewModal');
        const closeBtn = document.querySelector('.close-btn');
        const reviewForm = document.getElementById('reviewForm');
        const starContainer = document.getElementById('starContainer');
        let selectedRating = 0;

        // Generate star selection UI
        function renderModalStars() {
            starContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('i');
                star.classList.add('far', 'fa-star', 'star');
                star.dataset.value = i;
                star.addEventListener('click', () => {
                    selectedRating = i;
                    updateStarDisplay();
                });
                starContainer.appendChild(star);
            }
        }

        function updateStarDisplay() {
            document.querySelectorAll('#starContainer i').forEach(star => {
                star.classList.toggle('active', parseInt(star.dataset.value) <= selectedRating);
            });
        }

        // Open modal
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('view-details-btn')) {
                const productId = e.target.dataset.id;
                document.getElementById('reviewProductId').value = productId;
                renderModalStars();
                modal.classList.remove('hidden');
            }
        });

        // Close modal
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        window.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });

        // Submit review
        reviewForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const productId = document.getElementById('reviewProductId').value;
            const reviewText = document.getElementById('reviewText').value;

            // Create FormData and explicitly set all values
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('review', reviewText);
            formData.append('rating', selectedRating);

            try {
                const response = await fetch('{{ url('/users/submit/review') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success('Review submitted successfully!');
                    modal.classList.add('hidden');
                    reviewForm.reset();
                    selectedRating = 0;
                    fetchReviews(); // Refresh the review list
                } else {
                    toastr.error(result.message || 'Failed to submit review.');
                }
            } catch (error) {
                console.error('Error submitting review:', error);
                toastr.error('An error occurred. Please try again.');
            }
        });
        const reviewsList = document.getElementById('reviewsList');
        const filterButtons = document.querySelectorAll('.filter-btn');

        // Render stars dynamically
        function renderStars(rating) {
            if (!rating) return '<span class="no-rating">No rating yet</span>';
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += i <= rating ?
                    '<i class="fas fa-star"></i>' :
                    '<i class="far fa-star"></i>';
            }
            return starsHtml;
        }

        // Render reviews list
        function renderReviews(reviews, filter = 'all') {
            reviewsList.innerHTML = '';

            let filteredReviews;

            switch (filter) {
                case 'reviewed':
                    filteredReviews = reviews.filter(r => r.is_reviewed === true);
                    break;
                case 'unreviewed':
                    filteredReviews = reviews.filter(r => r.is_reviewed === false);
                    break;

                case '1':
                case '2':
                case '3':
                case '4':
                case '5':
                    filteredReviews = reviews.filter(r => parseInt(r.rating) === parseInt(filter));
                    break;
                default:
                    filteredReviews = reviews;
            }

            if (filteredReviews.length === 0) {
                reviewsList.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon"><i class="far fa-comment-alt"></i></div>
                <div class="empty-title">No reviews found</div>
                <div class="empty-text">There are no reviews matching your selected filter.</div>
            </div>
        `;
                return;
            }

            filteredReviews.forEach(review => {
                const reviewCard = document.createElement('div');
                reviewCard.className = 'review-card';
                reviewCard.innerHTML = `
            <div class="review-header">
                <img src="${review.image || '/images/default.jpg'}" alt="${review.product_name}" class="product-image">
                <div class="review-info">
                    <div class="product-name">${review.product_name}</div>
                    <div class="review-date">${review.review_date || ''}</div>
                    <div class="category-name">${review.category}</div>
                </div>
            </div>

            <div class="stars-container">${renderStars(review.rating)}</div>

            <div class="review-text">
                ${review.review_text ? review.review_text : '<em>No review yet.</em>'}
            </div>

            ${!review.is_reviewed
              ? `<button class="view-details-btn mt-2" data-id="${review.product_id}">
                                Write a Review
                             </button>`
              : ''
            }
        `;
                reviewsList.appendChild(reviewCard);
            });
        }

        // Fetch reviews from backend
        async function fetchReviews() {
            try {
                const response = await fetch('{{ url('/users/fetch/reviews') }}');
                if (!response.ok) throw new Error('Failed to fetch reviews');

                const result = await response.json();

                if (result.status !== 'success' || !Array.isArray(result.data)) {
                    throw new Error('Invalid response format');
                }

                const reviews = result.data;
                window.allReviews = reviews; // Store globally for filters
                renderReviews(reviews);
            } catch (error) {
                console.error('Error loading reviews:', error);
                toastr.error("Failed to load reviews. Please try again later.")
                reviewsList.innerHTML = `
        <div class="error-text">
          Failed to load reviews. Please try again later.
        </div>
      `;
            }
        }

        // Filter functionality
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                renderReviews(window.allReviews || [], button.dataset.filter);
            });
        });

        // Run fetch on page load
        document.addEventListener('DOMContentLoaded', fetchReviews);
    </script>
@endsection
