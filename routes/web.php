<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\TravelAttendanceController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TravelUserController;
use App\Models\TravelUser;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'show'])->name('users');
    Route::get('/departments', [DepartmentController::class, 'show'])->name('departments');
    Route::get('/travels', [TravelController::class, 'show'])->name('travels');
    Route::get('/tracking', [TrackingController::class, 'show'])->name('tracking');
    Route::get('/travel-users', [TravelUserController::class, 'show'])->name('travel-users');
    Route::get('/travel-attendance', [TravelAttendanceController::class, 'show'])->name('travel-attendance');
});

Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');