<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminPaymentController;

//pagos

// Route::get('/pagos', [AdminPaymentController::class, 'index'])
//     ->name('payments.index');
Route::get('/payment', [AdminPaymentController::class, 'index'])
    ->name('payment.index');
Route::post('/payment/store', [AdminPaymentController::class, 'paymentStore'])
    ->name('payment.store');


Route::get('/payment/show/{payment}', [AdminPaymentController::class, 'paymentShow'])
    ->name('payment.show');

Route::put('/payment/update/{id}', [AdminPaymentController::class, 'paymentUpdate'])
    ->name('payment.update');

Route::delete('/payment/destroy/{payment:id}', [AdminPaymentController::class, 'paymentDestroy'])
    ->name('payment.destroy');

Route::get('payment/recientes/', [AdminPaymentController::class, 'recientes'])
    ->name('payment.recientes');

Route::get('payment/pendientes', [AdminPaymentController::class, 'pagosPendientes'])
    ->name('payment.pagosPendientes');
Route::get('payment/pendientesbydoctor/{doctor_id}', [AdminPaymentController::class, 'pagosPendientesShowId'])
    ->name('payment.pagosPendientesShowId');

Route::post('/payment/upload', [AdminPaymentController::class, 'upload'])
    ->name('payment.upload');

Route::delete('/payment/delete-foto/{id}', [AdminPaymentController::class, 'deleteFotoPayment'])
    ->name('payment.deleteFotoPayment');

Route::get('/payment/search/', [AdminPaymentController::class, 'search'])
    ->name('payment.search');
    
Route::get('/payment/pagosbyUser/{id}', [AdminPaymentController::class, 'pagosbyUser'])
    ->name('payment.pagosbyUser');

Route::get('/payment/pendientesbyParent/{id}', [AdminPaymentController::class, 'pagosPendientesbyParent'])
    ->name('payment.pagosPendientesbyParent');

Route::put('/payment/update/status/{payment:id}', [AdminPaymentController::class, 'updateStatus'])
    ->name('payment.updateStatus');



// Route for checkDebtStatus
Route::get('/payment/check-debt-status/{parent_id}/{student_id}', [AdminPaymentController::class, 'checkDebtStatus'])
    ->name('payment.checkDebtStatus');
Route::get('/payment/check-debt-status-p/{parent_id}', [AdminPaymentController::class, 'checkDebtStatusByParent'])
    ->name('payment.checkDebtStatusByParent');

Route::get('/payment/debt-by-parent/{parent_id}', [AdminPaymentController::class, 'viewDebtByParent'])
    ->name('payment.viewDebtByParent');

Route::post('/payment/pay-debt/{parent_id}/{student_id}', [AdminPaymentController::class, 'payDebtForStudent'])
    ->name('payment.payDebtForStudent');

Route::post('/payment/generate-monthly-debt', [AdminPaymentController::class, 'generateMonthlyDebtForParents'])
    ->name('payment.generateMonthlyDebtForParents');
