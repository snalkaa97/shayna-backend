<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TransactionController;


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

Auth::routes(['register' => false]);
Route::middleware('auth')->group(function () {
    Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('pages')->group(function () {
        Route::controller(ProductController::class)->group(function(){
            Route::resource('/products', ProductController::class);
            Route::get('products/{id}/gallery', [ProductController::class, 'gallery'])->name('products.gallery');
        });
        Route::controller(ProductGalleryController::class)->group(function(){
            Route::resource('/product-galleries', ProductGalleryController::class);
        });
        Route::controller(TransactionController::class)->group(function(){
            Route::get('/transactions/{id}/set-status', [TransactionController::class, 'setStatus'])->name('transactions.status');
            Route::resource('/transactions', TransactionController::class);
        });
    });
});

// Route::prefix('admin')->group(function () {
//     Route::get('/users',
// });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');