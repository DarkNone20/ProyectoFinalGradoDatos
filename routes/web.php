<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReportesController;

// Rutas públicas 
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Usuarios 
Route::resource('usuarios', UsuariosController::class)->except(['show']);
Route::delete('usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');



    // Users 
    // Dentro del grupo de rutas protegidas (auth)
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::post('/', [UsersController::class, 'store'])->name('users.store');
        Route::post('/import', [UsersController::class, 'import'])->name('users.import');
        Route::get('/export', [UsersController::class, 'export'])->name('users.export');
        Route::delete('/{documentoId}', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    // Prestamos 
    Route::prefix('prestamos')->group(function () {
        Route::get('/', [PrestamoController::class, 'index'])->name('prestamos.index');
        Route::get('/create', [PrestamoController::class, 'create'])->name('prestamos.create');
        Route::post('/', [PrestamoController::class, 'store'])->name('prestamos.store');
        Route::get('/{IdPrestamo}/edit', [PrestamoController::class, 'edit'])->name('prestamos.edit');
        Route::put('/{IdPrestamo}', [PrestamoController::class, 'update'])->name('prestamos.update');
        Route::delete('/{IdPrestamo}', [PrestamoController::class, 'destroy'])->name('prestamos.destroy');
        Route::get('/export', [PrestamoController::class, 'export'])->name('prestamos.export');
        Route::post('/prestamos/{IdPrestamo}/devolver', [PrestamoController::class, 'devolver'])
            ->name('prestamos.devolver');;
    });
  

    //Reportes
   Route::prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/', [ReportesController::class, 'index'])->name('index');
    Route::post('/export', [ReportesController::class, 'export'])->name('export'); // <--- CAMBIADO A POST
    Route::get('/estadisticas', [ReportesController::class, 'estadisticas'])->name('estadisticas');
 });
    // Equipos
    Route::prefix('equipos')->group(function () {
        Route::get('/', [EquiposController::class, 'index'])->name('equipos.index');
        Route::get('/create', [EquiposController::class, 'create'])->name('equipos.create');
        Route::post('/', [EquiposController::class, 'store'])->name('equipos.store');
        Route::delete('/{ActivoFijo}/{Serial}', [EquiposController::class, 'destroy'])->name('equipos.destroy');
        Route::post('/import', [EquiposController::class, 'import'])->name('equipos.import');
        Route::get('/export', [EquiposController::class, 'export'])->name('equipos.export');
    });

    // Grupos 
    Route::prefix('grupos')->group(function () {
        // Rutas básicas de grupos
        Route::get('/', [GruposController::class, 'index'])->name('grupos.index');
        Route::post('/', [GruposController::class, 'store'])->name('grupos.store');
        Route::delete('/{IdGrupo}', [GruposController::class, 'destroy'])->name('grupos.destroy');

        // Rutas para gestión de miembros del grupo
        Route::get('/{IdGrupo}/miembros', [GruposController::class, 'showMiembros'])->name('grupos.miembros');
        Route::post('/{IdGrupo}/asignar', [GruposController::class, 'asignarUsuario'])->name('grupos.asignarUsuario');
        Route::delete('/{IdGrupo}/remover/{DocumentoId}', [GruposController::class, 'removerUsuario'])->name('grupos.removerUsuario');

        // Ruta para obtener usuarios disponibles para asignar a un grupo (AJAX)
        Route::get('/{IdGrupo}/usuarios-disponibles', [GruposController::class, 'getUsuariosDisponibles'])->name('grupos.usuariosDisponibles');
    });
});
