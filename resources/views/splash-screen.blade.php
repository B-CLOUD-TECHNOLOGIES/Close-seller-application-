<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Splash Screen | CloseSeller</title>

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
        /* Splash Screen Styles */
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg,
                    var(--primary-color),
                    var(--primary-color));
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
            color: #fff;
            font-family: "Poppins", sans-serif;
        }

        #splash-logo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: #6d28d9;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            animation: popIn 1.2s ease forwards;
        }

        #splash-text {
            margin-top: 1rem;
            font-size: 1.25rem;
            font-weight: 500;
            opacity: 0;
            animation: fadeInUp 1.5s ease forwards 1.2s;
        }

        /* Animations */
        @keyframes popIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hide splash screen on desktop */
        @media (min-width: 992px) {
            #splash-screen {
                display: none !important;
            }
        }

        /* Initially hide main content */
        #main-content {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Splash Screen -->
    <div id="splash-screen">
        <div id="splash-logo">CS</div>
        <div id="splash-text">CloseSeller</div>
    </div>

    <!-- Main Content -->
    <div id="main-content">
        <!-- Your existing content (home page) goes here -->
        <!-- Example header -->
        <header class="sticky-top bg-white shadow-sm p-3 z-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 fw-bold mb-0 text-purple-600">CloseSeller</h1>
            </div>
        </header>
        <!-- Rest of your existing code remains unchanged -->
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="{{ asset('users/assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('users/assets/js/jquery.js') }}"></script>

    <!-- JS Logic -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Detect if on mobile
            const isMobile = window.matchMedia("(max-width: 991px)").matches;

            if (isMobile) {
                setTimeout(() => {
                    // Logic to redirect depending on logged-in user role
                    const userType = localStorage.getItem("userType"); // "user" or "vendor"

                    if (userType === "vendor") {
                        window.location.href = "./vendor/index.html";
                    } else if (userType === "user") {
                        window.location.href = "./users/index.html";
                    } else {
                        // If not logged in, show home page
                        document.getElementById("splash-screen").style.display = "none";
                        // document.getElementById("main-content").style.display = "block";
                        window.location.href = "./users/index.html";
                    }
                }, 5000); // 5 seconds
            } else {
                // On desktop, skip splash
                document.getElementById("splash-screen").style.display = "none";
                document.getElementById("main-content").style.display = "block";
            }
        });
    </script>
</body>

</html>
