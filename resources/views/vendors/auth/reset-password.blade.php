<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - CloseSeller</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/bootstrap.css') }}">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/706f90924a.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('vendors/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/reset-password.css') }}">
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body>


    <div class="container">
        <!-- Logo Section -->
        <div class="logo-section">
            <div style="color: var(--purple); font-size: 24px; font-weight: 700;">CloseSeller</div>
        </div>

        <!-- Header Section -->
        <div class="selectionHeading">
            <a href="{{ route('vendor.login') }}">
                <figure>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#701d9d" />
                    </svg>
                </figure>
            </a>
            <h3>Reset Password</h3>
        </div>
        <p class="headingText">
            Create a new strong password for your account
        </p>

        <!-- Form Container -->
        <section class="authCon">
            <form id="resetPasswordForm" method="POST" action="{{ route('vendor.reset.password') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">
                <article>
                    <label for="newpassword">New Password</label>
                    <div>
                        <input type="password" id="newpassword" name="password" placeholder="Enter new password"
                            required>
                        <i class="fa-regular fa-eye" style="cursor: pointer;"></i>
                    </div>
                    @error('password')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror

                    <!-- Password Requirements -->
                    <div class="password-requirements">
                        <h4>Password must contain:</h4>
                        <ul class="requirements-list" id="passwordRequirements">
                            <li id="req-length" class="invalid">At least 8 characters</li>
                            <li id="req-uppercase" class="invalid">One uppercase letter</li>
                            <li id="req-lowercase" class="invalid">One lowercase letter</li>
                            <li id="req-number" class="invalid">One number</li>
                            <li id="req-special" class="invalid">One special character</li>
                        </ul>
                    </div>
                </article>

                <article>
                    <label for="confirmpassword">Confirm Password</label>
                    <div>
                        <input type="password" id="confirmpassword" name="password_confirmation"
                            placeholder="Confirm your password" required>
                        <i class="fa-regular fa-eye" style="cursor: pointer;"></i>
                    </div>
                    @error('password_confirmation')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                        <div class="helper-text">Must match the new password exactly</div>
                    </article>

                    <button type="submit" id="submitBtn">
                        <span class="spinner"></span>
                        Reset Password
                    </button>
                </form>
            </section>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('vendors/assets/js/jquery.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Preloader
                window.addEventListener('load', function() {
                    const preloader = document.querySelector('.preloader');
                    preloader.style.opacity = '0';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 500);
                });

                // Password visibility toggle
                const eyeIcons = document.querySelectorAll('.fa-eye');
                eyeIcons.forEach(icon => {
                    icon.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('input');
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    });
                });

                // Password validation
                const passwordInput = document.getElementById('newpassword');
                const confirmPasswordInput = document.getElementById('confirmpassword');
                const requirements = {
                    length: document.getElementById('req-length'),
                    uppercase: document.getElementById('req-uppercase'),
                    lowercase: document.getElementById('req-lowercase'),
                    number: document.getElementById('req-number'),
                    special: document.getElementById('req-special')
                };

                function validatePassword(password) {
                    const hasLength = password.length >= 8;
                    const hasUppercase = /[A-Z]/.test(password);
                    const hasLowercase = /[a-z]/.test(password);
                    const hasNumber = /[0-9]/.test(password);
                    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

                    // Update requirement indicators
                    requirements.length.className = hasLength ? 'valid' : 'invalid';
                    requirements.uppercase.className = hasUppercase ? 'valid' : 'invalid';
                    requirements.lowercase.className = hasLowercase ? 'valid' : 'invalid';
                    requirements.number.className = hasNumber ? 'valid' : 'invalid';
                    requirements.special.className = hasSpecial ? 'valid' : 'invalid';

                    return hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial;
                }

                function validateForm() {
                    let isValid = true;
                    const password = passwordInput.value;
                    const confirmPassword = confirmPasswordInput.value;
                    const passwordError = document.getElementById('passwordError');
                    const confirmPasswordError = document.getElementById('confirmPasswordError');

                    // Reset errors
                    passwordError.textContent = '';
                    confirmPasswordError.textContent = '';
                    passwordInput.classList.remove('input-success');
                    confirmPasswordInput.classList.remove('input-success');

                    // Password validation
                    if (!password) {
                        passwordError.textContent = 'Password is required';
                        isValid = false;
                    } else if (!validatePassword(password)) {
                        passwordError.textContent = 'Password does not meet all requirements';
                        isValid = false;
                    } else {
                        passwordInput.classList.add('input-success');
                    }

                    // Confirm password validation
                    if (!confirmPassword) {
                        confirmPasswordError.textContent = 'Please confirm your password';
                        isValid = false;
                    } else if (confirmPassword !== password) {
                        confirmPasswordError.textContent = 'Passwords do not match';
                        isValid = false;
                    } else {
                        confirmPasswordInput.classList.add('input-success');
                    }

                    return isValid;
                }

                // Real-time password validation
                passwordInput.addEventListener('input', function() {
                    validatePassword(this.value);
                    if (this.value && validatePassword(this.value)) {
                        this.classList.add('input-success');
                        document.getElementById('passwordError').textContent = '';
                    } else {
                        this.classList.remove('input-success');
                    }

                    // Check confirm password match in real-time
                    if (confirmPasswordInput.value) {
                        if (confirmPasswordInput.value === this.value) {
                            confirmPasswordInput.classList.add('input-success');
                            document.getElementById('confirmPasswordError').textContent = '';
                        } else {
                            confirmPasswordInput.classList.remove('input-success');
                        }
                    }
                });

                confirmPasswordInput.addEventListener('input', function() {
                    if (this.value === passwordInput.value) {
                        this.classList.add('input-success');
                        document.getElementById('confirmPasswordError').textContent = '';
                    } else {
                        this.classList.remove('input-success');
                        if (this.value) {
                            document.getElementById('confirmPasswordError').textContent =
                                'Passwords do not match';
                        }
                    }
                });

            });
        </script>

        @if ($errors->any())
            <script>
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}")
                @endforeach
            </script>
        @endif
        <script>
            @if (Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}"
                switch (type) {
                    case 'info':
                        toastr.info(" {{ Session::get('message') }} ");
                        break;

                    case 'success':
                        toastr.success(" {{ Session::get('message') }} ");
                        break;

                    case 'warning':
                        toastr.warning(" {{ Session::get('message') }} ");
                        break;

                    case 'error':
                        toastr.error(" {{ Session::get('message') }} ");
                        break;
                }
            @endif
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script src="{{ asset('users/assets/js//code.js') }}"></script>
    </body>

    </html>
