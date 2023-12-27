<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
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
    Route::get('revenueByOrderLocation', [MapAnalyzeController::class, 'getRevenueByOrderLocation']);
});

Route::prefix('api')->name('api.')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('group-orders', [OrderController::class, 'groupIndex'])->name('orders.groupIndex');
    Route::get('/orders/{order}/update', [OrderController::class, 'update'])->name('orders.update');
});

Route::prefix('api')->name('api.')->group(function () {
    Route::get('products/profitByDayAndPrevDay', [DashboardController::class, 'productProfitInDayWithPrevDay']);
    Route::get('products/countByDayAndPrevDay', [DashboardController::class, 'productCountInDayWithPrevDay']);
    Route::get('users/countByDayAndPrevDay', [DashboardController::class, 'userCountInDayWithPrevDay']);
    Route::get('products/topProfitByDay', [DashboardController::class, 'getTopProductProfitByDay']);
    Route::get('products/topProfitByWeek', [DashboardController::class, 'getTopProductProfitByWeek']);
    Route::get('products/productRevenueByCategory', [DashboardController::class, 'getProductRevenueByCategory']);
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'verified', 'checkSalesman'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/users', [DashboardController::class, 'showUsers'])->name('users');
    Route::get('/products', [DashboardController::class, 'showProducts'])->name('products');
    Route::get('/orders', [DashboardController::class, 'showOrders'])->name('orders');
});
