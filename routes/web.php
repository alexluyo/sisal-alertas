<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\VecinoController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\PermisoController;
use App\Http\Controllers\Admin\ModuloController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('anexos', AnexoController::class)
        ->middleware('permiso:anexos,puede_ver')
        ->parameters(['anexos' => 'anexo']);

    Route::patch('/anexos/{anexo}/eliminar', [AnexoController::class, 'eliminar'])
        ->middleware('permiso:anexos,puede_eliminar')
        ->name('anexos.eliminar');

    Route::resource('vecinos', VecinoController::class)
        ->middleware('permiso:vecinos,puede_ver')
        ->parameters(['vecinos' => 'vecino']);

    Route::patch('/vecinos/{vecino}/eliminar', [VecinoController::class, 'eliminar'])
        ->middleware('permiso:vecinos,puede_eliminar')
        ->name('vecinos.eliminar');

    Route::resource('alertas', AlertaController::class)
        ->middleware('permiso:alertas,puede_ver')
        ->parameters(['alertas' => 'alerta']);

    Route::patch('/alertas/{alerta}/eliminar', [AlertaController::class, 'eliminar'])
        ->middleware('permiso:alertas,puede_eliminar')
        ->name('alertas.eliminar');

    
    /*
    |--------------------------------------------------------------------------
    | ADMINISTRADOR
    |--------------------------------------------------------------------------
    */

    Route::middleware('permiso:usuarios,puede_ver')->group(function () {

        Route::resource('/admin/usuarios', UsuarioController::class)
            ->names('admin.usuarios')
            ->parameters(['usuarios' => 'usuario']);

        Route::patch('/admin/usuarios/{usuario}/estado', [UsuarioController::class, 'cambiarEstado'])
            ->name('admin.usuarios.estado');

        Route::get('/admin/permisos', [PermisoController::class, 'index'])
            ->name('admin.permisos');

        Route::post('/admin/permisos', [PermisoController::class, 'guardar'])
            ->name('admin.permisos.guardar');

        Route::resource('/admin/modulos', ModuloController::class)
            ->names('admin.modulos')
            ->parameters(['modulos' => 'modulo']);

        Route::patch('/admin/modulos/{modulo}/estado', [ModuloController::class, 'cambiarEstado'])
            ->name('admin.modulos.estado');

    });


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/device-tokens', [DeviceTokenController::class, 'store'])
        ->name('device-tokens.store');
});

require __DIR__.'/auth.php';
