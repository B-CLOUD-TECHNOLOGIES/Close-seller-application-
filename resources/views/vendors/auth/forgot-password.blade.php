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
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/forget-password.css') }}">
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body>


    <div class="container">
        <!-- Logo Section -->
        <div class="logo-section">
            <!-- Logo would go here -->
            <div style="color: var(--purple); font-size: 24px; font-weight: 700;">CloseSeller</div>
        </div>

        <!-- Header Section -->
        <div class="selectionHeading">
            <a href="./signIn.php">
                <figure>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#701d9d" />
                    </svg>
                </figure>
            </a>
            <h3>Forgot Password?</h3>
        </div>
        <p class="headingText">
            Enter your email address below, we will email you instructions to reset it
        </p>

        <!-- Form Container -->
        <section class="authCon">
            <form id="forgotPasswordForm" method="POST" action="{{ route('vendor.forgot.password.otp') }}">
                @csrf
                <article>
                    <label for="email">Email Address</label>
                    <input type="email" id="email" placeholder="Enter your email address" name="email">
                    @error('email')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <button type="submit" id="submitBtn">
                    <span class="spinner"></span>
                    Send Reset Instructions
                </button>
            </form>

            <div class="agree">
                <h3>Remember your password? &nbsp; <a href="{{ route('vendor.login') }}">Back to Login</a></h3>
            </div>
        </section>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendors/assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
