<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\RouletteController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TimerController;
use Illuminate\Support\Facades\DB;

Route::get('/', [PlayerController::class, 'welcome'])->name('welcome');

Route::post('/login', [PlayerController::class, 'login'])->name('player.login');
Route::post('/register', [PlayerController::class, 'register'])->name('player.register');
Route::get('/logout', [PlayerController::class, 'logout'])->name('player.logout');

Route::get('/panel', [PanelController::class, 'index'])->name('panel.index');

Route::post('/panel/girar', [PanelController::class, 'girar'])->name('panel.girar');

Route::get('/panel/reset', function () {
    session()->forget('opciones_ruleta');
    DB::table('temporizador')->update(['segundos_restantes' => 120]);
    return redirect('/panel');
})->name('panel.reset');

Route::middleware(['player.session'])->group(function () {
    Route::get('/wheelfireclub/panel', [PanelController::class, 'index'])->name('wheelfireclub.panel');
    Route::post('/wheelfireclub/spin', [RouletteController::class, 'spin'])->name('wheelfireclub.spin');
    Route::post('/wheelfireclub/roulette/apply', [RouletteController::class, 'apply'])->name('wheelfireclub.roulette.apply');
    Route::post('/wheelfireclub/check', [ScoreController::class, 'letter'])->name('wheelfireclub.check');
    Route::post('/wheelfireclub/guess', [ScoreController::class, 'guess'])->name('wheelfireclub.guess');
    Route::get('/wheelfireclub/timer/{player_id}', [TimerController::class, 'get'])->name('wheelfireclub.timer');
});
