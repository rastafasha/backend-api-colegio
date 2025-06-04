<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamenController;

Route::get('examen', [ExamenController::class, 'index'])->name('examen.index');
Route::get('examen/show/{id}', [ExamenController::class, 'show'])->name('examen.show');
Route::get('examen/showstudent/{id}', [ExamenController::class, 'showstudent'])->name('examen.showstudent');
Route::get('examen/search/{request}', [ExamenController::class, 'search'])
    ->name('examen.search');

Route::post('examen/store', [ExamenController::class, 'store'])->name('examen.store');
Route::put('examen/update/{examen}', [ExamenController::class, 'update'])->name('examen.update');
Route::delete('examen/destroy/{id}', [ExamenController::class, 'destroy'])->name('examen.destroy');
