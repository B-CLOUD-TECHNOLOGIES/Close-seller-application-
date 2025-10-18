<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log In</title>
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
            border-color: none !important;
            box-shadow: 0 0 0 0.1rem var(--orange);
        }

        .divider {
            position: relative;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #ccc;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .divider span {
            background: var(--light-purple);
            padding: 0 10px;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 500;
        }

        .text-primary-custom {
            color: var(--primary) !important;
            font-weight: 700
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
                <h2 class="fw-bold text-dark">Welcome Back !</h2>
            </div>

            <form class="p-4 bg-white rounded-4 shadow-sm" method="POST" action="{{ route('login') }}" id="theForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control py-2  @error('email') is-invalid @enderror" name="email"
                        id="email" placeholder="@example.com">
                    @error('email')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password"
                            class="form-control py-2 @error('password') is-invalid @enderror" id="password"
                            placeholder="*********">
                        <span class="input-group-text bg-white border-start-0">
                            <span class="material-icons text-secondary toggle-password"
                                style="cursor:pointer;">visibility</span>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-end mb-3">
                    <small class="text-muted">Forgot Password? <a href="{{ route('password.request') }}"
                            class="text-decoration-none text-primary-custom">Click here</a></small>
                </div>

                <button type="submit" class="btn-outline-primary w-100 py-2 mb-3 fw-semibold spin-btn">
                    <span class="btn-text">Log In</span>
                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                </button>


                <div class="divider my-4"><span>OR</span></div>


                <div class="d-flex justify-content-center gap-4">
                    <button type="button"
                        class="btn btn-light border mb-2 d-flex align-items-center justify-content-center rounded-circle"
                        style="width: 50px; height: 50px;">
                        <img src="{{ asset('onboard/google.png') }}" alt="Google" style="height: 20px; width: 20px;">
                    </button>

                    <button type="button"
                        class="btn btn-light border mb-2 d-flex align-items-center justify-content-center rounded-circle"
                        style="width: 50px; height: 50px;">
                        <img src="{{ asset('onboard/apple.png') }}" alt="Apple" style="height: 20px; width: 20px;">
                    </button>
                </div>


                <div class="text-center mt-3">
                    <small>Don't have an account yet?
                        <a href="{{ url('/register') }}"
                            class="text-decoration-none text-orange-600 fw-medium">Signup</a>
                    </small>
                </div>
            </form>

            <div class="text-center my-4">
                <small>Log in | Create your
                    <a href="{{ url('vendors/login') }}" class="text-decoration-none text-orange-600 fw-bold">Business
                        account</a>
                </small>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="{{ asset('users/assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('users/assets/js/jquery.js') }}"></script>

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

    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                const input = $('#password');
                const icon = $(this);
                const isPassword = input.attr('type') === 'password';

                // Toggle input type
                input.attr('type', isPassword ? 'text' : 'password');

                // Toggle icon text between visibility and visibility_off
                icon.text(isPassword ? 'visibility_off' : 'visibility');
            });
        })
    </script>
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
