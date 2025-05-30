<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MorosoController;

Route::get('moroso', [MorosoController::class, 'index'])->name('moroso.index');
Route::get('moroso/deudoresactuales/', [MorosoController::class, 'getDebtorsForCurrentMonth'])->name('moroso.getDebtorsForCurrentMonth');
