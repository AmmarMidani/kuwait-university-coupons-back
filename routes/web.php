<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('user', UserController::class)->name('*', 'user');
Route::resource('student', StudentController::class)->name('*', 'student');
Route::resource('meal', MealController::class)->name('*', 'meal');
Route::resource('nationality', NationalityController::class)->name('*', 'nationality');
Route::resource('question', QuestionController::class)->name('*', 'question');

// Route::prefix('report')->controller(ReportController::class)->name('report.')->group(function () {
//     Route::get('store', 'store')->middleware('permission:report_store')->name('store');
//     Route::get('order', 'order')->middleware('permission:report_order')->name('order');
//     Route::get('invitems', 'invitems')->middleware('permission:report_order')->name('invitems');
//     Route::get('orditems', 'orditems')->middleware('permission:report_order')->name('orditems');
//     Route::get('employee_work', 'employee_work')->middleware('permission:report_employee_work')->name('employee_work');
//     Route::get('maintenance', 'maintenance')->middleware('permission:report_maintenance')->name('maintenance');
// });
