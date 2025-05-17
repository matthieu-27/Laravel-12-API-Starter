<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->withoutMiddleware('auth:sanctum')->group(
    function () {
        Route::post('login', [AuthController::class, 'login'])->middleware('guest:' . config('fortify.guard')); // Only guests
        Route::post('register', [AuthController::class, 'register'])->middleware('guest:' . config('fortify.guard')); // Only guests
    }
);

Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource('users', UserController::class);
});
