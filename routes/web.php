<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\BossController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\EntitiesController;
use App\Http\Controllers\HeadquartersController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\EquipmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/panel', [homeController::class, 'index'])->name('panel');
Route::post('/', [loginController::class, 'login'])->name('login.submit');

Route::get('/inventario/historial', [EquipmentController::class, 'historialinventario'])->name('inventario.historial');
Route::resources([
    'inventario' => EquipmentController::class,
    'asignacion' => AsignacionController::class,
    'devolucion' => DevolucionController::class,
    'setting' => SettingController::class,
    'area' => AreaController::class,
    'sede' => HeadquartersController::class,
    'jefes' => BossController::class,
    'user' => UserController::class,
    'tipoequipo' => EquipmentTypeController::class,
    'proveedor' => SupplierController::class,
    'entities' => EntitiesController::class,
    'rol' => RoleController::class,
]);