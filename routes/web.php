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

    // Reservation routes
    Route::resource('reservations', ReservationController::class);

    // Order routes
    Route::resource('order', OrderController::class);

    // Account routes
    Route::resource('accounts', AccountController::class);

    // User management routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
});

require __DIR__ . '/auth.php';

// Score routes
Route::prefix('score')->group(function () {
    Route::get('/', [ScoreController::class, 'index'])->name('score.index');
    Route::get('/create', [ScoreController::class, 'create'])->name('score.create');
    Route::post('/', [ScoreController::class, 'store'])->name('score.store');
    Route::get('/{id}', [ScoreController::class, 'show'])->name('score.show');
    Route::get('/{id}/edit', [ScoreController::class, 'edit'])->name('score.edit');
    Route::put('/{id}', [ScoreController::class, 'update'])->name('score.update');
    Route::delete('/{id}', [ScoreController::class, 'destroy'])->name('score.destroy');
});

// Simplified scores endpoint
Route::get('/scores', [ScoreController::class, 'index']);
