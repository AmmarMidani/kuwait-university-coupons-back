<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MealPriceController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\ManualMealEntryController;
use App\Http\Controllers\QrCodeScannerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('user', UserController::class)->name('*', 'user');
    Route::resource('student', StudentController::class)->name('*', 'student');
    Route::resource('meal', MealController::class)->name('*', 'meal');
    Route::resource('meal-price', MealPriceController::class)->name('*', 'meal_price');
    Route::resource('nationality', NationalityController::class)->name('*', 'nationality');
    Route::resource('question', QuestionController::class)->name('*', 'question');

    Route::get('manual-meal-entry', [ManualMealEntryController::class, 'index'])->name('manual-meal-entry.index');
    Route::post('manual-meal-entry', [ManualMealEntryController::class, 'store'])->name('manual-meal-entry.store');
    Route::post('manual-meal-entry/verify', [ManualMealEntryController::class, 'verify'])->name('manual-meal-entry.verify');

    Route::get('qr-code-scanner', [QrCodeScannerController::class, 'index'])->name('qr-code-scanner.index');
    Route::post('qr-code-scanner', [QrCodeScannerController::class, 'store'])->name('qr-code-scanner.store');
    Route::post('qr-code-scanner/verify', [QrCodeScannerController::class, 'verify'])->name('qr-code-scanner.verify');

    // ROLES
    Route::resource('role', AdminRoleController::class)->name('*', 'role');

    Route::prefix('report')->controller(ReportController::class)->name('report.')->group(function () {
        Route::get('transaction', 'transaction')->name('transaction');
        Route::get('survey', 'survey')->name('survey');
        Route::get('meal', 'meal')->name('meal');
    });
});
