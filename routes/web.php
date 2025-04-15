<?php

use App\Http\Controllers\ReserveringController;
use App\Http\Controllers\BaanController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['checkAdmin'])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/reserveringen', [ReserveringController::class, 'index'])->name('reservering.index');

Route::get('/reservering/wijzigen', [ReserveringController::class, 'wijzigen'])->name('reservering.wijzigen');

Route::get('/editbaan/{id}', [BaanController::class, 'edit'])->name('editbaan');

Route::put('/updatebaan/{id}', [BaanController::class, 'update'])->name('updatebaan');



// Reservation routes with auth middleware
Route::middleware(['auth'])->group(function () {    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Use the resource route which defines all CRUD routes
    Route::resource('reservations', ReservationController::class);
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
        Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Orders routes - keep these separate from accounts
    Route::resource('order', OrderController::class);
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/order', [OrderController::class, 'store'])->name('order.store');
        Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::get('/order/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');

    // Account routes - point to AccountController instead of OrderController
    Route::resource('accounts', AccountController::class);
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
        Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
        Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
        Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
        Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');

});

require __DIR__.'/auth.php';