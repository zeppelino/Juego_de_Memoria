<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 */
Route::middleware(['auth', 'session.expired'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/game', [GameController::class, 'index'])->name('game');
    Route::get('/ranking', [GameController::class, 'obtenerRanking']);
    Route::post('/game/iniciarPartida', [GameController::class, 'iniciarPartida'])->name('board');
    Route::get('/continuarPartida/{id}', [GameController::class, 'continuarPartida'])->name('continuarPartida');
    Route::post('/guardarPartida', [GameController::class, 'guardarPartida'])->name('guardarPartida');
    Route::post('/interrumpir', [GameController::class, 'interrumpir'])->name('interrumpir');
    Route::get('/finalizar/{partida}', [GameController::class, 'finalizar'])->name('finalizar');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
