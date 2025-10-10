<?php

// if ($session->is_signed_in()) {
//     redirect('../../../index.php');
// }

// setcookie('onboarding_shown', 'true', time() + 365 * 24 * 60 * 60, '/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Screen</title>
</head>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        list-style: none;
        text-decoration: none;
    }

    :root {
        --general-font-family: "Poppins", sans-serif;
    }

    html {
        font-size: 62.5%;
    }

    body {
        font-family: var(--general-font-family);
        background-color: #f2f3ff;
        display: none;
    }

    @media (max-width: 885px) {
        body {
            display: block;
        }

        .imgWrap {
            position: relative;
            display: flex;
            flex-flow: column nowrap;
            max-height: 100vh;
            min-height: 100vh;
        }

        .imgWrap .onboardImg {
            width: 100%;
            height: 800px;
        }

        .imgWrap article {
            background-color: #f2f3ff;
            display: flex;
            position: relative;
            flex-flow: column nowrap;
        }

        .imgWrap article img {
            width: 100%;
            margin-top: -31rem;
            height: 600px;
        }

        .imgWrap article div {
            display: flex;
            flex-flow: column nowrap;
            gap: 1rem;
            width: 90%;
            margin: 0 auto;
            position: absolute;
            overflow: hidden;
            left: 0;
            top: -5rem;
            right: 0;
        }

        .imgWrap article h2 {
            font-family: var(--general-font-family);
            font-size: 32px;
            font-weight: 600;
            line-height: 42px;
            text-align: center;
            color: #000000;
            width: 318px;
            margin: 0 auto;
        }

        .imgWrap p {
            font-family: Karla;
            font-size: 20px;
            font-weight: 400;
            line-height: 28px;
            text-align: center;
            color: #1d1b21;
            margin-bottom: 3rem;
        }

        /* ✅ Unified button styling (Next + Get Started) */
        .imgWrap button,
        .imgWrap a button {
            padding: 16px;
            border-radius: 12px;
            /* Even on all sides */
            background-color: #55048e;
            border: none;
            font-family: var(--general-font-family);
            font-size: 14px;
            font-weight: 500;
            line-height: 21px;
            text-align: center;
            color: #f2f3ff;
            width: 100%;
            cursor: pointer;
            display: block;
        }

        .imgWrap button:hover,
        .imgWrap a button:hover {
            background-color: #6c14b8;
        }

        .imgWrap a {
            font-family: var(--general-font-family);
            font-size: 14px;
            font-weight: 500;
            line-height: 21px;
            text-align: center;
            color: #55048e;
            width: 100%;
            margin:1rem 0;
            text-align: center;
        }
    }

    @media (max-width: 601px) {
        .imgWrap .onboardImg {
            width: 100%;
            height: 600px;
        }

        .imgWrap article img {
            margin-top: -20rem;
            height: 400px;
        }
    }

    @media (max-width: 377px) {
        .imgWrap .onboardImg {
            width: 100%;
            height: 500px;
        }

        .imgWrap article img {
            margin-top: -20rem;
            height: 400px;
        }

        .imgWrap article div {
            top: -7rem;
        }

        .imgWrap article h2 {
            font-size: 28px;
            width: 280px;
        }

        .imgWrap p {
            font-size: 15px;
        }

        .imgWrap button,
        .imgWrap a button {
            padding: 18px 0;
            font-size: 13px;
            line-height: 0;
            border-radius: 12px;
            /* consistent radius on small screens too */
        }
    }

    .slider-container {
        position: relative;
        width: 100%;
        height: auto;
    }

    .slide {
        display: none;
    }

    .slide.active {
        display: block;
    }

    a {
        display: block;
        text-align: center;
        width: 100%;
    }

    #get{
        padding-bottom: 2rem;
    }
</style>

<body>
    <main class="slider"></main>
    <div class="slider-container">
        <!-- Slide 1 -->
        <section class="slide imgWrap active">
            <figure>
                <img class="onboardImg" src="{{ asset('onboard/onboard1.png') }}" alt="onboarding 1" />
            </figure>
            <article>
                <img src="{{ asset('onboard/imgCurve.png') }}" alt="imgCurve" />
                <div>
                    <h2>A Shop in your pocket</h2>
                    <p>The e-commerce platform that makes it easy for users to buy and sell</p>
                    <button class="next">Next</button>
                    <a href="{{ route('auth.type') }}">Skip</a>
                </div>
            </article>
        </section>

        <!-- Slide 2 -->
        <section class="slide imgWrap">
            <figure>
                <img class="onboardImg" src="{{ asset('onboard/onboard2.png') }}" alt="onboarding 2" />
            </figure>
            <article>
                <img src="{{ asset('onboard/imgCurve.png') }}" alt="imgCurve" />
                <div>
                    <h2>Anything can be found</h2>
                    <p>The e-commerce platform that makes it easy for users to buy and sell</p>
                    <button class="next">Next</button>
                    <a href="{{ route('auth.type') }}">Skip</a>
                </div>
            </article>
        </section>

        <!-- Slide 3 -->
        <section class="slide imgWrap">
            <figure>
                <img class="onboardImg" src="{{ asset('onboard/onboard3.png') }}" alt="onboarding 3" />
            </figure>
            <article>
                <img src="{{ asset('onboard/imgCurve.png') }}" alt="imgCurve" />
                <div id="get">
                    <h2>Shop On Closeseller With Ease</h2>
                    <p>The e-commerce platform that makes it easy for users to buy and sell</p>
                    <button class="get-started">Get Started</button>
                </div>
            </article>
        </section>
    </div>

    <script>
        const slides = document.querySelectorAll('.slide');
        let currentIndex = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        document.querySelectorAll('.next').forEach(button => {
            button.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                showSlide(currentIndex);
            });
        });


        document.querySelector('.get-started').addEventListener('click', () => {
            window.location.href = `{{ route('auth.type') }}`;
        });

        showSlide(currentIndex);
    </script>
</body>

</html>
