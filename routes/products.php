<?php

declare(strict_types=1);

use App\Http\Controllers\Product\ProductCreateController;
use App\Http\Controllers\Product\ProductDeleteController;
use App\Http\Controllers\Product\ProductEditController;
use App\Http\Controllers\Product\ProductIndexController;
use App\Http\Controllers\Product\ProductStoreController;
use App\Http\Controllers\Product\ProductUpdateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/products', ProductIndexController::class)->name('products.index');
    Route::get('/products/create', ProductCreateController::class)->name('products.create');
    Route::post('/products/store', ProductStoreController::class)->name('products.store');
    Route::get('/products/{product}/edit', ProductEditController::class)->name('products.edit');
    Route::put('/products/{product}', ProductUpdateController::class)->name('products.update');
    Route::delete('/products/{product}', ProductDeleteController::class)->name('products.delete');
});
