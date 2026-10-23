<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');
// kelompok routen yang gaboleh di akses kalau udah login
Route::middleware(['IsGuest'])->group(function () {

    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.store');
});

// kelompk route yang boleh di akses nya hanya stelah login
Route::middleware(['IsLoggedIn'])->group(function () {

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware(['IsAdmin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('book-categories', BookCategoryController::class)->except('show');
        Route::resource('subscription-packages', SubscriptionPackageController::class)->except('show');
        Route::resource('books',BookController::class)->except('show');
    });
});
