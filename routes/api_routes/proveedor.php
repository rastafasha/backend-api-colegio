<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;

Route::get('proveedores', [ProveedorController::class, 'index'])->name('proveedor.index');
Route::get('proveedor/countryList/', [ProveedorController::class, 'countriesCode'])->name('proveedor.countriesCode');
Route::get('proveedor/show/{id}', [ProveedorController::class, 'show'])->name('proveedor.show');
Route::get('proveedor/showbyUser/{user_id}', [ProveedorController::class, 'showbyUser'])->name('proveedor.showbyUser');

Route::get('proveedor/search/{request}', [ProveedorController::class, 'search'])
    ->name('proveedor.search');

Route::post('proveedor/store', [ProveedorController::class, 'store'])->name('proveedor.store');

Route::post('proveedor/update/{proveedor}', [ProveedorController::class, 'update'])->name('proveedor.update');
Route::post('proveedor/updatestatusclient/{proveedor}', [ProveedorController::class, 'updateStatusClient'])->name('proveedor.updateStatusClient');
Route::post('proveedor/updatestatusadmin/{proveedor}', [ProveedorController::class, 'updateStatusAdmin'])->name('proveedor.updateStatusAdmin');

Route::delete('proveedor/destroy/{id}', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');

Route::options('/{any}', function (Request $request) {
    return response()->json(['status' => 'OK']);
    })->where('any', '.*');