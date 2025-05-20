<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Student\StudentController;


Route::prefix('student')->namespace('API\Student')->group(function () {
    /**
     * Auth Routes
     */
    Route::post('login', [StudentController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('change-password', [StudentController::class, 'changePassword']);
        Route::get('profile', [StudentController::class, 'profile']);
        Route::get('logout', [StudentController::class, 'logout']);
    });
});
