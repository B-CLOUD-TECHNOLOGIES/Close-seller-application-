            <footer class="fixed-bottom bg-white shadow-sm">
                <div class="footer-container">
                    <a href="{{ route('index') }}"
                        class="text-center text-decoration-none text-purple-600 nav-item active">
                        <span class="material-symbols-outlined d-block nav-icon">home</span>
                        <span class="nav-label fw-semibold">Home</span>
                    </a>
                    <a href="{{ route('categories') }}" class="text-center text-decoration-none text-gray-600 nav-item">
                        <span class="material-symbols-outlined d-block nav-icon">category</span>
                        <span class="nav-label">Categories</span>
                    </a>

                    <div class="footer-center-wrapper">
                        <a href="javascript:;" class="text-center text-decoration-none">
                            <div class="rounded-circle bg-purple-600 d-flex align-items-center justify-content-center footer-center-button"
                                style="background: linear-gradient(135deg, #7c3aed, #6d28d9);">
                                <span class="fw-bold text-white fs-5">CS</span>
                            </div>
                        </a>
                    </div>

                    <!-- Fixed Chat Notification Badge -->
                    <a href="src/frontend/chat/buyerNotification.php" id="messageLink"
                        class="text-center text-decoration-none text-gray-600 nav-item position-relative">
                        <span class="nav-div position-relative">
                            <span class="material-symbols-outlined d-block nav-icon p-0 m-0">chat_bubble</span>
                            <!-- Unread messages indicator - FIXED POSITION -->
                            <span class="nav-label p-0 m-0">Chat</span>
                            <span id="message-badge" class="notification-badge">3</span>
                        </span>
                    </a>

                    @if (Auth::user())
                        <a href="{{ url('/users/dashboard') }}"
                            class="text-center text-decoration-none text-gray-600 nav-item">
                            <span class="material-symbols-outlined d-block nav-icon">person</span>
                            <span class="nav-label">Profile</span>
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="text-center text-decoration-none text-gray-600 nav-item">
                            <span class="material-symbols-outlined d-block nav-icon">person</span>
                            <span class="nav-label">Profile</span>
                        </a>
                    @endif

                </div>
            </footer>

            <!-- Bubble container -->
            <div class="bubble-container"></div>
            <style>
                .bubble-container {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100vw;
                    height: 100vh;
                    overflow: hidden;
                    pointer-events: none;
                    z-index: 500;
                    /* ensure it stays behind overlays but above background */
                }

                .bubble {
                    position: absolute;
                    top: -30px;
                    border-radius: 50%;
                    opacity: 0;
                    animation: fallBubbles linear forwards;
                }

                @keyframes fallBubbles {
                    0% {
                        transform: translateY(0) scale(1);
                        opacity: 0;
                    }

                    10% {
                        opacity: 1;
                    }

                    90% {
                        opacity: 0.8;
                    }

                    100% {
                        transform: translateY(110vh) scale(0.6);
                        opacity: 0;
                    }
                }
            </style>

            <script>
                const button = document.querySelector('.footer-center-button');
                const bubbleContainer = document.querySelector('.bubble-container');

                function createFallingBubbles() {
                    const colors = ['#701d9d', '#fb7e00', '#ffc107', '#28a745', '#ff6347', '#087a19', '#7c3aed'];
                    const bubbleCount = 40;

                    for (let i = 0; i < bubbleCount; i++) {
                        // Stagger the creation of each bubble
                        setTimeout(() => {
                            const bubble = document.createElement('span');
                            bubble.classList.add('bubble');

                            const size = Math.random() * 15 + 10; // 10–25px
                            const duration = Math.random() * 3 + 2.5; // 2.5–5.5 seconds (varied speeds)
                            const drift = (Math.random() - 0.5) * 200; // -100 to +100px horizontal drift

                            bubble.style.width = `${size}px`;
                            bubble.style.height = `${size}px`;
                            bubble.style.left = `${Math.random() * 100}vw`;
                            bubble.style.background = colors[Math.floor(Math.random() * colors.length)];
                            bubble.style.setProperty('--drift', `${drift}px`);
                            bubble.style.animationDuration = `${duration}s`;

                            bubbleContainer.appendChild(bubble);

                            // Remove bubble after it finishes animation
                            setTimeout(() => bubble.remove(), duration * 1000);
                        }, Math.random() * 1500); // Random delay between 0-1500ms for each bubble
                    }
                }

                // Trigger bubbles on hover or click
                button.addEventListener('mouseenter', createFallingBubbles);
                button.addEventListener('click', createFallingBubbles);
            </script>
