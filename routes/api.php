<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Student\AuthController;


Route::prefix('student')->namespace('API\Student')->group(function () {
    /**
     * Auth Routes
     */
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});
