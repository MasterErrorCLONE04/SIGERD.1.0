<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Incident Routes
    Route::get('/incidents', [\App\Http\Controllers\Api\IncidentController::class, 'index']);
    Route::post('/incidents', [\App\Http\Controllers\Api\IncidentController::class, 'store']);
    Route::get('/incidents/{id}', [\App\Http\Controllers\Api\IncidentController::class, 'show']);

    // Task Routes
    Route::get('/tasks', [\App\Http\Controllers\Api\TaskController::class, 'index']);
    Route::get('/tasks/{id}', [\App\Http\Controllers\Api\TaskController::class, 'show']);
    Route::post('/tasks/{id}/update', [\App\Http\Controllers\Api\TaskController::class, 'update']);

    // Admin Routes
    Route::middleware('role:administrador')->prefix('admin')->group(function () {
        Route::get('/dashboard/stats', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'stats']);
    });
});
