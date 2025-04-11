<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
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

    // use the resource route which defines all CRUD routes
    Route::resource('accounts', OrderController::class);
        Route::get('/accounts', [OrderController::class, 'index'])->name('accounts.index');
        Route::get('/accounts/create', [OrderController::class, 'create'])->name('accounts.create');
        Route::post('/accounts', [OrderController::class, 'store'])->name('accounts.store');
        Route::get('/accounts/{id}', [OrderController::class, 'show'])->name('accounts.show');
        Route::get('/accounts/{id}/edit', [OrderController::class, 'edit'])->name('accounts.edit');
        Route::put('/accounts/{id}', [OrderController::class, 'update'])->name('accounts.update');
        Route::delete('/accounts/{id}', [OrderController::class, 'destroy'])->name('accounts.destroy');


    // use the resource route which defines all CRUD routes
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::post('/order', [OrderController::class, 'store'])->name('order.store');
        Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::get('/order/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
        Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
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
