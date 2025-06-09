
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguracionController;

Route::get('configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
Route::get('configuracion/show/{id}', [ConfiguracionController::class, 'show'])->name('configuracion.show');

Route::post('configuracion/store', [ConfiguracionController::class, 'store'])->name('configuracion.store');
Route::post('configuracion/update/{slider}', [ConfiguracionController::class, 'update'])->name('configuracion.update');
Route::delete('configuracion/destroy/{id}', [ConfiguracionController::class, 'destroy'])->name('configuracion.destroy');
