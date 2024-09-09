<?php

use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\UserAddressController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);

Route::get('/signup', [UserController::class, 'create'])->name('signup');
Route::post('/signup', [UserController::class, 'store'])->name('signup.store');
Route::get('/user_login', [UserController::class, 'login'])->name('user_login');
Route::post('/user_login', [UserController::class, 'login'])->name('user_login.store');

Route::get('/contact_us', [ContactController::class, 'index'])->name('contact_us.index');
Route::post('/contact_us', [ContactController::class, 'store'])->name('contact_us.store');

/** User Address Route */
Route::resource('address', UserAddressController::class);

Route::get('google/login', [UserController::class, 'provider'])->name('google.login');
Route::get('google/callback', [UserController::class, 'handleProviderCallback'])->name('google.callback');

Route::get('/logout', [UserController::class, 'logout'])->name('user_logout');
Route::get('forgot-password', [UserController::class, 'forgotPassword_show'])->name('user_forgot_password');
Route::post('forgot-password', [UserController::class, 'forgotPassword_submit'])->name('user_forgot_password.store');
Route::get('reset-password', [UserController::class, 'resetPassword_show'])->name('user_reset_password');
Route::post('reset-password', [UserController::class, 'submitResetPasswordForm'])->name('user_reset_password.store');

Route::get('my-profile', [UserController::class, 'my_profile'])->name('my_profile');
Route::post('my-profile', [UserController::class, 'update'])->name('my_profile.update');
Route::get('/changepassword', [UserController::class, 'changepassword'])->name('changepassword');
Route::post('/changepassword', [UserController::class, 'change_password'])->name('my_profile.change_password');
Route::get('/cart', [UserController::class, 'my_cart'])->name('my_cart');
Route::post('/show_cart', [UserController::class, 'show_local_cart'])->name('show_local_cart');
Route::post('/save_cart', [UserController::class, 'save_cart'])->name('save_cart');
Route::post('/remove_cart', [UserController::class, 'remove_cart'])->name('remove_cart');
Route::post('/update_cart_qty', [UserController::class, 'update_cart_qty'])->name('update_cart_qty');
Route::get('review/create/{id}', [ReviewController::class, 'create'])->name('review.create');
Route::post('review/store', [ReviewController::class, 'store'])->name('review.store');
Route::get('my-reviews', [UserController::class, 'my_reviews'])->name('my_reviews');
Route::get('/my_orders', [UserController::class, 'my_orders'])->name('my_orders');
Route::post('/my_orders', [UserController::class, 'my_orders'])->name('my_orders.store');

Route::post('/add-wishlist', [UserController::class, 'add_wishlist'])->name('add_wishlist');
Route::post('/remove-wishlist', [UserController::class, 'remove_wishlist'])->name('remove_wishlist');
Route::get('/wishlists', [UserController::class, 'my_wishlist'])->name('my_wishlists');


Route::get('/today-deals', [HomeController::class, 'todayDeals']);
Route::get('/all-flash-deals', [HomeController::class, 'allflashdeals']);
Route::get('/flash-products', [HomeController::class, 'allflashproducts']);
Route::get('/flash-products/{text}', [HomeController::class, 'flashproducts']);

Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [UserController::class, 'order_products'])->name('checkout.store');

Route::get('success', [PaymentController::class, 'success']);
Route::get('pay-with-cod/{amount}', [PaymentController::class, 'payWithCod']);
Route::get('pay-with-paypal/{amount}', [PaymentController::class, 'payWithpaypalCustomize']);
Route::get('/paypal/status', [PaymentController::class, 'getPaymentStatus'])->name('paypal-status');
Route::get('checkout/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('checkout/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('checkout/payment/failed', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');


Route::get('search', [HomeController::class, 'search_products']);
Route::get('/all-products', [HomeController::class, 'search_products']);
Route::get('/c/{text}', [HomeController::class, 'search_products']);
Route::get('/product/{text}', [HomeController::class, 'productpage']);


Route::get('{page}', [HomeController::class, 'site_pages']);


Route::get('/pay-with-razorpay/{id}/{text}', [PaymentController::class, 'yb_payWithRazorpay']);
