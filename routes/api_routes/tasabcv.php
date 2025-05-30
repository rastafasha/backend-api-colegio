<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasaBcvController;

Route::get('tasabcvs', [TasaBcvController::class, 'index'])->name('tasabcv.index');
Route::get('tasabcv/show/{id}', [TasaBcvController::class, 'show'])->name('tasabcv.show');

Route::get('tasabcv/search/{request}', [TasaBcvController::class, 'search'])
    ->name('tasabcv.search');

Route::post('tasabcv/store', [TasaBcvController::class, 'store'])->name('tasabcv.store');

Route::post('tasabcv/update/{proveedor}', [TasaBcvController::class, 'update'])->name('tasabcv.update');

Route::delete('tasabcv/destroy/{id}', [TasaBcvController::class, 'destroy'])->name('tasabcv.destroy');
