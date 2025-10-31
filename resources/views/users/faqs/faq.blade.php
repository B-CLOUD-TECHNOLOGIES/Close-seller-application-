@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/faq2.css') }}" />


 <main>
    <section class="user-profile">
        <div class="header">
            <a href="#" onclick="window.history.back()">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="Back" class="img" />
            </a>
            <h3>FAQs</h3>
            <div class="header-spacer"></div>
        </div>

        <div class="help-section">
            <h2 class="help-title">Need Help?</h2>
            <p class="help-description">Find answers to commonly asked questions or contact our support team for assistance.</p>
            <a href="{{ route ('user.gethelp') }}" class="help-button">
                Contact Support
            </a>
        </div>

        <div class="faq-search">
            <input type="text" class="search-input" placeholder="Search frequently asked questions..." id="searchInput">
        </div>

        <div class="faq-container">
            @foreach($faqs as $category => $items)
                <div class="faq-list" data-category="{{ strtolower($category) }}">
                    <div class="faq-detail">
                        <h4>{{ $category }}</h4>
                        <a href="#" class="faq-arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M16.59 15.7049L18 14.2949L12 8.29492L6 14.2949L7.41 15.7049L12 11.1249L16.59 15.7049Z" fill="currentColor" />
                            </svg>
                        </a>
                    </div>

                    <div class="faq-info">
                        @foreach($items as $faq)
                            <a href="{{ route('vendor.faqs.show', $faq->id) }}" style="text-decoration:none; color: inherit;" class="faq-item">
                                <div class="faq-item2" data-question="{{ strtolower($faq->question) }}" style="width: 100%;">
                                    <div class="faq-click">
                                        <aside class="o-brown"></aside>
                                        <p class="faq-text">{{ $faq->question }}</p>
                                    </div>
                                    <a href="{{ route('vendor.faqs.show', $faq->id) }}" class="faq-arrow2">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M8.29313 16.59L9.70312 18L15.7031 12L9.70313 6L8.29313 7.41L12.8731 12L8.29313 16.59Z" fill="currentColor" />
                                        </svg>
                                    </a>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hide all FAQ info sections initially
            $('.faq-info').hide();

            // Add entrance animations
            $('.faq-list').each(function(index) {
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
                }, index * 150);
            });

            // FAQ accordion functionality
            $('.faq-detail').click(function(e) {
                e.preventDefault();

                const $this = $(this);
                const $info = $this.next('.faq-info');
                const $arrow = $this.find('.faq-arrow svg');

                // Toggle active class
                $this.toggleClass('active');

                // Slide toggle the content
                $info.slideToggle(400, function() {
                    // Update max-height for smooth animation
                    if ($info.is(':visible')) {
                        $info.addClass('active');
                    } else {
                        $info.removeClass('active');
                    }
                });
            });

            // Search functionality
            $('#searchInput').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();

                if (searchTerm === '') {
                    // Show all items
                    $('.faq-list').show();
                    $('.faq-item').closest('a').show();
                } else {
                    // Hide all items initially
                    $('.faq-list').hide();
                    $('.faq-item').closest('a').hide();

                    // Show matching items
                    $('.faq-item').each(function() {
                        const questionText = $(this).data('question');
                        const categoryText = $(this).closest('.faq-list').data('category');

                        if (questionText.includes(searchTerm) || categoryText.includes(searchTerm)) {
                            $(this).closest('a').show();
                            $(this).closest('.faq-list').show();

                            // Auto-expand the category if it has matches
                            const $category = $(this).closest('.faq-list');
                            const $detail = $category.find('.faq-detail');
                            const $info = $category.find('.faq-info');

                            if (!$detail.hasClass('active')) {
                                $detail.addClass('active');
                                $info.show().addClass('active');
                            }
                        }
                    });
                }
            });

            // Add click animation for FAQ items
            $('.faq-item').on('click', function() {
                $(this).css('transform', 'scale(0.98)');
                setTimeout(() => {
                    $(this).css('transform', 'translateX(8px) scale(1)');
                }, 150);
            });

            // Smooth hover animations
            $('.faq-item').hover(
                function() {
                    $(this).css('transform', 'translateX(8px)');
                },
                function() {
                    $(this).css('transform', 'translateX(0)');
                }
            );
        });
    </script>
@endsection