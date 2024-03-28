<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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

// Route untuk login dan register
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // Route untuk logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route untuk pengguna
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route untuk pembayaran
    Route::get('payments', [PaymentController::class, 'api']);
    Route::post('payments', [PaymentController::class, 'store']);
    Route::get('payments/{payment}', [PaymentController::class, 'show']);
    Route::delete('payments/{payment}', [PaymentController::class, 'destroy']);

    // Route untuk produk
    Route::get('products', [ProductController::class, 'api']);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);

    // Route untuk keranjang
    Route::get('carts', [CartController::class, 'api']);
    Route::post('carts', [CartController::class, 'store']);
    Route::delete('carts/{cart}', [CartController::class, 'destroy']);

    // Route untuk transaksi
    Route::get('transactions', [TransactionController::class, 'api']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::get('transactions/{transaction}', [TransactionController::class, 'show']);
    Route::get('transactions_edit/{id}', [TransactionController::class, 'edit']);
    Route::put('transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy']);
});
