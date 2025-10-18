<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\frontendController;
use App\Http\Controllers\OtpPasswordController;
use App\Http\Controllers\User\userController;
use App\Http\Controllers\Vendor\vendorController;
use App\Http\Controllers\Vendor\VendorProductController;




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');






// =============================  FRONTEND CONTROLLER ============================= //
Route::controller(frontendController::class)->group(function () {
    Route::get('/onboarding', 'Onboarding')->name('onboarding');
    Route::get('/auth-type', 'AuthType')->name('auth.type');
    Route::get('/splash-screen', 'SplashScreen')->name('splash.screen');
    Route::get('/', 'Home')->name('index');
    Route::get('/product-details/{productid}/{productName}/{catid}/{catName}', 'ProductDetails')->name('product.details');
    Route::get('/product-categories/{catid}/{catName}', 'ProductCategories')->name('product.categories');
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/search/q', 'productSearch')->name('product.search');
    Route::get('/notifications', 'AuthNotification')->name('notifications');
    Route::get('/notifications/details/{id}', 'notificationDetails')->name('notifications.details');
});

// =============================  FRONTEND ENDS ============================= //

















// =============================  USER CONTROLLER WITHOUT AUTH ============================= //
Route::controller(OtpPasswordController::class)->group(function () {
    // User Password Reset with OTP
    Route::post('/users/otp-forgot-password',  'UsersendOtp')->name('user.password.otp.send');
    Route::get('/users/verify-otp/{email}',  'UserverifyOtpPage')->name('user.password.otp.verify.page');
    Route::post('users//verify-otp',  'UserverifyOtp')->name('user.password.otp.verify');
    Route::get('/users/reset-password/{email}',  'UserResetForm')->name('user.password.reset.form');
    Route::post('/users/reset-password',  'UserResetPassword')->name('user.reset-password');


    // Vendor Password Reset with 
    Route::get('/vendors/forgot-password',  'VendorForgotPassword')->name('vendor.forgot.password');
    Route::post('/vendors/otp-forgot-password',  'VendorForgotPasswordOtp')->name('vendor.forgot.password.otp');
    Route::get('/vendors/verify-otp/{email}',  'VendorverifyOtpPage')->name('vendor.password.otp.verify.page');
    Route::post('vendors//verify-otp',  'VendorverifyOtp')->name('vendor.password.otp.verify');
    Route::get('/vendors/reset-password/{email}',  'VendorResetForm')->name('vendor.password.reset.form');
    Route::post('/vendors/reset-password',  'VendorResetPassword')->name('vendor.reset.password');
});





// =============================  USER CONTROLLER WITH AUTH ============================= //
Route::middleware('auth')->prefix('users')->group(function () {

    Route::controller(userController::class)->group(function () {
        Route::get('/dashboard', 'UserDashboard')->name('user.dashboard');
        Route::get('/logout', 'UserLogout')->name('user_logout');

        // Route::get('/profile', 'Profile')->name('profile');
        // Route::get('/settings', 'Settings')->name('settings');
        // Route::get('/orders', 'Orders')->name('orders');
        // Route::get('/invoices', 'Invoices')->name('invoices');
        // Route::get('/cart', 'Cart')->name('cart');
        // Route::get('/checkout', 'Checkout')->name('checkout');
        // Route::get('/products', 'Products')->name('products');
        // Route::get('/product/details/{id}', 'ProductDetails')->name('product.details');
        // Route::get('/wishlist', 'Wishlist')->name('wishlist');
        // Route::get('/chat', 'Chat')->name('chat');
        // Route::get('/notifications', 'Notifications')->name('notifications');
        // Route::get('/helpdesk', 'Helpdesk')->name('helpdesk');
        // Route::get('/faqs', 'Faqs')->name('faqs');
        // Route::get('/terms-conditions', 'TermsConditions')->name('terms.conditions');
        // Route::get('/privacy-policy', 'PrivacyPolicy')->name('privacy.policy');
    });
});




















// =============================  VENDOR CONTROLLER WITHOUT AUTH ============================= //

Route::controller(vendorController::class)->group(function () {
    Route::get('/vendors/register', 'Vendorregister')->name('vendor.register');
    Route::post('/vendors/register/store', 'VendorStore')->name('vendor.store');
    Route::get('/vendors/login', 'VendorLogin')->name('vendor.login');
    Route::post('/vendors/login/submit', 'VendorLoginSubmit')->name('vendor.login.submit');
});


// =============================  VENDOR CONTROLLER WITH AUTH ============================= //

Route::middleware('vendor')->prefix('vendors')->group(function () {

    Route::controller(vendorController::class)->group(function () {
        Route::get('/verification', 'VendorDocumentVerification')->name('vendor.doc.verify');
        Route::post('/doc/store', 'VendorDocStore')->name('vendor.verify.docs');
        Route::get('/dashboard', 'VendorDashboard')->name('vendor.dashboard');
        Route::get('/settings', 'VendorSettings')->name('vendor.settings');
        Route::get('/logout', 'VendoLlogout')->name('vendor.logout');
    });

    Route::controller(VendorProductController::class)->group(function () {
        Route::get('/add-product', 'VendorAddProduct')->name('vendor.add.products');
        Route::post('/create-product', 'VendorCreateProduct')->name('vendor.create.product');
        Route::get('/edit-product/{productid}', 'VendorEditProduct')->name('vendor.edit.product');
        Route::get('/delete-product/{id}', 'VendorDeleteImage')->name('vendor.image_delete');
        Route::post('/update/product', 'VendorUpdateProduct')->name('vendor.update.product'); 
        Route::post('/vendor/update-image-order', 'productImageSort')->name('vendor.update_image_order'); 


    });
});






require __DIR__ . '/auth.php';
