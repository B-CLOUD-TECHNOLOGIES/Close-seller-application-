<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/regvendor.css') }}">
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
        <section class="selectionHeading">
            <a href="{{ route('vendor.login') }}" aria-label="Back">
                <!-- Inline SVG for left arrow -->
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 19L8 12L15 5" stroke="#460475" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
            <h3>Create a CloseSeller<br />Account</h3>
        </section>

        <p class="headingText">
            Take your business online easily
        </p>

        <section class="authCon">
            <form action="{{ route('vendor.store') }}" method="POST" id="signUpForm">
                @csrf

                <article>
                    <label for="first_name">First name *</label>
                    <input type="text" id="first_name" placeholder="Your first name"
                        class=" @error('firstname') is-invalid @enderror" name="firstname">
                    @error('firstname')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <article>
                    <label for="last_name">Surname *</label>
                    <input type="text" id="last_name" placeholder="Last name" name="lastname">
                    @error('lastname')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <article>
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" placeholder="Your email address" name="email">
                    @error('email')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <article>
                    <label for="phone">Phone number *</label>
                    <input type="tel" id="phone" placeholder="Your phone number" name="phone">
                    @error('phone')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <article>
                    <label for="password">Password *</label>
                    <div>
                        <input type="password" id="password"
                            placeholder="At least 8 characters with uppercase, lowercase & symbol" name="password">
                        <i class="fa-regular fa-eye" onclick="togglePassword('password', this)"></i>
                    </div>
                    @error('password')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <article>
                    <label for="confirm_password">Confirm Password *</label>
                    <div>
                        <input type="password" id="confirm_password" placeholder="Confirm your password"
                            name="password_confirmation">
                        <i class="fa-regular fa-eye" onclick="togglePassword('confirm_password', this)"></i>
                    </div>
                    @error('confirm_password')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </article>

                <section>
                    <label>How did you hear about CloseSeller?</label>
                    <div>
                        <select name="about">
                            <option value="" disabled selected>
                                Select an option
                            </option>
                            <option value="1">Instagram</option>
                            <option value="2">WhatsApp</option>
                            <option value="3">Facebook</option>
                            <option value="4">Social Media</option>
                            <option value="5">Family and Friends</option>
                        </select>

                    </div>
                    @error('about')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </section>

                <button type="submit" name="vendor_signup" id="submitBtn">
                    <div class="spinner" id="spinner"></div>
                    <span id="btnText">Create Account</span>
                </button>

            </form>
        </section>

        <div class="textEnd">
            <p>By continuing, you agree to the <span>CloseSeller<br />Agreement</span> and <span>Privacy Policy</span>
            </p>
        </div>
    </div>

</body>
<script src="{{ asset('vendors/assets/js/jquery.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        $('.fa-eye').click(function() {
            const input = $(this).siblings('input');
            const isPassword = input.attr('type') === 'password';
            input.attr('type', isPassword ? 'text' : 'password');
            $(this).toggleClass('fa-eye fa-eye-slash');
        });
    });

    document.getElementById('phone').addEventListener('input', function (e) {
    let value = e.target.value;

    // Allow only digits and one leading '+'
    value = value.replace(/[^0-9+]/g, ''); // Remove invalid characters
    if (value.indexOf('+') > 0) {
        value = value.replace(/\+/g, ''); // Remove '+' if not at the start
    } else if (value.indexOf('+') === 0) {
        value = '+' + value.slice(1).replace(/\+/g, ''); // Keep only the first '+'
    }

    e.target.value = value;
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

</html>
