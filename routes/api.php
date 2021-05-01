<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaccionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('users',AuthController::class)->only(['store']);
    Route::apiResource('transaccion',TransaccionController::class);
});
