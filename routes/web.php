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
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ManualMealEntryController;
use App\Http\Controllers\QrCodeScannerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/lang/{locale}', [LanguageController::class, 'index'])->name('lang.switch');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->middleware('permission:dashboard')->name('home');

    Route::resource('user', UserController::class)->middleware('permission:user_browse')->name('*', 'user');
    Route::resource('student', StudentController::class)->middleware('permission:student_browse')->name('*', 'student');
    Route::resource('meal', MealController::class)->middleware('permission:meal_browse')->name('*', 'meal');
    Route::resource('meal-price', MealPriceController::class)->middleware('permission:meal_price_browse')->name('*', 'meal_price');
    Route::resource('nationality', NationalityController::class)->middleware('permission:nationality_browse')->name('*', 'nationality');
    Route::resource('question', QuestionController::class)->middleware('permission:question_browse')->name('*', 'question');

    Route::get('manual-meal-entry', [ManualMealEntryController::class, 'index'])->middleware('permission:manual_meal_entry_browse')->name('manual-meal-entry.index');
    Route::post('manual-meal-entry', [ManualMealEntryController::class, 'store'])->middleware('permission:manual_meal_entry_add')->name('manual-meal-entry.store');
    Route::post('manual-meal-entry/verify', [ManualMealEntryController::class, 'verify'])->middleware('permission:manual_meal_entry_browse')->name('manual-meal-entry.verify');
    Route::post('manual-meal-entry/users', [ManualMealEntryController::class, 'users'])->middleware('permission:manual_meal_entry_browse')->name('manual-meal-entry.users');

    Route::get('qr-code-scanner', [QrCodeScannerController::class, 'index'])->middleware('permission:qr_code_scanner_browse')->name('qr-code-scanner.index');
    Route::post('qr-code-scanner', [QrCodeScannerController::class, 'store'])->middleware('permission:qr_code_scanner_add')->name('qr-code-scanner.store');
    Route::post('qr-code-scanner/verify', [QrCodeScannerController::class, 'verify'])->middleware('permission:qr_code_scanner_browse')->name('qr-code-scanner.verify');

    // ROLES
    Route::resource('role', AdminRoleController::class)->middleware('permission:role_browse')->name('*', 'role');

    Route::prefix('report')->controller(ReportController::class)->name('report.')->group(function () {
        Route::get('transaction', 'transaction')->middleware('permission:report_transaction')->name('transaction');
        Route::get('meal_per_day', 'meal_per_day')->middleware('permission:report_meal_per_day')->name('meal_per_day');
        Route::post('meal_per_day', 'meal_per_day_generate_excel')->middleware('permission:report_meal_per_day')->name('meal_per_day_generate_excel');
        Route::get('survey', 'survey')->middleware('permission:report_survey')->name('survey');
        Route::get('meal', 'meal')->middleware('permission:report_meal')->name('meal');
    });
});
