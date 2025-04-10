<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreController;

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
});

require __DIR__.'/auth.php';

//Score 
Route::prefix('score')->group(function () {
    Route::get('/', [ScoreController::class, 'index'])->name('score.index'); // Voor de index view
    Route::get('/create', [ScoreController::class, 'create'])->name('score.create'); // Voor de create view
    Route::post('/', [ScoreController::class, 'store'])->name('score.store'); // Voor het opslaan van data
    Route::get('/{id}', [ScoreController::class, 'show'])->name('score.show'); // Voor de show view
    Route::get('/{id}/edit', [ScoreController::class, 'edit'])->name('score.edit'); // Voor de edit view
    Route::put('/{id}', [ScoreController::class, 'update'])->name('score.update'); // Voor het updaten van data
    Route::delete('/{id}', [ScoreController::class, 'destroy'])->name('score.destroy'); // Voor het verwijderen van data
});