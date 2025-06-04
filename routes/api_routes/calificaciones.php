<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalificacionController;

Route::get('calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index');
Route::get('calificaciones/show/{id}', [CalificacionController::class, 'show'])->name('calificaciones.show');
Route::get('calificaciones/showstudent/{id}', [CalificacionController::class, 'showstudent'])->name('calificaciones.showstudent');
Route::get('calificaciones/showmateria/{id}/{studentId}', [CalificacionController::class, 'showmateria'])->name('calificaciones.showmateria');
Route::get('calificaciones/search/{request}', [CalificacionController::class, 'search'])
    ->name('calificaciones.search');

Route::get('calificaciones/pdf/{studentId}', [CalificacionController::class, 'generatePdf']);

Route::post('calificaciones/store', [CalificacionController::class, 'store'])->name('calificaciones.store');
Route::post('calificaciones/update/{slider}', [CalificacionController::class, 'update'])->name('calificaciones.update');
Route::delete('calificaciones/destroy/{id}', [CalificacionController::class, 'destroy'])->name('calificaciones.destroy');
