<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
     <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('users/assets/css/product-success.css') }}">
</head>

<body>

    <div class="closemodal">
        <a href="{{ route('view.cart') }}">
            <button>
                <span class="material-icons">close</span>
            </button>
        </a>
    </div>

    <section class="success_sty">
        <figure>
            <a href="{{ route('view.cart') }}">
                <span class="material-icons" style="font-size: 64px; color: #55048e;">thumb_up</span>
            </a>
        </figure>

        <div align="center">
            <h2>Congratulations!</h2>
            <p>Your Payment was Successful</p>
        </div>

        <div class="sucess_btn">
            <a href="{{ url('/') }}">
                <button style="background: #55048E; color: #fff;">
                    Continue Shopping
                </button>
            </a>
            <br /><br />
            <a href="{{ route('view.cart') }}">
                <button>Close</button>
            </a>
        </div>
    </section>

</body>


</html>