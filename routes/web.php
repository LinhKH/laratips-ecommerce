<?php

use App\Http\Controllers\Front\HomeController;
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


Route::get('search', [HomeController::class, 'search_products'])->name('search.products');
