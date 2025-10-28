<?php

use App\Http\Controllers\Frontend\frontendController;
use App\Http\Controllers\OtpPasswordController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\userController;
use App\Http\Controllers\Vendor\FaqController;
use App\Http\Controllers\Vendor\HelpController;
use App\Http\Controllers\Vendor\NotificationController;
use App\Http\Controllers\Vendor\vendorController;
use App\Http\Controllers\Vendor\VendorPasswordController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorReviewController;
use App\Http\Controllers\VendorBankController;
use Illuminate\Support\Facades\Route;


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
    Route::post('/add-to-wishlist', 'addToWishList')->name('add.to.wishlist');
});


Route::middleware('auth')->group(function () {

    Route::controller(CartController::class)->group(function () {
        Route::post('/add-to-cart', 'addToCart')->name('add.to.cart');
        Route::get('/update-cart-count', 'cartCountUpdate')->name('cart.count');
        Route::get('/view-cart', 'viewCart')->name('view.cart');
        Route::post('/remove-cart', 'removeItem')->name('cart.remove');
        Route::post('/update-cart', 'updateCart')->name('update.cart');
        Route::get('/checkout', 'Checkout')->name('checkout');
        Route::post('/place-order', 'placeOrder')->name('place.order');
        Route::get('/security/check/{order_id}', 'securityCheck')->name('security.check');
        Route::post('/security/verify', 'securityVerify')->name('security.verify');
    });
});



Route::controller(PaymentController::class)->group(function () {
    Route::get('/paystack/initialize/{order_id}',  'initializePayment')->name('paystack.initialize');
    Route::get('/paystack/callback',  'handleCallback')->name('paystack.callback');
    Route::post('/paystack/webhook',  'handleWebhook')->name('paystack.webhook');
    Route::get('/payment/success', 'paymentSuccess')->name('payment.success');
    Route::get('/payment/failed', 'paymentFailed')->name('payment.failed');

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
        Route::get('/wishlist', 'getUserProductWishlist')->name('user.wishlist');
        Route::get('/delete-wishlist/{id}', 'deleteWishlist')->name('delete_wishlist');
        Route::get('/wishlist/status', 'WuishListStatus')->name('wishlist.status');
        Route::get('/edit/profile', 'editUserProfile')->name('edit.user.profile');
        Route::post('/update/profile', 'userUpdateProfile')->name('user.update.profile');
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
        Route::get('/personal-data', 'VendorPersonalData')->name('vendor.personal.data');
        Route::post('/personal-data/update', 'VendorUpdatePersonalData')->name('vendor.update.personal.data');
        Route::get('/business-information', 'VendorBusinessInfo')->name('vendor.business.information');
        Route::post('/business-information/update', 'VendorUpdateBusinessInfo')->name('vendor.update.business.information');
        Route::get('/logout', 'VendoLlogout')->name('vendor.logout');
    });

    Route::controller(VendorProductController::class)->group(function () {
        Route::get('/add-product', 'VendorAddProduct')->name('vendor.add.products');
        Route::post('/create-product', 'VendorCreateProduct')->name('vendor.create.product');
        Route::get('/edit-product/{productid}', 'VendorEditProduct')->name('vendor.edit.product');
        Route::get('/delete-product/{id}', 'VendorDeleteImage')->name('vendor.image_delete');
        Route::post('/update/product', 'VendorUpdateProduct')->name('vendor.update.product');
        Route::post('/vendor/update-image-order', 'productImageSort')->name('vendor.update_image_order');
        Route::get('/products', 'VendorProducts')->name('vendor.products');


        Route::post('/update/product', 'VendorUpdateProduct')->name('vendor.update.product');
        Route::post('/vendor/update-image-order', 'productImageSort')->name('vendor.update_image_order');
    });

    Route::controller(VendorBankController::class)->group(function () {
        Route::get('/account-info', 'showAccountInfo')->name('vendor.account.info');
        Route::get('/banks', 'getBanks')->name('vendor.get.banks');
        Route::post('/verify-bank', 'verifyAccount')->name('vendor.verify.account');
        Route::post('/save-bank-details', 'saveDetails')->name('vendor.save.bank.details');
    });

    Route::controller(VendorPasswordController::class)->group(function () {
        Route::get('/change-password', 'showChangePasswordForm')->name('vendor.change.password');
        Route::post('/update-password', 'updatePassword')->name('vendor.update.password');
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/vendor/notifications',  'index')->name('vendor.notifications');
        Route::get('/vendor/notifications/{id}',  'show')->name('vendor.notifications.show');
        Route::post('/vendor/notifications/mark-all',  'markAllAsRead')->name('vendor.notifications.markAll');
    });

    Route::controller(FaqController::class)->group(function () {
        Route::get('/faqs',  'index')->name('vendor.faqs');
        Route::get('/faqs/{id}',  'show')->name('vendor.faqs.show');
    });

    Route::controller(HelpController::class)->group(function () {
        Route::get('/get-help',  'index')->name('vendor.gethelp');
        Route::get('/customer-support',  'customerSupport')->name('vendor.customer.support');
        Route::get('/send-feedback',  'sendFeedback')->name('vendor.sendFeedback');
        Route::get('/report',  'sendReport')->name('vendor.sendReport');
        Route::post('/vendors/send-feedback',  'storeFeedback')->name('vendor.send.feedback');
        Route::post('/vendors/send-report',  'storeReport')->name('vendor.send.report');
    });

    Route::controller(VendorReviewController::class)->group(function () {
        Route::get('/reviews',  'index')->name('vendor.reviews');
        Route::get('/fetch-reviews',  'fetchReviews')->name('vendor.reviews.fetch');
    });
});






require __DIR__ . '/auth.php';
