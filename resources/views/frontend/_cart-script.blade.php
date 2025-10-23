<script>
// function updateCartCount() {
//     $.ajax({
//         url: "{{ route('cart.count') }}",
//         type: 'GET',
//         cache: false,
//         dataType: 'json',
//         success: function(response) {
//             console.log('Cart Count: ' + response.count);
//             $('.cartCount').text(response.count); // update all
//         },
//         error: function(xhr) {
//             console.error('Error fetching cart count:', xhr.responseText);
//         }
//     });
// }

// $(document).ready(function() {
//     updateCartCount();
// });

// window.addEventListener('pageshow', updateCartCount);
// document.addEventListener('visibilitychange', function() {
//     if (document.visibilityState === 'visible') updateCartCount();
// });

</script>
