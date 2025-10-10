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
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/otp-verify.css') }}">
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body>


    <div class="container">
        <!-- Header Section -->
        <div class="selectionHeading">
            <a href="{{ route('vendor.forgot.password') }}">
                <figure>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#701d9d" />
                    </svg>
                </figure>
            </a>
            <h3>OTP Verification</h3>
        </div>

        <p class="headingText">
            We've sent a 6-digit verification code to your email
        </p>

        <div class="email-display">
            <strong id="userEmail">{{ $email }}</strong>
        </div>

        <!-- Form Container -->
        <section class="authCon">
            <form id="otpForm" method="POST" action="{{ route('vendor.password.otp.verify') }}">
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">
                <div class="otp-container">
                    <input type="number" name="otp1" class="otp-input" maxlength="1" min="0" max="9"
                        required>
                    <input type="number" name="otp2" class="otp-input" maxlength="1" min="0" max="9"
                        required>
                    <input type="number" name="otp3" class="otp-input" maxlength="1" min="0" max="9"
                        required>
                    <input type="number" name="otp4" class="otp-input" maxlength="1" min="0" max="9"
                        required>
                    <input type="number" name="otp5" class="otp-input" maxlength="1" min="0" max="9"
                        required>
                    <input type="number" name="otp6" class="otp-input" maxlength="1" min="0" max="9"
                        required>
                </div>

                <button type="submit" id="verifyBtn" disabled>
                    <span class="spinner"></span>
                    Verify OTP
                </button>
            </form>

            <div class="resend-section">
                <p>Didn't receive the code?</p>
                <div class="timer" id="timer">Resend available in <span id="countdown">60</span> seconds</div>
                <form method="POST" style="display: none;" action="{{ route('vendor.forgot.password.otp') }}"
                    id="resendForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button class="resend-btn" id="resendBtn" disabled>
                        Resend OTP
                    </button>
                </form>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendors/assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    </script>

    <script>
        // Enhanced OTP input handling
        const otpInputs = document.querySelectorAll('.otp-input');
        const verifyBtn = document.getElementById('verifyBtn');

        // Auto-focus and validation
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Only allow single digit
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1);
                }

                // Auto focus next input
                if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                // Enable/disable verify button
                checkOTPComplete();
            });

            input.addEventListener('keydown', (e) => {
                // Handle backspace
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text/plain').replace(/[^0-9]/g, '');

                if (pasteData.length === otpInputs.length) {
                    otpInputs.forEach((input, idx) => {
                        input.value = pasteData[idx] || '';
                    });
                    otpInputs[otpInputs.length - 1].focus();
                    checkOTPComplete();
                }
            });
        });

        function checkOTPComplete() {
            const allFilled = Array.from(otpInputs).every(input => input.value.length === 1);
            verifyBtn.disabled = !allFilled;
        }

        // Resend timer
        let timeLeft = 60;
        const timerElement = document.getElementById('timer');
        const countdownElement = document.getElementById('countdown');
        const resendForm = document.getElementById('resendForm');

        const countdown = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerElement.style.display = 'none';
                resendForm.style.display = 'block';
            }
        }, 1000);

        // Initialize
        checkOTPComplete();
        otpInputs[0].focus();
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
