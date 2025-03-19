<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// Rutas públicas
Route::post('login', [AuthController::class, 'login']);

// Rutas protegidas por JWT
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('tasks', TaskController::class);
});
