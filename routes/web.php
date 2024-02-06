<?php

use App\Http\Controllers\ProfileController;
use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/users', function () {
    // $user = User::factory()->create();
    // $user->address()->create([
    //     'country' => 'India 1'
    // ]);

    // $users = User::with(['address'])->get();
    $address = Address::with(['user'])->get();

    return view('users.index', compact('address'));
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
