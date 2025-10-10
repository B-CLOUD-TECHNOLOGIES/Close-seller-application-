@extends('vendors.vendor-masters')
@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/settings.css') }}" />

    <section style="margin-bottom: 100px;">
        <!-- Header -->
        <div class="header">
            <a href="./profile-menu.html" class="back-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z"
                        fill="#1C1C1C" />
                </svg>
            </a>
            <h1>Profile Settings</h1>
            <div class="header-spacer"></div>
        </div>

        <!-- Settings Container -->
        <div class="settings-container">
            <!-- Account Settings Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        Account Settings
                    </div>
                </div>

                <a href="./personal_data.html" class="settings-item">
                    <div class="settings-item-content">
                        <div class="settings-item-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="settings-item-text">
                            <div class="settings-item-title">Personal Data</div>
                            <div class="settings-item-description">Update your personal information and contact details
                            </div>
                        </div>
                    </div>
                    <div class="settings-item-arrow">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.08906 5L6.91406 6.175L10.7307 10L6.91406 13.825L8.08906 15L13.0891 10L8.08906 5Z"
                                fill="#9F48DB" />
                        </svg>
                    </div>
                </a>

                <a href="./business_information.html" class="settings-item">
                    <div class="settings-item-content">
                        <div class="settings-item-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="settings-item-text">
                            <div class="settings-item-title">Business Information</div>
                            <div class="settings-item-description">Manage your business details and store information</div>
                        </div>
                    </div>
                    <div class="settings-item-arrow">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.08906 5L6.91406 6.175L10.7307 10L6.91406 13.825L8.08906 15L13.0891 10L8.08906 5Z"
                                fill="#9F48DB" />
                        </svg>
                    </div>
                </a>

                <a href="./accountInfo.html" class="settings-item">
                    <div class="settings-item-content">
                        <div class="settings-item-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="settings-item-text">
                            <div class="settings-item-title">Account Details</div>
                            <div class="settings-item-description">View and edit your account information</div>
                        </div>
                    </div>
                    <div class="settings-item-arrow">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.08906 5L6.91406 6.175L10.7307 10L6.91406 13.825L8.08906 15L13.0891 10L8.08906 5Z"
                                fill="#9F48DB" />
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Security Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        Security & Privacy
                    </div>
                </div>

                <a href="./changePassword.html" class="settings-item">
                    <div class="settings-item-content">
                        <div class="settings-item-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="settings-item-text">
                            <div class="settings-item-title">Change Password</div>
                            <div class="settings-item-description">Update your account password for security</div>
                        </div>
                    </div>
                    <div class="settings-item-arrow">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.08906 5L6.91406 6.175L10.7307 10L6.91406 13.825L8.08906 15L13.0891 10L8.08906 5Z"
                                fill="#9F48DB" />
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Support Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-life-ring"></i>
                        </div>
                        Help & Support
                    </div>
                </div>

                <a href="customer-support.html" class="settings-item">
                    <div class="settings-item-content">
                        <div class="settings-item-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="settings-item-text">
                            <div class="settings-item-title">Customer Support</div>
                            <div class="settings-item-description">Get help with your account or technical issues</div>
                        </div>
                    </div>
                    <div class="settings-item-arrow">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.08906 5L6.91406 6.175L10.7307 10L6.91406 13.825L8.08906 15L13.0891 10L8.08906 5Z"
                                fill="#9F48DB" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Account Actions -->
        <div class="account-actions">
            <a href="{{ route('vendor.logout') }}" id="logout" class="action-button logout-button">
                <i class="fas fa-sign-out-alt"></i>
                Log Out
            </a>
            <a href="javascript:;" id="delete" class="action-button delete-button">
                <i class="fas fa-trash-alt"></i>
                Delete Account
            </a>
        </div>

        <!-- Delete Account Modal -->
        <div class="modal-overlay" id="deleteModal">
            <div class="modal">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="modal-title">Delete Account</h3>
                <p class="modal-description">
                    Are you sure you want to delete your account? This action cannot be undone and all your data will be
                    permanently removed.
                </p>
                <div class="modal-actions">
                    <button class="modal-button cancel" onclick="closeDeleteModal()">Cancel</button>
                    <button class="modal-button confirm" onclick="confirmDelete()">Delete Account</button>
                </div>
            </div>
        </div>
    </section>


    @include('vendors.body.footer')
@endsection
