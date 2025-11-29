<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssignmentController;
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

// Rutas públicas (EXACTAMENTE como en el ejemplo que funciona)
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta publica
Route::get('/', function () {
    return redirect()->route('login');
});

//Rutas privadas
Route::middleware(['auth'])->group(function () {
    Route::get('/panel', [homeController::class, 'index'])->name('panel');
    
    Route::get('/inventario/historial', [EquipmentController::class, 'historialinventario'])->name('inventario.historial');
    
    Route::resources([
        'inventario' => EquipmentController::class,
        'asignacion' => AssignmentController::class,
        'devolucion' => DevolucionController::class,
        'setting' => SettingController::class,
        'area' => AreaController::class,
        'sede' => HeadquartersController::class,
        'jefes' => BossController::class,
        'user' => UserController::class,
        'tipoequipo' => EquipmentTypeController::class,
        'proveedor' => SupplierController::class,
        'entities' => EntitiesController::class,
        'roles' => RoleController::class,
    ]);
    
    Route::get('/asignacion/search/equipment', [AssignmentController::class, 'searchEquipment'])->name('asignacion.search-equipment');
    Route::get('/devolucion/boss-assignments/{bossId}', [DevolucionController::class, 'getBossAssignments'])->name('devolucion.boss-assignments');
    Route::post('/devolucion/store', [DevolucionController::class, 'store'])->name('devolucion.store');
});

Route::get('/401', function () {
    return view('errors.401');
});

Route::get('/500', function () {
    return view('errors.500');
});

Route::get('/404', function () {
    return view('errors.404');
});