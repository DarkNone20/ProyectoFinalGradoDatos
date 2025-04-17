<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UsersController;

// Rutas públicas 
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//  rutas protegidas
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Usuarios 
    Route::resource('usuarios', UsuariosController::class)->except(['show']);
    Route::delete('usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
    
    // Users 
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::post('/', [UsersController::class, 'store'])->name('users.store');
        Route::delete('/{documentoId}', [UsersController::class, 'destroy'])->name('users.destroy');
    });
    
    // Prestamos 
    Route::prefix('prestamos')->group(function () {
        Route::get('/', [PrestamoController::class, 'index'])->name('prestamos.index');
        Route::post('/', [PrestamoController::class, 'store'])->name('prestamos.store');
        Route::delete('/{IdPrestamo}', [PrestamoController::class, 'destroy'])->name('prestamos.destroy');
    });

    // Equipos 
    Route::prefix('equipos')->group(function () {
        Route::get('/', [EquiposController::class, 'index'])->name('equipos.index');
        Route::post('/', [EquiposController::class, 'store'])->name('equipos.store');
        Route::delete('/{ActivoFijo}/{Serial}', [EquiposController::class, 'destroy'])->name('equipos.destroy');
    });

    // Grupos 
    Route::prefix('grupos')->group(function () {
        Route::get('/', [GruposController::class, 'index'])->name('grupos.index');
        Route::post('/', [GruposController::class, 'store'])->name('grupos.store');
        Route::delete('/{IdGrupo}', [GruposController::class, 'destroy'])->name('grupos.destroy');
    });
});