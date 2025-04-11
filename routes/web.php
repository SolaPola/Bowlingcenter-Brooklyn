<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['checkAdmin'])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
