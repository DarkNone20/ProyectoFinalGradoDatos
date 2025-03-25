<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UuariosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Home
Route::get('/home', [HomeController::class, 'index']);
//Usuarios
Route::get('/usuarios', [UuariosController::class, 'index']);

// Ruta principal (página de inicio)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Ruta para cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');