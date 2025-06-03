<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriaController;

Route::get('materias', [MateriaController::class, 'index'])->name('sliders.index');
Route::get('materias/activos', [MateriaController::class, 'activos'])->name('sliders.activos');
Route::get('materias/show/{id}', [MateriaController::class, 'show'])->name('sliders.show');

Route::post('materias/store', [MateriaController::class, 'store'])->name('sliders.store');
Route::post('materias/update/{slider}', [MateriaController::class, 'update'])->name('sliders.update');
Route::delete('materias/destroy/{id}', [MateriaController::class, 'destroy'])->name('sliders.destroy');
