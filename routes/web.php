<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.app');
    return "Home page";
});
