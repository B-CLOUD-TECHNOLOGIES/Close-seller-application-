<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - CloseSeller</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/sign-in.css') }}">
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
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body>


    <div class="container">
        <!-- Header Section -->
        <div class="selectionHeading">
            <a href="{{route ('auth.type')}}" >
                <figure>
                   <img src="{{ asset('onboard/closesellerlogo.png') }}" alt="Company Logo" class="img-fluid mb-3"
                    style="height: 30px;">
                </figure>
            </a>
            <h3>Welcome back!</h3>
        </div>
        <p class="headingText">
            Manage your business like a pro, track sales.
        </p>

        <!-- Form Container -->
        <section class="authCon">
            <form id="loginForm" method="POST" action="{{ route('vendor.login.submit') }}">
                @csrf
                <article>
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Email Address" name="email">
                    @error('email')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <article>
                    <label for="password">Password</label>
                    <div>
                        <input type="password" id="password" placeholder="********" name="password">
                        <i class="fa-regular fa-eye" style="cursor: pointer;"></i>
                    </div>
                    @error('password')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                    <div class="forgot-password">
                        <a href="{{ route('vendor.forgot.password') }}">Forgot Password?</a>
                    </div>
                </article>

                <button type="submit" id="submitBtn">
                    <span class="spinner"></span>
                    Sign In
                </button>
            </form>

            <div class="agree">
                <h3>Don't have an account? &nbsp; <a href="{{ route('vendor.register') }}">Signup</a></h3>
            </div>
            <div class="agree">
                <h3>Log in | Create your&nbsp; <a href="{{ url('login') }}">User account</a></h3>
            </div>
        </section>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendors/assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Password visibility toggle
            const eyeIcon = document.querySelector('.fa-eye');
            const passwordInput = document.getElementById('password');

            eyeIcon.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
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
