<?php
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [APIController::class, 'login'])->name('login');

Route::get('get-user-travels', [APIController::class, 'getUserTravels'])->name('get-user-travels');

Route::post('record-travel', [APIController::class, 'recordTravel'])->name('record-travel');

Route::post('set-status', [APIController::class, 'setStatus'])->name('set-status'); 

Route::post('time-in', [APIController::class, 'recordTimeIn'])->name('time-in'); 

Route::post('time-out', [APIController::class, 'recordTimeOut'])->name('time-out'); 

Route::post('clear-status', [APIController::class, 'clearStatus'])->name('clear-status');

Route::post('record-location', [APIController::class, 'recordCurrentLocation'])->name('record-location');