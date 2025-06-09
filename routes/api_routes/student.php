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

Route::post('student/update/{student}', [StudentController::class, 'update'])->name('student.update');
Route::post('student/updatestatusadmin/{student}', [StudentController::class, 'updateStatusAdmin'])->name('student.updateStatusAdmin');

Route::put('student/update/status/{student:id}', [StudentController::class, 'updateStatus'])
    ->name('student.updateStatus');

Route::delete('student/destroy/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
