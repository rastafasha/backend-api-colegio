<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepresentanteController;

Route::get('parents', [RepresentanteController::class, 'index'])->name('parent.index');
Route::get('parent/show/{id}', [RepresentanteController::class, 'show'])->name('parent.show');

Route::get('parent/search/{request}', [RepresentanteController::class, 'search'])
    ->name('parent.search');

Route::post('parent/store', [RepresentanteController::class, 'store'])->name('parent.store');

Route::post('parent/update/{parent}', [RepresentanteController::class, 'update'])->name('parent.update');
Route::post('parent/updatestatusclient/{parent}', [RepresentanteController::class, 'updateStatusClient'])->name('parent.updateStatusClient');
Route::post('parent/updatestatusadmin/{parent}', [RepresentanteController::class, 'updateStatusAdmin'])->name('parent.updateStatusAdmin');

Route::put('parent/update/status/{parent:id}', [RepresentanteController::class, 'updateStatus'])
    ->name('parent.updateStatus');
    
Route::delete('parent/destroy/{id}', [RepresentanteController::class, 'destroy'])->name('parent.destroy');
