<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
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
                <h2 class="fw-bold text-dark">Reset Password</h2>
                <p class="text-muted small">Enter your new password below</p>
            </div>

            <form class="p-4 bg-white rounded-4 shadow-sm" method="POST" action="{{ route('user.reset-password') }}" id="theForm">
                @csrf

                {{-- Hidden Email Field --}}
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" name="password"
                            class="form-control py-2 @error('password') is-invalid @enderror" id="password"
                            placeholder="*********" required>
                        <span class="input-group-text bg-white border-start-0">
                            <span class="material-icons text-secondary toggle-password"
                                style="cursor:pointer;">visibility</span>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation"
                            class="form-control py-2 @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" placeholder="*********" required>
                        <span class="input-group-text bg-white border-start-0">
                            <span class="material-icons text-secondary toggle-password"
                                style="cursor:pointer;">visibility</span>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn-outline-primary w-100 py-2 mb-3 fw-semibold spin-btn">
                    <span class="btn-text">Reset Password</span>
                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                </button>

                <div class="text-center mt-3">
                    <small>Remembered your password?
                        <a href="{{ route('login') }}" class="text-decoration-none text-orange-600 fw-medium">Login</a>
                    </small>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
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
                const input = $(this).closest('.input-group').find('input');
                const icon = $(this);
                const isPassword = input.attr('type') === 'password';
                input.attr('type', isPassword ? 'text' : 'password');
                icon.text(isPassword ? 'visibility_off' : 'visibility');
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
