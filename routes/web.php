<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);

Route::get('/signup', [UserController::class, 'create'])->name('signup');
Route::post('/signup', [UserController::class, 'store'])->name('signup.store');
Route::get('/user_login', [UserController::class, 'login'])->name('user_login');
Route::post('/user_login', [UserController::class, 'login'])->name('user_login.store');
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

Route::post('/add-wishlist', [UserController::class, 'add_wishlist'])->name('add_wishlist');
Route::post('/remove-wishlist', [UserController::class, 'remove_wishlist'])->name('remove_wishlist');
Route::get('/wishlists', [UserController::class, 'my_wishlist'])->name('my_wishlists');


Route::get('/today-deals', [HomeController::class, 'todayDeals']);
Route::get('/all-flash-deals', [HomeController::class, 'allflashdeals']);
Route::get('/flash-products', [HomeController::class, 'allflashproducts']);
Route::get('/flash-products/{text}', [HomeController::class, 'flashproducts']);

Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [UserController::class, 'order_products'])->name('checkout.store');


Route::get('search', [HomeController::class, 'search_products'])->name('search.products');
