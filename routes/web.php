<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

 // Use the resource route which defines all CRUD routes
 Route::resource('reservation', ReservationController::class);


// Reservation routes with auth middleware
Route::middleware(['auth'])->group(function () {
   
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__ . '/auth.php';
Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::post('/', [OrderController::class, 'store'])->name('order.store');
    Route::get('/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::put('/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
});
// Route::get('/order', [OrderController::class, 'index'])->name('order.index');
// Route::post('/order', [OrderController::class, 'store'])->name('order.store');
// Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
// Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');
// Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
// Route::get('/order/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
