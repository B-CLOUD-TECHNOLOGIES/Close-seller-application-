<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User-Type Selection | CloseSeller</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('users/assets/css/bootstrap.css') }}">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/706f90924a.js" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('users/assets/css/custom.css') }}">

    <style>
        /* Radio button styling */
        .radio-circle {
            appearance: none;
            -webkit-appearance: none;
            width: 24px;
            height: 24px;
            border: 2px solid #6c757d;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .radio-circle:checked {
            border-color: var(--primary-color);
        }

        .radio-circle:checked::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px;
            height: 12px;
            background-color: var(--primary-color);
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .card.active {
            border: 2px solid var(--primary-color);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .continue-btn {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 600;
        }

        .continue-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-body d-flex flex-column min-vh-100 text-dark">

    <div class="container my-auto py-5">
        <main class="mt-5">
            <h1 class="text-center mb-5 fw-bold" style="color: var(--purple);">
                How can CloseSeller help you today?
            </h1>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">

                    <!-- Card 1 -->
                    <div class="card shadow-sm border-0 mb-4 rounded-4 option-card" data-type="vendor"
                        style="box-shadow: var(--card-shadow); cursor: pointer;">
                        <div class="card-body p-4 d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-semibold" style="color: var(--text-dark);">
                                    Move my business online
                                </h5>
                                <p class="small text-muted mb-0">
                                    I want to start selling my products online
                                </p>
                            </div>
                            <input type="radio" name="user_type" value="seller" class="radio-circle">
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="card shadow-sm border-0 mb-4 rounded-4 option-card" data-type="user"
                        style="box-shadow: var(--card-shadow); cursor: pointer;">
                        <div class="card-body p-4 d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-semibold" style="color: var(--text-dark);">
                                    Purchase from CloseSeller
                                </h5>
                                <p class="small text-muted mb-0">
                                    I want to shop from CloseSeller
                                </p>
                            </div>
                            <input type="radio" name="user_type" value="buyer" class="radio-circle">
                        </div>
                    </div>

                    <!-- Single Continue Button -->
                    <button id="continueBtn" class="btn w-100 mt-4 continue-btn rounded-3" disabled>
                        Continue
                    </button>

                </div>
            </div>
        </main>
    </div>

    <footer class="mt-auto bg-body">
        <div class="container text-center py-3">
            <button class="d-inline-flex align-items-center gap-1 fw-medium border-0 shadow-sm">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                Back
            </button>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="{{ asset('users/assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('users/assets/js/jquery.js') }}"></script>

    <!-- JS Logic -->
    <script>
        const cards = document.querySelectorAll('.option-card');
        const radios = document.querySelectorAll('.radio-circle');
        const continueBtn = document.getElementById('continueBtn');

        let selectedType = null;

        // When a card is clicked
        cards.forEach(card => {
            card.addEventListener('click', () => {
                // Clear previous active selection
                cards.forEach(c => c.classList.remove('active'));
                radios.forEach(r => r.checked = false);

                // Mark this one active
                card.classList.add('active');
                const radio = card.querySelector('.radio-circle');
                radio.checked = true;

                // Enable button
                selectedType = card.dataset.type;
                continueBtn.disabled = false;
            });
        });

        // Handle Continue click
        continueBtn.addEventListener('click', () => {
            if (!selectedType) return alert('Please select an option first.');

            // Redirect or handle based on user type
            if (selectedType === 'vendor') {
                window.location.href = '{{ url("/vendors/register") }}'; // replace with actual seller page
            } else if (selectedType === 'user') {
                window.location.href = '{{ url("/login") }}'; // replace with actual buyer page
            }
        });
    </script>
    <script>
        // ✅ Detect Android/iOS mobile back button
        $(document).ready(function() {
            // Push a dummy state to history
            history.pushState(null, null, location.href);

            // Listen for back navigation
            $(window).on("popstate", function() {
                // Go to previous page
                window.history.back();
            });

            // Optional: prevent double trigger on same page
            window.onpopstate = function() {
                window.history.back();
            };
        });
    </script>

</body>

</html>
