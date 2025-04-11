<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationklantController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['checkAdmin'])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

 // Use the resource route which defines all CRUD routes
Route::resource('reservations', ReservationController::class);
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');


Route::resource('/reservation_klant', ReservationKlantController::class);
Route::get('/reservation_klant', [ReservationKlantController::class, 'index'])->name('reservation_klant.index');
Route::post('/reservation_klant/filter', [ReservationKlantController::class, 'index'])->name('reservation_klant.index.filter');
Route::get('/reservation_klant/create', [ReservationKlantController::class, 'create'])->name('reservation_klant.create');
Route::post('/reservation_klant', [ReservationKlantController::class, 'store'])->name('reservation_klant.store');
Route::get('/reservation_klant/{id}', [ReservationKlantController::class, 'show'])->name('reservation_klant.show');
Route::get('/reservation_klant/{id}/edit', [ReservationKlantController::class, 'edit'])->name('reservation_klant.edit');
Route::get('/reservation_klant/{id}/edit/optie', [ReservationKlantController::class, 'edit'])->name('reservation_klant.edit.optie');
Route::put('/reservation_klant/{id}', [ReservationKlantController::class, 'update'])->name('reservation_klant.update');
Route::delete('/reservation_klant/{id}', [ReservationKlantController::class, 'destroy'])->name('reservation_klant.destroy');




// Reservation routes with auth middleware
Route::middleware(['auth'])->group(function () {
   
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
