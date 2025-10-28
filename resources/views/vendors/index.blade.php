@extends('vendors.vendor-masters')
@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/profile.css') }}" />

            <!-- Header Section -->
        <section class="section-1">
            <button class="back-button" onclick="history.back()">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.0404 9.5H3.95703" stroke="#888787" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M9.4987 15.0423L3.95703 9.50065L9.4987 3.95898" stroke="#888787" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <a href="{{ route('vendor.personal.data') }}">
                <div class="profile">
                    
                    <img 
                        src="{{ $vendor->image ? asset($vendor->image) : asset('vendors/assets/images/default-avatar.png') }}" 
                        alt="Profile Picture"
                        class="profile-img"
                        style="border-radius:50%;width:70px;height:70px;object-fit:cover;"
                    />
                    <p>{{ $vendor->firstname }} {{ $vendor->lastname }}</p>
                    
                </div>
            </a>
            <a href="{{ route('vendor.settings') }}" class="settings-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M19.4328 12.98C19.4728 12.66 19.5028 12.34 19.5028 12C19.5028 11.66 19.4728 11.34 19.4328 11.02L21.5428 9.37C21.7328 9.22 21.7828 8.95 21.6628 8.73L19.6628 5.27C19.5728 5.11 19.4028 5.02 19.2228 5.02C19.1628 5.02 19.1028 5.03 19.0528 5.05L16.5628 6.05C16.0428 5.65 15.4828 5.32 14.8728 5.07L14.4928 2.42C14.4628 2.18 14.2528 2 14.0028 2H10.0028C9.75277 2 9.54277 2.18 9.51277 2.42L9.13277 5.07C8.52277 5.32 7.96277 5.66 7.44277 6.05L4.95277 5.05C4.89277 5.03 4.83277 5.02 4.77277 5.02C4.60277 5.02 4.43277 5.11 4.34277 5.27L2.34277 8.73C2.21277 8.95 2.27277 9.22 2.46277 9.37L4.57277 11.02C4.53277 11.34 4.50277 11.67 4.50277 12C4.50277 12.33 4.53277 12.66 4.57277 12.98L2.46277 14.63C2.27277 14.78 2.22277 15.05 2.34277 15.27L4.34277 18.73C4.43277 18.89 4.60277 18.98 4.78277 18.98C4.84277 18.98 4.90277 18.97 4.95277 18.95L7.44277 17.95C7.96277 18.35 8.52277 18.68 9.13277 18.93L9.51277 21.58C9.54277 21.82 9.75277 22 10.0028 22H14.0028C14.2528 22 14.4628 21.82 14.4928 21.58L14.8728 18.93C15.4828 18.68 16.0428 18.34 16.5628 17.95L19.0528 18.95C19.1128 18.97 19.1728 18.98 19.2328 18.98C19.4028 18.98 19.5728 18.89 19.6628 18.73L21.6628 15.27C21.7828 15.05 21.7328 14.78 21.5428 14.63L19.4328 12.98Z"
                        fill="#1C1C1C" />
                    <circle cx="12" cy="12" r="3" fill="#1C1C1C" />
                </svg>
            </a>
        </section>

        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-text">Welcome back!</div>
            <div class="welcome-subtitle">Manage your store and connect with customers</div>
        </section>

        <!-- Menu Section -->
        <section class="section-2">
            <div class="menu-grid">
                <!-- My Products -->
                <a href="{{ route('vendor.products') }}" class="menu-item">
                    <div class="menu-content">
                        <div class="menu-icon">
                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="icons">
                                <path
                                    d="M18 2H17V0H15V2H5V0H3V2H2C0.9 2 0 2.9 0 4V20C0 21.1 0.9 22 2 22H18C19.1 22 20 21.1 20 20V4C20 2.9 19.1 2 18 2ZM18 20H2V9H18V20ZM18 7H2V4H18V7Z"
                                    fill="#1C1C1C" fill-opacity="0.8" />
                            </svg>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">My Products</div>
                            <div class="menu-subtitle">Manage your product listings</div>
                        </div>
                    </div>
                </a>

               <a href="{{ route('vendor.notifications') }}" class="menu-item notification-item">
                    <div class="notification-badge">
                        @if($unreadNotifications > 0)
                            <span class="badge">{{ $unreadNotifications }}</span>
                        @endif
                    </div>
                    <div class="menu-content">
                        <div class="menu-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="icons">
                                <path
                                    d="M4.57888 10.3999L4.57891 10.3999L4.58184 10.3949C4.712 10.1725 4.82193 9.87707 4.89906 9.59691C4.97608 9.31716 5.03367 9.00454 5.03367 8.74232V7.19232C5.03367 4.44494 7.26681 2.21693 10.0177 2.20898C12.7574 2.20936 14.992 4.44319 14.992 7.19232V8.75065C14.992 9.01308 15.0496 9.32603 15.1281 9.60705C15.2064 9.88733 15.3192 10.1848 15.4559 10.4096C15.4562 10.41 15.4565 10.4105 15.4568 10.411L16.3955 11.9727C16.3957 11.9731 16.3959 11.9734 16.3961 11.9737C16.6614 12.4208 16.7109 12.9453 16.5323 13.4247C16.3513 13.9021 15.9722 14.2749 15.4747 14.4433C14.5985 14.7353 13.7001 14.9617 12.796 15.107L12.796 15.1069L12.7859 15.1087C12.6903 15.1261 12.6207 15.1384 12.5551 15.1444L12.5365 15.1461L12.5181 15.1491C12.3838 15.1715 12.2473 15.1868 12.0951 15.2037L12.0951 15.2036L12.0828 15.2052C11.9137 15.2283 11.7344 15.244 11.5404 15.2609L11.5403 15.2608L11.5355 15.2613C11.0352 15.3097 10.5262 15.334 10.017 15.334C9.49919 15.334 8.98168 15.3097 8.47274 15.2612L8.47275 15.2611L8.46227 15.2604C8.25068 15.2447 8.04706 15.2212 7.84303 15.1898L7.84304 15.1897L7.83308 15.1884C7.71075 15.1721 7.59119 15.1561 7.47972 15.1402C7.42643 15.1308 7.37513 15.1238 7.3342 15.1183L7.33039 15.1177C7.28278 15.1112 7.24791 15.1064 7.21477 15.1004L7.21478 15.1004L7.20969 15.0995C6.30595 14.9448 5.42266 14.7338 4.55012 14.443L4.54654 14.4418C4.01717 14.2698 3.62996 13.8925 3.46096 13.4355L3.46016 13.4334C3.29555 12.9945 3.34668 12.4609 3.63842 11.9645L4.57888 10.3999Z"
                                    stroke="black" />
                                <path
                                    d="M9.992 9.46732C10.6181 9.46732 11.1253 8.96013 11.1253 8.33398V5.75065C11.1253 5.12451 10.6181 4.61732 9.992 4.61732C9.36586 4.61732 8.85866 5.12451 8.85866 5.75065V8.33398C8.85866 8.96013 9.36586 9.46732 9.992 9.46732Z"
                                    stroke="black" />
                                <path
                                    d="M9.99844 17.8327C9.48882 17.8327 8.98723 17.632 8.62833 17.2808C9.08376 17.3185 9.54846 17.341 10.0151 17.341C10.4738 17.341 10.9304 17.3185 11.3778 17.2809C11.0173 17.6231 10.5312 17.8327 9.99844 17.8327Z"
                                    stroke="black" />
                            </svg>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">Notifications</div>
                            <div class="menu-subtitle">Stay updated with your store</div>
                        </div>
                    </div>
                </a>

                <!-- Transactions -->
                <a href="../../../transactions/index.php" class="menu-item">
                    <div class="menu-content">
                        <div class="menu-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                class="transaction-icon">
                                <path
                                    d="M122.6 46.3c-7.8-11.7-22.4-17-35.9-12.9S64 49.9 64 64l0 192-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 0 128c0 17.7 14.3 32 32 32s32-14.3 32-32l0-128 100.2 0 97.2 145.8c7.8 11.7 22.4 17 35.9 12.9s22.7-16.5 22.7-30.6l0-128 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-192c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 192-57.5 0L122.6 46.3zM305.1 320l14.9 0 0 22.3L305.1 320zM185.5 256L128 256l0-86.3L185.5 256z" />
                            </svg>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">Transactions</div>
                            <div class="menu-subtitle">View your sales history</div>
                        </div>
                    </div>
                </a>

                <!-- All Orders -->
                <a href="{{ route('vendor.orders.order-index') }}" class="menu-item">
                    <div class="menu-content">
                        <div class="menu-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="icons">
                                <path
                                    d="M20.2091 8.11949V17.5295C20.2091 19.7134 18.4229 21.4995 16.2391 21.4995H7.75906C5.5752 21.4995 3.78906 19.7133 3.78906 17.5295V8.11949C3.78906 6.60087 4.64121 5.27735 5.89363 4.61106C6.06468 4.52048 6.25906 4.65242 6.25906 4.81949C6.25906 6.68563 7.78292 8.20949 9.64906 8.20949H14.3491C16.2152 8.20949 17.7391 6.68563 17.7391 4.81949C17.7391 4.65295 17.9242 4.5187 18.1068 4.61226C19.3579 5.27894 20.2091 6.60178 20.2091 8.11949Z"
                                    stroke="black" />
                                <path
                                    d="M15.7317 3.87519L15.7317 3.87519V3.88V4.82C15.7317 5.58386 15.1156 6.2 14.3517 6.2H9.64172C8.87786 6.2 8.26172 5.58386 8.26172 4.82V3.88C8.26172 3.11959 8.8844 2.5 9.65172 2.5H14.3517C15.12 2.5 15.739 3.11947 15.7317 3.87519Z"
                                    stroke="black" />
                            </svg>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">All Orders</div>
                            <div class="menu-subtitle">Manage customer orders</div>
                        </div>
                    </div>
                </a>

                <!-- Request Help -->
                <a href="{{ route ('vendor.gethelp') }}" class="menu-item">
                    <div class="menu-content">
                        <div class="menu-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="icons">
                                <path
                                    d="M6.54 5C6.6 5.89 6.75 6.76 6.99 7.59L5.79 8.79C5.38 7.59 5.12 6.32 5.03 5H6.54ZM16.4 17.02C17.25 17.26 18.12 17.41 19 17.47V18.96C17.68 18.87 16.41 18.61 15.2 18.21L16.4 17.02ZM7.5 3H4C3.45 3 3 3.45 3 4C3 13.39 10.61 21 20 21C20.55 21 21 20.55 21 20V16.51C21 15.96 20.55 15.51 20 15.51C18.76 15.51 17.55 15.31 16.43 14.94C16.33 14.9 16.22 14.89 16.12 14.89C15.86 14.89 15.61 14.99 15.41 15.18L13.21 17.38C10.38 15.93 8.06 13.62 6.62 10.79L8.82 8.59C9.1 8.31 9.18 7.92 9.07 7.57C8.7 6.45 8.5 5.25 8.5 4C8.5 3.45 8.05 3 7.5 3Z"
                                    fill="#1C1C1C" fill-opacity="0.8" />
                            </svg>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">Request Help</div>
                            <div class="menu-subtitle">Get support when you need it</div>
                        </div>
                    </div>
                </a>

                <!-- FAQ -->
                <a href="{{ route('vendor.faqs') }}" class="menu-item">
                    <div class="menu-content">
                        <div class="menu-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="icons">
                                <path
                                    d="M14.5274 12.5196L14.526 12.5211C14.1742 12.8778 13.9319 13.1608 13.7671 13.5098C13.6046 13.8539 13.5 14.3011 13.5 15V15.5H13H11H10.5V15V14.5C10.5 13.261 11.0072 12.1371 11.8136 11.3193L14.5274 12.5196ZM14.5274 12.5196L15.4255 11.6016C16.0843 10.9418 16.5 10.0169 16.5 9C16.5 6.51386 14.4861 4.5 12 4.5C9.51386 4.5 7.5 6.51386 7.5 9V9.5H8H10H10.5V9C10.5 8.17614 11.1761 7.5 12 7.5C12.8239 7.5 13.5 8.17614 13.5 9C13.5 9.4139 13.3354 9.78499 13.0613 10.0516L13.0612 10.0516L13.0536 10.0593L11.814 11.3189L14.5274 12.5196ZM13 19.5H13.5V19V17V16.5H13H11H10.5V17V19V19.5H11H13ZM2.5 12C2.5 6.75614 6.75614 2.5 12 2.5C17.2439 2.5 21.5 6.75614 21.5 12C21.5 17.2439 17.2439 21.5 12 21.5C6.75614 21.5 2.5 17.2439 2.5 12Z"
                                    stroke="black" />
                            </svg>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">FAQ</div>
                            <div class="menu-subtitle">Find answers to common questions</div>
                        </div>
                    </div>
                </a>

                <!-- Reviews -->
                <a href="{{ route('vendor.reviews') }}" class="menu-item">
                    <div class="menu-content">
                        <div class="menu-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="icons">
                                <path
                                    d="M21.7312 2.26884C20.706 1.24372 19.044 1.24372 18.0188 2.26884L16.8617 3.42599L20.574 7.1383L21.7312 5.98116C22.7563 4.95603 22.7563 3.29397 21.7312 2.26884Z"
                                    stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M19.5133 8.19896L15.801 4.48665L7.40019 12.8875C6.78341 13.5043 6.33002 14.265 6.081 15.101L5.28122 17.7859C5.2026 18.0498 5.27494 18.3356 5.46967 18.5303C5.6644 18.7251 5.95019 18.7974 6.21412 18.7188L8.89901 17.919C9.73498 17.67 10.4957 17.2166 11.1125 16.5998L19.5133 8.19896Z"
                                    stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M5.25 5.24999C3.59315 5.24999 2.25 6.59314 2.25 8.24999V18.75C2.25 20.4068 3.59315 21.75 5.25 21.75H15.75C17.4069 21.75 18.75 20.4068 18.75 18.75V13.5C18.75 13.0858 18.4142 12.75 18 12.75C17.5858 12.75 17.25 13.0858 17.25 13.5V18.75C17.25 19.5784 16.5784 20.25 15.75 20.25H5.25C4.42157 20.25 3.75 19.5784 3.75 18.75V8.24999C3.75 7.42156 4.42157 6.74999 5.25 6.74999H10.5C10.9142 6.74999 11.25 6.41421 11.25 5.99999C11.25 5.58578 10.9142 5.24999 10.5 5.24999H5.25Z"
                                    stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">Reviews</div>
                            <div class="menu-subtitle">See what customers say</div>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Help Button -->
        <button class="help-button" onclick="toggleHelpCard()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 19H11V17H13V19ZM15.07 11.25L14.17 12.17C13.45 12.9 13 13.5 13 15H11V14.5C11 13.4 11.45 12.4 12.17 11.67L13.41 10.41C13.78 10.05 14 9.55 14 9C14 7.9 13.1 7 12 7C10.9 7 10 7.9 10 9H8C8 6.79 9.79 5 12 5C14.21 5 16 6.79 16 9C16 9.88 15.64 10.68 15.07 11.25Z"
                    fill="white" />
            </svg>
        </button>

        <!-- Help Card -->
        <div id="helpCard" class="help-card hidden">
            <div class="help-card-content">
                <h3>Need Help?</h3>
                <p>Choose one of the support options below:</p>
                <div class="help-options">
                    <a href="{{ route('vendor.gethelp') }}" class="help-link">📩 Request Help</a>
                    <a href="{{ route('vendor.faqs') }}" class="help-link">❓ FAQ</a>
                    <a href="tel:+1234567890" class="help-link">📞 Call Support</a>
                </div>
                <button class="close-help" onclick="toggleHelpCard()">Close</button>
            </div>
        </div>



        @include('vendors.body.footer') 
@endsection