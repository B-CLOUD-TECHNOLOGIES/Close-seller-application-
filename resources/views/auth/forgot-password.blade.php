<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('users/assets/css/bootstrap.css') }}">
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('users/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <style>
        .form-control {
            height: 50px !important;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.1rem var(--orange);
        }

        .form-label {
            font-weight: 500;
        }

        .text-primary-custom {
            color: var(--primary) !important;
            font-weight: 700;
        }

        .text-primary-custom:hover {
            color: #4b1370 !important;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="text-center my-4">
                <img src="{{ asset('onboard/closesellerlogo.png') }}" alt="Company Logo" class="img-fluid mb-3"
                    style="height: 30px;">
                <h2 class="fw-bold text-dark">Forgot Password?</h2>
                <p class="text-muted small">Enter your registered email address to receive password reset instructions.
                </p>
            </div>

            <form class="p-4 bg-white rounded-4 shadow-sm" method="POST" action="{{ route('user.password.otp.send') }}"
                id="theForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control py-2 @error('email') is-invalid @enderror"
                        id="email" placeholder="@example.com" required autofocus>
                    @error('email')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn-outline-primary w-100 py-2 mb-3 fw-semibold spin-btn">
                    <span class="btn-text">Send Reset Link</span>
                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                </button>

                <div class="text-center mt-3">
                    <small>Remember your password?
                        <a href="{{ route('login') }}" class="text-decoration-none text-orange-600 fw-medium">Login</a>
                    </small>
                </div>
            </form>

            <div class="text-center my-4">
                <small>Need help?
                    <a href="{{ url('/') }}" class="text-decoration-none text-orange-600 fw-bold">Return Home</a>
                </small>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="{{ asset('users/assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('users/assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#theForm').on('submit', function() {
                var $btn = $(this).find('.spin-btn');
                var $spinner = $btn.find('.spinner-border');
                var $text = $btn.find('.btn-text');

                // Disable button to prevent multiple submissions
                $btn.prop('disabled', true);
                $text.addClass('d-none'); // hide text
                $spinner.removeClass('d-none'); // show spinner

                // Let the form continue submitting normally
            });
        });
    </script>

    {{-- Toastr Alerts --}}
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
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>
</body>

</html>
