<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaccionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('users/login', [AuthController::class, 'login']);
    Route::apiResource('users',AuthController::class)->only(['store']);
    Route::apiResource('transacciones',TransaccionController::class)->only(['store']);
});
