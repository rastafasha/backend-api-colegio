<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;

Route::get('sliders', [SliderController::class, 'index'])->name('sliders.index');
Route::get('sliders/activos', [SliderController::class, 'activos'])->name('sliders.activos');
Route::get('sliders/show/{id}', [SliderController::class, 'show'])->name('sliders.show');

Route::post('sliders/store', [SliderController::class, 'store'])->name('sliders.store');
Route::post('sliders/update/{slider}', [SliderController::class, 'update'])->name('sliders.update');
Route::delete('sliders/destroy/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy');
