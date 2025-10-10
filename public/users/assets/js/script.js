// Function to toggle heart icon
function toggleHeart(heartIcon, productId) {
  if (heartIcon.classList.contains("fa-heart-o")) {
    heartIcon.classList.remove("fa-heart-o");
    heartIcon.classList.add("fa-heart");
    heartIcon.style.color = "#7c3aed";
  } else {
    heartIcon.classList.remove("fa-heart");
    heartIcon.classList.add("fa-heart-o");
    heartIcon.style.color = "#555";
  }
}

// Hide loading placeholder and show main content
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("loading-placeholder").style.display = "none";
  document.getElementById("main-content").style.display = "block";
});

$(document).ready(function () {
  // Toggle dropdown on button click
  $(".dropdown-btn").on("click", function (e) {
    e.stopPropagation(); // prevent bubbling to document
    var parentDropdown = $(this).parent();

    // Close all dropdowns first
    $(".dropdown").not(parentDropdown).removeClass("active");

    // Toggle current dropdown
    parentDropdown.toggleClass("active");
  });

  // Close dropdown if clicking outside
  $(document).on("click", function () {
    $(".dropdown").removeClass("active");
  });

  // Prevent closing when clicking inside dropdown content
  $(".dropdown-content").on("click", function (e) {
    e.stopPropagation();
  });
});
