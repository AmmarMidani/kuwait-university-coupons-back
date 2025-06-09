<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('user', UserController::class)->name('*', 'user');
    Route::resource('student', StudentController::class)->name('*', 'student');
    Route::resource('meal', MealController::class)->name('*', 'meal');
    Route::resource('nationality', NationalityController::class)->name('*', 'nationality');
    Route::resource('question', QuestionController::class)->name('*', 'question');

    // ROLES
    Route::resource('role', AdminRoleController::class)->name('*', 'role');

    Route::prefix('report')->controller(ReportController::class)->name('report.')->group(function () {
        Route::get('transaction', 'transaction')->name('transaction');
        Route::get('survey', 'survey')->name('survey');
        Route::get('meal', 'meal')->name('meal');
    });
});
