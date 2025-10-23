@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/faq-details.css') }}" />

<!-- Header -->
<div class="header">
    <a href="{{ route('vendor.faqs') }}">
        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="Back" class="img" />
    </a>
    <h3>FAQ Details</h3>
    <div class="header-spacer"></div>
</div>

<div class="content-container">
    <!-- FAQ Detail Card -->
    <div class="faq-detail">
        <div class="faq-header">
            <div class="faq-category">{{ $faq->category }}</div>
            <h2 class="faq-question">{{ $faq->question }}</h2>
            <div class="faq-meta">
                <span class="meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
                    </svg>
                    Last updated: {{ $faq->updated_at ? $faq->updated_at->format('M d, Y') : 'Not available' }}
                </span>
            </div>
        </div>
      
        <div class="faq-content">
            <div class="faq-answer">
                {!! nl2br(e($faq->answer)) !!}
            </div>
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="feedback-card">
        <div class="feedback-header">
            <h3 class="feedback-title">Was this helpful?</h3>
            <p class="feedback-subtitle">Let us know if this answered your question</p>
        </div>
      
        <div class="feedback-buttons">
            <button class="feedback-btn helpful" onclick="submitFeedback('yes')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Yes, helpful
            </button>
            <button class="feedback-btn not-helpful" onclick="submitFeedback('no')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="m10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Not helpful
            </button>
        </div>
      
        <div class="feedback-success" id="feedbackSuccess">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="display: inline; margin-right: 0.5rem;">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
            </svg>
            Thank you for your feedback! We appreciate you taking the time to help us improve.
        </div>
    </div>

    <!-- Related Questions -->
    <div class="related-section">
        <h3 class="related-title">Related Questions</h3>
        <div class="related-questions">
            @php
                $relatedFaqs = \App\Models\Faq::where('category', $faq->category)
                    ->where('id', '!=', $faq->id)
                    ->limit(4)
                    ->get();
            @endphp

            @forelse($relatedFaqs as $related)
                <a href="{{ route('vendor.faqs.show', $related->id) }}" class="related-question">
                    <span class="related-text">{{ $related->question }}</span>
                    <svg class="related-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M8.29313 16.59L9.70312 18L15.7031 12L9.70313 6L8.29313 7.41L12.8731 12L8.29313 16.59Z" fill="currentColor" />
                    </svg>
                </a>
            @empty
                <p>No related questions found.</p>
            @endforelse
        </div>
    </div>

    <!-- Contact Support -->
    <div class="support-section">
        <h3 class="support-title">Still need help?</h3>
        <p class="support-description">Our support team is here to help you with any questions you may have.</p>
        <a href="{{ route ('vendor.gethelp') }}" class="support-button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Contact Support
        </a>
    </div>
</div>

<script>
function submitFeedback(response) {
    document.querySelector('.feedback-buttons').style.display = 'none';
    document.getElementById('feedbackSuccess').style.display = 'block';
    console.log("Feedback submitted: " + response);
}
</script>
@endsection
