<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->withoutMiddleware('auth:sanctum')->group(
    function () {
        Route::post('login', [AuthController::class, 'login'])->middleware('guest:' . config('fortify.guard')); // Only guests
        Route::post('register', [AuthController::class, 'register'])->middleware('guest:' . config('fortify.guard')); // Only guests
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Only authenticated users
    }
);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
});
