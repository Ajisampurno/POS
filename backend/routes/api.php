<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('payments', [PaymentController::class, 'api']);
Route::get('payments/{payment}', [paymentController::class, 'show']);
Route::delete('payments/{id}', [PaymentController::class, 'destroy']);

Route::get('products', [ProductController::class, 'api']);
Route::post('products', [ProductController::class, 'store']);
Route::delete('products/{product}', [ProductController::class, 'destroy']);

Route::get('carts', [CartController::class, 'api']);
Route::post('carts', [CartController::class, 'store']);
