            <footer class="fixed-bottom bg-white shadow-sm">
                <div class="footer-container">
                    <a href="./index.php" class="text-center text-decoration-none text-purple-600 nav-item active">
                        <span class="material-symbols-outlined d-block nav-icon">home</span>
                        <span class="nav-label fw-semibold">Home</span>
                    </a>
                    <a href="./src/frontend/buyer/views/productInformation/allCategories.php"
                        class="text-center text-decoration-none text-gray-600 nav-item">
                        <span class="material-symbols-outlined d-block nav-icon">category</span>
                        <span class="nav-label">Categories</span>
                    </a>

                    <div class="footer-center-wrapper">
                        <a href="#" class="text-center text-decoration-none">
                            <div class="rounded-circle bg-purple-600 d-flex align-items-center justify-content-center footer-center-button"
                                style="background: linear-gradient(135deg, #7c3aed, #6d28d9);">
                                <span class="fw-bold text-white fs-5">CS</span>
                            </div>
                        </a>
                    </div>

                    <!-- Fixed Chat Notification Badge -->
                    <a href="src/frontend/chat/buyerNotification.php" id="messageLink"
                        class="text-center text-decoration-none text-gray-600 nav-item position-relative">
                        <span class="material-symbols-outlined d-block nav-icon">chat_bubble</span>
                        <!-- Unread messages indicator - FIXED POSITION -->
                        <span id="message-badge" class="notification-badge">3</span>
                        <span class="nav-label">Chat</span>
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
