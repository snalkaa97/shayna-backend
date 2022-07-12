<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware'=> ['auth:sanctum']], function(){
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('/logout',[AuthController::class, 'logout']);
});
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::get('products',[ProductController::class, 'all']);
Route::post('checkout',[CheckoutController::class, 'checkout']);
Route::get('transaction/{id}',[TransactionController::class, 'get']);