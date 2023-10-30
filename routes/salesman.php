<?php

use App\Http\Controllers\Salesman\SalesmanOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('salesman')->name('salesman.')->middleware(['auth', 'checkSalesman'])->group(function () {
    Route::get('/orders', [SalesmanOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/edit', [SalesmanOrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/orders/{order}/update', [SalesmanOrderController::class, 'update'])->name('orders.update');
});
