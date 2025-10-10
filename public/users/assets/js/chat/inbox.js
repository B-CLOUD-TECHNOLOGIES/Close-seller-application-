$(function () {
  // Search messages
  $("#searchMessages").on("keyup", function () {
    let value = $(this).val().toLowerCase();
    $("#messageList a").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  // Filter buttons
  $(".btn-group button").on("click", function () {
    $(".btn-group button").removeClass("active-filter");
    $(this).addClass("active-filter");
    let filter = $(this).data("filter");

    $("#messageList a").show(); // reset
    if (filter === "read") {
      $("#messageList a").filter(":has(.bg-orange-notification)").hide();
    } else if (filter === "unread") {
      $("#messageList a").filter(":not(:has(.bg-orange-notification))").hide();
    }
  });
});
