<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\MapAnalyzeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'checkAdmin'])->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/orders/{order}/update', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::get('/map', [AdminOrderController::class, 'map'])->name('map');
});

Route::prefix('api')->name('api.')->group(function () {
    Route::get('stores', [MapAnalyzeController::class, 'stores'])->name('stores');
    Route::get('stores/{store}', [MapAnalyzeController::class, 'showStore'])->name('showStore');
    Route::get('density', [MapAnalyzeController::class, 'showDensity'])->name('showDensity');
    Route::get('roads', [MapAnalyzeController::class, 'showRoads'])->name('showRoads');
});
