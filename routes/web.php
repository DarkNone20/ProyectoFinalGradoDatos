<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\PrestamoController;

// Autenticación
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (deberían estar en un grupo con middleware 'auth')
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Usuarios
Route::resource('usuarios', UsuariosController::class)->except(['show']);
Route::delete('usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

// Otras rutas
Route::get('/grupos', [GruposController::class, 'index'])->name('grupos.index');

Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');


//Equipos
Route::prefix('equipos')->group(function () {
    Route::get('/', [EquiposController::class, 'index'])->name('equipos.index');
    Route::post('/', [EquiposController::class, 'store'])->name('equipos.store');
    Route::delete('/{ActivoFijo}/{Serial}', [EquiposController::class, 'destroy'])->name('equipos.destroy');
});