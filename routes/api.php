<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserApiController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::prefix('v1')->middleware('auth:sanctum', 'throttle:60,1')->group(function () {
    Route::get('/user', [UserApiController::class, 'index']);
});