@extends('vendors.vendor-masters')

@section('vendor')
    <style>
        :root {
            --purple: #701d9d;
            --orange: #fb7e00;
            --light-purple: #f0e6f7;
            --light-orange: #fff4ed;
            --text-dark: #1a1a1a;
            --text-medium: #666666;
            --text-light: #999999;
            --border-color: #e1e5e9;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --background: #ffffff;
            --card-shadow: 0 2px 20px rgba(112, 29, 157, 0.08);
            --hover-shadow: 0 4px 25px rgba(112, 29, 157, 0.15);
            --general-font-family: "Poppins", sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--general-font-family);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 7px 20px;
            /* border: 2px red solid; */
        }

        .container-2 {
            width: 100%;
            max-width: 500px;
            background: var(--background);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
            /* border: 2px solid red; */
            margin-top: -40px;
        }

        /* Top gradient header */
        .header-gradient {
            height: 120px;
            background: linear-gradient(135deg, var(--purple) 0%, var(--orange) 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .back-btn {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) translateX(-2px);
        }

        .header-content {
            text-align: center;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .header-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin: 5px 0 0;
        }

        /* Content area */
        .content {
            padding: 40px 30px;
        }

        /* Disclaimer section */
        .disclaimer {
            background: var(--light-purple);
            border-left: 4px solid var(--purple);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            position: relative;
        }

        .disclaimer-icon {
            color: var(--purple);
            font-size: 18px;
            margin-bottom: 10px;
        }

        .disclaimer-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--purple);
            margin-bottom: 8px;
        }

        .disclaimer-text {
            font-size: 14px;
            color: var(--text-medium);
            line-height: 1.5;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .required {
            color: var(--orange);
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 16px;
            font-family: var(--general-font-family);
            background: var(--background);
            color: var(--text-dark);
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 4px rgba(112, 29, 157, 0.1);
            transform: translateY(-1px);
        }

        .form-input::placeholder {
            color: var(--text-light);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 16px;
        }

        .form-input:focus+.input-icon {
            color: var(--purple);
        }

        .error-message {
            color: var(--orange);
            font-size: 12px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-icon {
            font-size: 12px;
        }

        /* Submit button */
        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--purple) 0%, var(--orange) 100%);
            color: white;
            border: none;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            font-family: var(--general-font-family);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        .spinner.show {
            display: block;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Helper text */
        .helper-text {
            font-size: 12px;
            color: var(--text-light);
            text-align: center;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        /* Toast notifications */
        .toaster_alert {
            color: white;
            width: 320px;
            max-width: 90vw;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 16px 20px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            border-radius: 12px;
            box-shadow: var(--hover-shadow);
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .message {
            width: 90%;
            font-size: 14px;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .close {
            font-size: 16px;
            cursor: pointer;
            padding: 0 5px;
            color: white;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .close:hover {
            opacity: 1;
        }

        .error {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .success {
            background: linear-gradient(135deg, var(--purple) 0%, var(--orange) 100%);
        }

        /* Responsive design */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 16px;
            }

            .content {
                padding: 30px 20px;
            }

            .header-title {
                font-size: 20px;
            }

            .disclaimer {
                padding: 16px;
                margin-bottom: 25px;
            }

            .form-input {
                padding: 14px 16px;
                font-size: 15px;
            }

            .submit-btn {
                padding: 14px 20px;
                font-size: 15px;
            }

            .toaster_alert {
                width: 90vw;
                right: 5vw;
                left: 5vw;
            }
        }
    </style>


    <div class="container-2">
        <!-- Header with gradient -->
        <div class="header-gradient">
            <a href="#" class="back-btn" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <h1 class="header-title">Add Product</h1>
                <p class="header-subtitle">Create your product listing</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Disclaimer -->
            <div class="disclaimer">
                <i class="fas fa-info-circle disclaimer-icon"></i>
                <h3 class="disclaimer-title">Quick Setup Process</h3>
                <p class="disclaimer-text">
                    After adding your product name, you'll be redirected to the complete product editor where you can add
                    images,
                    descriptions, pricing, inventory details, and other specifications before publishing your product.
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('vendor.create.product') }}" method="POST" id="addProductForm">
                @csrf
                <div class="form-group">
                    <label for="product_name" class="form-label">
                        Product Name <span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="text" name="product_name" id="product_name" placeholder="Enter your product name..."
                            class="form-input" required maxlength="100">
                        <i class="fas fa-tag input-icon"></i>
                    </div>
                    <div class="error-message" id="error-message" style="display: none;">
                        <i class="fas fa-exclamation-triangle error-icon"></i>
                        <span id="error-text">
                            Product name is required and must be less than 100 characters.
                        </span>
                    </div>
                    @error('product_name')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="submit-btn" name="addProduct" id="submitBtn">
                    <div class="spinner" id="spinner"></div>
                    <i class="fas fa-plus" id="btn-icon"></i>
                    <span id="btn-text">Create Product</span>
                </button>
            </form>

            <div class="helper-text">
                <i class="fas fa-lightbulb"></i>
                Choose a clear, descriptive name that buyers will easily understand
            </div>
        </div>
    </div>

    <script>
        $('#signUpForm').on('submit', function() {
            $('.spinner').css('display', 'inline-flex').show();
        });
        // Move this outside $(document).ready()
        function custom_alert(type, message) {
            let alerthtml = `<div class="toaster_alert ${type}">
            <p class="message">${message}</p>
            <span class="close">&times;</span>
        </div>`;
            $('body').append(alerthtml);

            setTimeout(() => {
                $('.toaster_alert').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);

            $('.close').on('click', function() {
                $(this).closest('.toaster_alert').fadeOut(300, function() {
                    $(this).remove();
                });
            });
        }

        // $(document).ready(function() {
        //   // Check for session alert on page load
        //   <?php if (isset($_SESSION['alert'])): ?>
        //     custom_alert('<?php echo $_SESSION['alert']['type']; ?>', '<?php echo $_SESSION['alert']['message']; ?>');
        //     <?php unset($_SESSION['alert']); ?>
        //   <?php endif; ?>
        // });

        // Auto-focus on page load
        window.addEventListener('load', function() {
            productNameInput.focus();
        });

        const style = document.createElement('style');
        style.textContent = `
      @keyframes slideOut {
        from {
          transform: translateX(0);
          opacity: 1;
        }
        to {
          transform: translateX(100%);
          opacity: 0;
        }
      }
    `;
        document.head.appendChild(style);
    </script>
@endsection
