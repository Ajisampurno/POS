<?php

use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionDetailController;

Route::get('TransactionDetail/api', [TransactionDetailController::class, 'api']);
