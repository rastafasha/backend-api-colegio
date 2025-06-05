<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


Route::get('category', [CategoryController::class, 'index'])
    ->name('category.index');

Route::post('category/store', [CategoryController::class, 'categoryStore'])
    ->name('category.store');

Route::get('category/show/{category}', [CategoryController::class, 'categoryShow'])
    ->name('category.show');

Route::get('category/showbyName/{category:name}', [CategoryController::class, 'categoryShow'])
    ->name('category.showbyName');

Route::put('category/update/{category}', [CategoryController::class, 'categoryUpdate'])
    ->name('category.update');

Route::delete('category/destroy/{category}', [CategoryController::class, 'destroy'])
    ->name('category.destroy');

    Route::get('category/search', [CategoryController::class, 'search'])
    ->name('category.search');
