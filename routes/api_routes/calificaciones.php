<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalificacionController;

Route::get('calificaciones', [CalificacionController::class, 'index'])->name('sliders.index');
Route::get('calificaciones/activos', [CalificacionController::class, 'activos'])->name('sliders.activos');
Route::get('calificaciones/show/{id}', [CalificacionController::class, 'show'])->name('sliders.show');
Route::get('calificaciones/showstudent/{id}', [CalificacionController::class, 'showstudent'])->name('sliders.showstudent');
Route::get('calificaciones/pdf/{studentId}', [CalificacionController::class, 'generatePdf']);

Route::post('calificaciones/store', [CalificacionController::class, 'store'])->name('sliders.store');
Route::post('calificaciones/update/{slider}', [CalificacionController::class, 'update'])->name('sliders.update');
Route::delete('calificaciones/destroy/{id}', [CalificacionController::class, 'destroy'])->name('sliders.destroy');
