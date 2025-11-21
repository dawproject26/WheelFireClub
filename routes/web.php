<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\RouletteController;

Route::get('/', [PlayerController::class, 'welcome'])->name('welcome');
Route::post('/register', [PlayerController::class, 'register'])->name('player.register');
Route::post('/login', [PlayerController::class, 'login'])->name('player.login');
Route::get('/logout', [PlayerController::class, 'logout'])->name('player.logout');

Route::middleware(['player.session'])->group(function () {

    Route::middleware(['player.session'])->group(function () {
    
    // Vista principal
    Route::get('/wheelfireclub/panel', [PanelController::class, 'index'])->name('wheelfireclub.panel');
    
    // Acción de girar ruleta
    Route::get('/wheelfireclub/spin', [RouletteController::class, 'spin'])->name('wheelfireclub.spin');
    
    // Acción de comprobar letra
    Route::post('/wheelfireclub/check', [PanelController::class, 'checkLetter'])->name('wheelfireclub.check');
    
    // Acción de guardar puntuación final
    Route::post('/wheelfireclub/panel/store', [PanelController::class, 'store'])->name('wheelfireclub.adivina.store');
});
    
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
