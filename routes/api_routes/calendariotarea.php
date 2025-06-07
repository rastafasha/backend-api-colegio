

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarioTareasController;

Route::get('calendariotarea', [CalendarioTareasController::class, 'index'])->name('calendariotarea.index');
Route::get('calendariotarea/show/{id}', [CalendarioTareasController::class, 'show'])->name('calendariotarea.show');
Route::get('calendariotarea/showmaestro/{id}', [CalendarioTareasController::class, 'showmaestro'])->name('calendariotarea.showmaestro');
Route::get('calendariotarea/activos/{id}', [CalendarioTareasController::class, 'activos'])->name('calendariotarea.activos');
Route::get('calendariotarea/search/{request}', [CalendarioTareasController::class, 'search'])
    ->name('calendariotarea.search');

Route::post('calendariotarea/store', [CalendarioTareasController::class, 'store'])->name('calendariotarea.store');
Route::put('calendariotarea/update/{calendario}', [CalendarioTareasController::class, 'update'])->name('calendariotarea.update');
Route::delete('calendariotarea/destroy/{id}', [CalendarioTareasController::class, 'destroy'])->name('calendariotarea.destroy');
