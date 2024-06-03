<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\NewsCategoryApiController;

Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);

Route::prefix('v1')->middleware('auth:sanctum', 'throttle:60,1')->group(function () {
    Route::get('/user', [UserApiController::class, 'index']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/news', [NewsApiController::class, 'index']);
    Route::get('/news/{id}', [NewsApiController::class, 'show']);
    Route::get('/news-categories', [NewsCategoryApiController::class, 'index']);
});
