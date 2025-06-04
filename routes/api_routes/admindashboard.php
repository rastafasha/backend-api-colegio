<?php

use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('admindashboard', [DashboardController::class, 'index'])->name('admindashboard.index');
Route::get('admindashboard/config', [DashboardController::class, 'config'])->name('admindashboard.config');
Route::get('admindashboard/activos', [DashboardController::class, 'activos'])->name('admindashboard.activos');
Route::get('admindashboard/show/{id}', [DashboardController::class, 'show'])->name('admindashboard.show');
Route::get('admindashboard/showstudent/{id}', [DashboardController::class, 'showstudent'])->name('admindashboard.showstudent');
Route::get('admindashboard/pdf/{studentId}', [DashboardController::class, 'generatePdf']);

Route::post('admindashboard/store', [DashboardController::class, 'store'])->name('admindashboard.store');
Route::post('admindashboard/update/{slider}', [DashboardController::class, 'update'])->name('admindashboard.update');
Route::delete('admindashboard/destroy/{id}', [DashboardController::class, 'destroy'])->name('admindashboard.destroy');
