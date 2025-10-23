<script>
    function toggleHeart(heartIcon, productId) {
        $.ajax({
            url: "{{ route('add.to.wishlist') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                product_id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === false && response.redirect) {
                    toastr.warning(response.message || 'Please log in to manage your wishlist');

                    // Delay redirect for user to see the toastr message
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 2000); // 2-second delay

                    return;
                }
                
                if (response.isWishlist == 1) {
                    heartIcon.classList.remove("fa-heart-o");
                    heartIcon.classList.add("fa-heart");
                    heartIcon.style.color = "#7c3aed";
                    toastr.success('Added to wishlist');
                } else {
                    heartIcon.classList.remove("fa-heart");
                    heartIcon.classList.add("fa-heart-o");
                    heartIcon.style.color = "#555";
                    toastr.info('Removed from wishlist');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                toastr.error('Something went wrong, please try again.');
            }
        });
    }

    function refreshWishlistIcons() {
        $.ajax({
            url: "{{ route('wishlist.status') }}",
            type: 'GET',
            cache: false,
            dataType: 'json',
            success: function(response) {
                const wishlistIds = response.wishlist ? response.wishlist.map(Number) : [];
                document.querySelectorAll('.heart-icon').forEach(icon => {
                    // Get product ID from the parent button's data-product-id attribute
                    const button = icon.closest('button[data-product-id]');
                    const productId = button ? parseInt(button.getAttribute('data-product-id')) :
                        NaN;

                    if (!isNaN(productId)) {
                        if (wishlistIds.includes(productId)) {
                            icon.classList.remove('fa-heart-o');
                            icon.classList.add('fa-heart');
                            icon.style.color = '#7c3aed';
                        } else {
                            icon.classList.remove('fa-heart');
                            icon.classList.add('fa-heart-o');
                            icon.style.color = '#555';
                        }
                    }
                });
            },
            error: function(xhr) {
                console.error('Error fetching wishlist:', xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        refreshWishlistIcons(); // initial check
    });

    // ✅ Detect if user navigates back (from bfcache or browser back button)
    window.addEventListener('pageshow', function(event) {
        refreshWishlistIcons();
    });

    // ✅ Extra fallback for browsers that don't trigger pageshow properly
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            refreshWishlistIcons();
        }
    });


    
</script>
