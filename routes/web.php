<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('language/{locale}', [LangController::class, "changeLang"])->name('changeLanguage');

Route::get('/', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::resource('/products', ProductController::class);

Route::resource('/users', UserController::class)->middleware(['auth', 'verified']);
Route::get('/users/{user}/products', [UserController::class, 'showUserProducts'])
    ->name('user.products')->middleware(['auth', 'checkSalesman']);


Route::resource('/contacts', ContactController::class)->middleware(['auth', 'verified']);

Route::resource('/cart', CartController::class);

Route::resource('/orders', OrderController::class)->middleware(['auth', 'verified']);

Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('product.review.store');

Route::delete('/orders/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/salesman.php';
