<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\RouletteController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TimerController;

Route::get('/', [PlayerController::class, 'welcome'])->name('welcome');
Route::post('/register', [PlayerController::class, 'register'])->name('player.register');
Route::post('/login', [PlayerController::class, 'login'])->name('player.login');
Route::get('/logout', [PlayerController::class, 'logout'])->name('player.logout');

Route::middleware(['player.session'])->group(function () {

    Route::get('/wheelfireclub/panel', [PanelController::class, 'index'])->name('wheelfireclub.panel');

    Route::post('/wheelfireclub/spin', [RouletteController::class, 'spin'])->name('wheelfireclub.spin');
    Route::post('/wheelfireclub/roulette/apply', [RouletteController::class, 'apply'])->name('wheelfireclub.roulette.apply');

    Route::post('/wheelfireclub/check', [ScoreController::class, 'letter'])->name('wheelfireclub.check');
    Route::post('/wheelfireclub/guess', [ScoreController::class, 'guess'])->name('wheelfireclub.guess');

    Route::get('/wheelfireclub/timer/{player_id}', [TimerController::class, 'get'])->name('wheelfireclub.timer');
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
