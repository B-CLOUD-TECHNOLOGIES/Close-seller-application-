<!DOCTYPE html>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f3ff;
            height: 100vh;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .text-head {
            text-align: center;
        }

        h1 {
            font-size: 32px;
            font-weight: 600;
            color: #55048e;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        .form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 25px;
            align-items: center;
        }

        .input-div {
            width: 100%;
        }

        .email-text {
            color: #55048e;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 15px;
            display: block;
        }

        .otp-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 15px 0;
        }

        .otp-input {
            width: 30px;
            height: 40px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid #55048e;
            border-radius: 8px;
            background-color: #f9f9ff;
            color: #55048e;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            outline: none;
            border-color: #713899;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(85, 4, 142, 0.1);
        }

        .otp-input::-webkit-outer-spin-button,
        .otp-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input[type=number] {
            -moz-appearance: textfield;
        }

        button {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            background-color: #55048e;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #713899;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .resend-section {
            text-align: center;
            margin-top: 20px;
        }

        .resend-link {
            color: #55048e;
            text-decoration: none;
            font-weight: 500;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        .timer {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 30px 20px;
            }

            h1 {
                font-size: 28px;
            }

            .otp-input {
                width: 35px;
                height: 45px;
                font-size: 20px;
            }
        }
    </style>
    <style>
        .close,
        .message {
            font-size: 0.8rem !important;
            color: #fff !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('users/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body>
    <div class="container">
        <div class="text-head">
            <h1>OTP Verification</h1>
            <p>We've sent a 6-digit verification code to your
                <b>{{ $email }}</b>
            </p>
        </div>


        <form class="form" method="POST" action="{{ route('user.password.otp.verify') }}" id="signUpForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="input-div">
                <label class="email-text">Enter OTP Code</label>
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
            </div>

            <button type="submit" name="verify_otp" id="verifyBtn">
                <div class="spinner"></div> Verify OTP
            </button>
        </form>

        <div class="resend-section">
            <p>Didn't receive the code?</p>
            <div class="timer" id="timer">Resend available in <span id="countdown">60</span> seconds</div>
            <form method="POST" style="display: none;" action="{{ route('user.password.otp.send') }}" id="resendForm">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <button type="submit" name="resend_otp" class="resend-link"
                    style="background: none; border: none; padding: 0; font-size: 14px;">
                    Resend OTP
                </button>
            </form>
        </div>
    </div>





    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="{{ asset('users/assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('users/assets/js/jquery.js') }}"></script>
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
