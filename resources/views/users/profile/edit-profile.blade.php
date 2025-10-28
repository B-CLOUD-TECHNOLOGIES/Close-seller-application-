@extends('users.user-master')


@section('users')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/personal-data.css') }}">

    @php
        use App\Models\User;
        $id = Auth::user()->id;
        $user = User::find($id);
    @endphp

    <div class="header sticky-top top-0 align-items-end">
        <a href="{{ route('user.dashboard') }}" class="back-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z"
                    fill="#1C1C1C" />
            </svg>
        </a>
        <h1>Personal Details</h1>
        <div class="header-spacer"></div>
    </div>

    <form id="personalDataForm"  enctype="multipart/form-data">
        @csrf
        <div class="profile-section">
            <label for="image" style="cursor: pointer;">
                <div class="profile-image-container">
                    <img src="{{ !empty($user->image) ? asset($user->image) : asset('uploads/no_image.png') }}"
                        class="profile-img" id="showImage" alt="Profile" />
                    <div class="edit-badge">
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.05 3L13.47 5.42L5.42 13.47L3 13.97L3.5 11.55L11.05 3ZM14.7 4.2L12.3 1.8L13.5 0.6C13.89 0.21 14.53 0.21 14.92 0.6L17.4 3.08C17.79 3.47 17.79 4.11 17.4 4.5L16.2 5.7L14.7 4.2Z"
                                fill="white" />
                        </svg>
                    </div>
                </div>
                <span class="edit-label">Click to change photo</span>
                <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/webp">
            </label>
        </div>

        <div class="form-container">
            <div class="form-group">
                <label for="username">Display Name</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" class="form-input"
                        placeholder="Enter your Username" value="{{ $user->username }}" required />
                    <svg class="input-icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2C6.69 2 4 4.69 4 8C4 11.31 6.69 14 10 14C13.31 14 16 11.31 16 8C16 4.69 13.31 2 10 2ZM10 5C11.1 5 12 5.9 12 7C12 8.1 11.1 9 10 9C8.9 9 8 8.1 8 7C8 5.9 8.9 5 10 5ZM10 16.2C7.5 16.2 5.29 14.92 4 13C4.03 11 8 9.9 10 9.9C11.99 9.9 15.97 11 16 13C14.71 14.92 12.5 16.2 10 16.2Z" />
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="firstname">First Name</label>
                <div class="input-wrapper">
                    <input type="text" id="firstname" name="firstname" class="form-input"
                        placeholder="Enter your first name" value="{{ $user->firstname }}" required />
                    <svg class="input-icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2C6.69 2 4 4.69 4 8C4 11.31 6.69 14 10 14C13.31 14 16 11.31 16 8C16 4.69 13.31 2 10 2ZM10 5C11.1 5 12 5.9 12 7C12 8.1 11.1 9 10 9C8.9 9 8 8.1 8 7C8 5.9 8.9 5 10 5ZM10 16.2C7.5 16.2 5.29 14.92 4 13C4.03 11 8 9.9 10 9.9C11.99 9.9 15.97 11 16 13C14.71 14.92 12.5 16.2 10 16.2Z" />
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name</label>
                <div class="input-wrapper">
                    <input type="text" id="lastname" name="lastname" class="form-input"
                        placeholder="Enter your last name" value="{{ $user->lastname }}" required />
                    <svg class="input-icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2C6.69 2 4 4.69 4 8C4 11.31 6.69 14 10 14C13.31 14 16 11.31 16 8C16 4.69 13.31 2 10 2ZM10 5C11.1 5 12 5.9 12 7C12 8.1 11.1 9 10 9C8.9 9 8 8.1 8 7C8 5.9 8.9 5 10 5ZM10 16.2C7.5 16.2 5.29 14.92 4 13C4.03 11 8 9.9 10 9.9C11.99 9.9 15.97 11 16 13C14.71 14.92 12.5 16.2 10 16.2Z" />
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <div class="input-wrapper">
                    <input type="tel" id="phone" name="phone" class="form-input" placeholder="+234 800 000 0000"
                        value="{{ $user->phone }}" required />
                    <svg class="input-icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.94C17.55 15.31 18.76 15.51 20 15.51C20.55 15.51 21 15.96 21 16.51V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" />
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <div class="input-wrapper">
                    <select id="gender" name="gender" class="form-input" required>
                        <option value="" disabled>Select your gender</option>
                        <option value="male" selected>Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                    </select>
                </div>
            </div>


        </div>

        <div class="save-button-container">
            <button type="submit" class="save-btn">
                <span class="spinner"></span>
                Save Changes
            </button>
        </div>
    </form>


    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('showImage').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('phone').addEventListener('input', function(event) {
            let value = event.target.value;
            let newValue = value.replace(/[^+0-9]/g, '');

            if (newValue.indexOf('+') !== -1) {
                newValue = newValue.replace(/\+/g, '');
                newValue = '+' + newValue;
            }

            if (newValue.length > 14) {
                newValue = newValue.substring(0, 14);
            }

            event.target.value = newValue;
        });


        $('#personalDataForm').on('submit', function(e) {
            e.preventDefault();

            const submitBtn = $(this).find('.save-btn');
            submitBtn.addClass('loading').prop('disabled', true);

            // ✅ Create FormData object to include file uploads
            const formData = new FormData(this);

            // ✅ Manually validate required fields (except image)
            const username = formData.get('username')?.trim();
            const firstname = formData.get('firstname')?.trim();
            const lastname = formData.get('lastname')?.trim();
            const phone = formData.get('phone')?.trim();
            const gender = formData.get('gender')?.trim();

            if (!username || !firstname || !lastname || !phone) {
                toastr.error('All fields except the image are required.');
                submitBtn.removeClass('loading').prop('disabled', false);
                return;
            }

            // ✅ AJAX request
            $.ajax({
                url: `{{ route('user.update.profile') }}`,
                type: 'POST',
                dataType: 'json',
                processData: false, // Required for file uploads
                contentType: false, // Required for file uploads
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    submitBtn.removeClass('loading').prop('disabled', false);
                    toastr.success('Your personal details have been updated successfully!');
                    console.log(response);
                },
                error: function(xhr) {
                    submitBtn.removeClass('loading').prop('disabled', false);
                    toastr.error('An error occurred while updating your details.');
                    console.error(xhr.responseText);
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const elements = ['.profile-section', '.form-container', '.save-button-container'];

            elements.forEach((selector, index) => {
                const element = document.querySelector(selector);
                if (element) {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        element.style.transition =
                            'opacity 0.6s ease, transform 0.6s ease';
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, index * 150);
                }
            });

            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.01)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            const profileContainer = document.querySelector('.profile-image-container');
            if (profileContainer) {
                profileContainer.addEventListener('mouseenter', function() {
                    this.querySelector('.edit-badge').style.transform =
                        'scale(1.1) rotate(15deg)';
                });

                profileContainer.addEventListener('mouseleave', function() {
                    this.querySelector('.edit-badge').style.transform = 'scale(1) rotate(0deg)';
                });
            }
        });

        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '' && this.hasAttribute('required')) {
                    this.style.borderColor = 'var(--danger-color)';
                    setTimeout(() => {
                        this.style.borderColor = '';
                    }, 2000);
                }
            });

            input.addEventListener('input', function() {
                if (this.style.borderColor === 'rgb(220, 53, 69)') {
                    this.style.borderColor = '';
                }
            });
        });

        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 4px 30px rgba(112, 29, 157, 0.15)';
            } else {
                header.style.boxShadow = '0 2px 20px rgba(112, 29, 157, 0.08)';
            }
        });
    </script>
@endsection
