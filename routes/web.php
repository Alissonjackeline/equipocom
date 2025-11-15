<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\EntitiesController;
use App\Http\Controllers\HeadquartersController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\JefesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TipoEquipoController;
use App\Http\Controllers\UserController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/panel', [homeController::class, 'index'])->name('panel');
Route::post('/', [loginController::class, 'login'])->name('login.submit');

Route::get('/inventario/historial', [InventarioController::class, 'historialinventario'])->name('inventario.historial');
Route::resources([
    'inventario' => InventarioController::class,
    'asignacion' => AsignacionController::class,
    'devolucion' => DevolucionController::class,
    'setting' => SettingController::class,
    'area' => AreaController::class,
    'sede' => HeadquartersController::class,
    'jefes' => JefesController::class,
    'user' => UserController::class,
    'tipoequipo' => TipoEquipoController::class,
    'proveedor' => ProveedorController::class,
    'entities' => EntitiesController::class,
    'rol' => RoleController::class,
]);