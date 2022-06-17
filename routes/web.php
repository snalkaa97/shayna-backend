<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;


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
        });
    });
});

// Route::prefix('admin')->group(function () {
//     Route::get('/users',
// });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');