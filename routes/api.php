<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScriptController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->withoutMiddleware('auth:sanctum')->group(
    function () {
        Route::post('login', [AuthController::class, 'login'])->middleware('guest:' . config('fortify.guard')); // Only guests
        Route::post('register', [AuthController::class, 'register'])->middleware('guest:' . config('fortify.guard')); // Only guests
    }
);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('logout', [AuthController::class, 'logout']); // Only authenticated users
    Route::prefix('scripts')->group(function () {
        Route::post('/run', [ScriptController::class, 'runPythonScript']);
    });
});
