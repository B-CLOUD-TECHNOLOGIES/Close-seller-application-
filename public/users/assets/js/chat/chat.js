$(function () {
  // Get query params
  const urlParams = new URLSearchParams(window.location.search);
  const user = urlParams.get("user") || "Unknown User";
  const status = urlParams.get("status") || "offline";

  // Set user info
  $(".chat-user-name").text(user);
  const statusElement = $(".chat-user-status");

  if (status === "online") {
    statusElement.html(
      '<span class="status-indicator status-online"></span>Online'
    );
    statusElement.removeClass("offline");
  } else {
    statusElement.html(
      '<span class="status-indicator status-offline"></span>Offline'
    );
    statusElement.addClass("offline");
  }

  // Initialize welcome message
  function showWelcomeMessage() {
    if ($("#chatMessages").children().length === 1) {
      $("#chatMessages").html(`
                <div class="welcome-message">
                    <i class="bi bi-chat-heart" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <p>Start a conversation with ${user}</p>
                    <small>Messages are end-to-end encrypted</small>
                </div>
            `);
    }
  }

  showWelcomeMessage();

 $(function () {
   const $btn = $("#showContactBtn");
   const $vendor = $("#vendorContact");

   $btn.on("click", function () {
     // willShow = true if vendor is currently hidden and will be shown
     const willShow = !$vendor.is(":visible");

     // stop queued animations, toggle with animation
     $vendor.stop(true, true).slideToggle(300);

     // update button markup & aria
     if (willShow) {
       // When contact is showing, button should say "Hide Contact"
       $btn.html("Hide Contact");
       $btn.attr("aria-expanded", "true");
     } else {
       // When contact is hidden, show phone icon + "Contact"
       $btn.html('<i class="bi bi-telephone me-1"></i> Contact');
       $btn.attr("aria-expanded", "false");
     }
   });
 });


  // Auto-resize input
  $("#chatInput").on("input", function () {
    this.style.height = "auto";
    this.style.height = this.scrollHeight + "px";
  });

  // Send message function
  function sendMessage() {
    let msg = $("#chatInput").val().trim();
    if (msg !== "") {
      // Remove welcome message if it exists
      $(".welcome-message").remove();

      let time = new Date().toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
      });

      let messageHTML = `
                <div class="d-flex mb-3 justify-content-end">
                    <div class="message-bubble message-out">
                        <div class="message-text">${msg}</div>
                        <small class="message-time">${time} <i class="bi bi-check2-all"></i></small>
                    </div>
                </div>`;

      $("#chatMessages").append(messageHTML);
      $("#chatInput").val("").css("height", "auto");

      // Scroll to bottom with animation
      $("#chatMessages").animate(
        {
          scrollTop: $("#chatMessages")[0].scrollHeight,
        },
        300
      );

      // Show typing indicator
      showTypingIndicator();

      // Simulate reply after delay
      setTimeout(function () {
        hideTypingIndicator();
        simulateReply(msg, time);
      }, 1500 + Math.random() * 1000);
    }
  }

  // Send button click
  $("#sendBtn").on("click", sendMessage);

  // Enter key to send
  $("#chatInput").on("keypress", function (e) {
    if (e.which === 13 && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  // Show typing indicator
  function showTypingIndicator() {
    $("#typingIndicator")
      .html(
        `
            <div class="d-flex align-items-center">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face" 
                     class="message-avatar me-2" alt="user">
                <div class="loading-message">
                    <span>Typing</span>
                    <div class="loading-dots">
                        <div class="loading-dot"></div>
                        <div class="loading-dot"></div>
                        <div class="loading-dot"></div>
                    </div>
                </div>
            </div>
        `
      )
      .fadeIn(200);
  }

  // Hide typing indicator
  function hideTypingIndicator() {
    $("#typingIndicator").fadeOut(200);
  }

  // Simulate reply
  function simulateReply(originalMsg, time) {
    const replies = [
      "Thanks for your message!",
      "That sounds great!",
      "I'll get back to you on that.",
      "Perfect, let me check.",
      "Absolutely! When would work for you?",
      "I understand. Let me think about it.",
      "Great question! Here's what I think...",
      "Thanks for letting me know.",
      "I appreciate your interest!",
      "Let me confirm the details.",
    ];

    let reply = replies[Math.floor(Math.random() * replies.length)];

    // Sometimes reference the original message
    if (Math.random() > 0.7) {
      reply = `Regarding "${originalMsg.substring(0, 20)}${
        originalMsg.length > 20 ? "..." : ""
      }", ${reply.toLowerCase()}`;
    }

    let replyHTML = `
            <div class="d-flex mb-3">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face" 
                     class="message-avatar me-2" alt="user">
                <div class="message-bubble message-in">
                    <div class="message-text">${reply}</div>
                    <small class="message-time">${time}</small>
                </div>
            </div>`;

    $("#chatMessages").append(replyHTML);

    // Scroll to bottom with animation
    $("#chatMessages").animate(
      {
        scrollTop: $("#chatMessages")[0].scrollHeight,
      },
      300
    );

    // Mark messages as delivered
    setTimeout(() => {
      $(".message-out .bi-check2")
        .removeClass("bi-check2")
        .addClass("bi-check2-all");
    }, 500);
  }

  // File upload simulation
  $("#fileBtn").on("click", function () {
    // Create hidden file input
    const fileInput = $(
      '<input type="file" style="display: none;" accept="image/*,video/*,audio/*,.pdf,.doc,.docx">'
    );

    fileInput.on("change", function () {
      const file = this.files[0];
      if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2) + " MB";

        let time = new Date().toLocaleTimeString([], {
          hour: "2-digit",
          minute: "2-digit",
        });

        $(".welcome-message").remove();

        let fileHTML = `
                    <div class="d-flex mb-3 justify-content-end">
                        <div class="message-bubble message-out">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-paperclip me-2"></i>
                                <div>
                                    <div class="message-text">${fileName}</div>
                                    <small style="opacity: 0.7;">${fileSize}</small>
                                </div>
                            </div>
                            <small class="message-time">${time} <i class="bi bi-check2-all"></i></small>
                        </div>
                    </div>`;

        $("#chatMessages").append(fileHTML);
        $("#chatMessages").animate(
          {
            scrollTop: $("#chatMessages")[0].scrollHeight,
          },
          300
        );
      }
    });

    fileInput.click();
  });

  // Emoji button (placeholder)
  $("#emojiBtn").on("click", function () {
    const emojis = ["😊", "👍", "❤️", "😂", "🔥", "👌", "🎉", "💯"];
    const randomEmoji = emojis[Math.floor(Math.random() * emojis.length)];

    const currentText = $("#chatInput").val();
    $("#chatInput")
      .val(currentText + randomEmoji)
      .focus();
  });

  // Message status updates
  function updateMessageStatus() {
    // Simulate message delivery status
    setTimeout(() => {
      $(".message-out .bi-check2")
        .removeClass("bi-check2")
        .addClass("bi-check2-all");
    }, 1000);
  }

  // Initialize message status updates
  updateMessageStatus();

  // Auto-scroll on new messages
  const chatMessages = document.getElementById("chatMessages");
  const observer = new MutationObserver(() => {
    if (
      chatMessages.scrollTop + chatMessages.clientHeight >=
      chatMessages.scrollHeight - 100
    ) {
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
  });

  observer.observe(chatMessages, { childList: true });

  // Handle window resize
  $(window).on("resize", function () {
    $("#chatMessages").scrollTop($("#chatMessages")[0].scrollHeight);
  });
});
