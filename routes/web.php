<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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


    Route::get('/score', [ScoreController::class, 'index'])->name('score.index');
    Route::get('/score/create', [ScoreController::class, 'create'])->name('score.create');
    Route::post('/score', [ScoreController::class, 'store'])->name('score.store');
    Route::get('/score/{id}/edit', [ScoreController::class, 'edit'])->name('score.edit');
    Route::get('/score/{reservation}', [ScoreController::class, 'show'])->name('score.show');
});



require __DIR__.'/auth.php';
