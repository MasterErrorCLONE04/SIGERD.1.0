<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IncidentController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Worker\DashboardController as WorkerDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('/tasks', \App\Http\Controllers\Admin\TaskController::class);
    Route::put('/tasks/{task}/review', [\App\Http\Controllers\Admin\TaskController::class, 'reviewTask'])->name('tasks.review');
    Route::resource('/incidents', IncidentController::class)->only(['index', 'show']);
    Route::post('/incidents/{incident}/convert-to-task', [IncidentController::class, 'convertToTask'])->name('incidents.convert-to-task');
});

Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/incidents', \App\Http\Controllers\Instructor\IncidentController::class);
});

Route::middleware(['auth', 'role:trabajador'])->prefix('worker')->name('worker.')->group(function () {
    Route::get('/dashboard', [WorkerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/tasks', \App\Http\Controllers\Worker\TaskController::class)->only(['index', 'show', 'update']);
});

require __DIR__.'/auth.php';
