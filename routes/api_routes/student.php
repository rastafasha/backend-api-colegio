<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('students', [StudentController::class, 'index'])->name('student.index');
Route::get('student/show/{id}', [StudentController::class, 'show'])->name('student.show');
Route::get('student/byparent/{id}', [StudentController::class, 'studentbyParent'])->name('student.studentbyParent');
Route::get('student/paymentbyid/{id}', [StudentController::class, 'paymentbyStudent'])->name('student.paymentbyStudent');

Route::get('student/search/{request}', [StudentController::class, 'search'])
    ->name('student.search');

Route::post('student/store', [StudentController::class, 'store'])->name('student.store');

Route::post('student/update/{proveedor}', [StudentController::class, 'update'])->name('student.update');
Route::post('student/updatestatusadmin/{proveedor}', [StudentController::class, 'updateStatusAdmin'])->name('student.updateStatusAdmin');

Route::delete('student/destroy/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
