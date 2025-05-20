<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Student\AuthController;
use App\Http\Controllers\API\Student\StudentController;


Route::prefix('student')->namespace('API\Student')->group(function () {
    /**
     * Auth Routes
     */
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        // Auth Routes
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::get('logout', [AuthController::class, 'logout']);

        // home page Routes
        Route::get('generate-new-qr', [StudentController::class, 'generateNewQr']);
        Route::get('next-upcoming-meal', [StudentController::class, 'nextUpcomingMeal']);
    });
});
