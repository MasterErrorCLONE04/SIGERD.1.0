<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IncidentController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Worker\DashboardController as WorkerDashboardController;

/* |-------------------------------------------------------------------------- | Rutas Principales y Redirección de Dashboard |-------------------------------------------------------------------------- */

// Ruta de bienvenida (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// Ruta inteligente de Dashboard: Redirige al usuario a su panel específico según su rol
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    elseif ($user->isInstructor()) {
        return redirect()->route('instructor.dashboard');
    }
    elseif ($user->isTrabajador()) {
        return redirect()->route('worker.dashboard');
    }

    // Seguridad: Si el rol no es válido, se cierra la sesión
    Auth::logout();
    return redirect()->route('login')->with('error', 'No tienes permisos para acceder al sistema.');
})->middleware(['auth', 'verified'])->name('dashboard');

/* |-------------------------------------------------------------------------- | Rutas Comunes para todos los Usuarios Autenticados |-------------------------------------------------------------------------- */
Route::middleware('auth')->group(function () {
    // Gestión de Perfil (Ver, Editar, Actualizar y Eliminar cuenta)
    Route::get('/profile/show', [ProfileController::class , 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

    // Módulos Generales: Configuración y Soporte
    Route::view('/settings', 'settings.index')->name('settings.index');
    Route::view('/support', 'support.index')->name('support.index');

    // Sistema de Notificaciones en tiempo real
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class , 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\NotificationController::class , 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\NotificationController::class , 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class , 'markAllAsRead'])->name('notifications.mark-all-as-read');
});

/* |-------------------------------------------------------------------------- | Panel de ADMINISTRATIVO (Control Total) |-------------------------------------------------------------------------- */
Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard con KPI y estadísticas
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

    // CRUD Completo de Usuarios (Crear, Ver, Editar, Borrar)
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);

    // Gestión Operativa de Tareas
    Route::resource('/tasks', \App\Http\Controllers\Admin\TaskController::class)->except(['create']);
    Route::get('/tasks-export-pdf', [\App\Http\Controllers\Admin\TaskController::class , 'exportPDF'])->name('tasks.export-pdf'); // Reporte Mensual PDF
    Route::put('/tasks/{task}/review', [\App\Http\Controllers\Admin\TaskController::class , 'reviewTask'])->name('tasks.review'); // Aprobar/Rechazar Tareas

    // Gestión de Incidentes reportados
    Route::resource('/incidents', IncidentController::class)->only(['index', 'show', 'store']);
    Route::post('/incidents/{incident}/convert-to-task', [IncidentController::class , 'convert-to-task'])->name('incidents.convert-to-task'); // Flujo: Incidente -> Tarea
});

/* |-------------------------------------------------------------------------- | Panel de INSTRUCTOR (Reporte y Seguimiento) |-------------------------------------------------------------------------- */
Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    // Dashboard Personal del Instructor
    Route::get('/dashboard', [InstructorDashboardController::class , 'index'])->name('dashboard');

    // CRUD de Incidentes: Crear y ver estados de sus propios reportes
    Route::resource('/incidents', \App\Http\Controllers\Instructor\IncidentController::class);
});

/* |-------------------------------------------------------------------------- | Panel de TRABAJADOR / OPERARIO (Ejecución de Tareas) |-------------------------------------------------------------------------- */
Route::middleware(['auth', 'role:trabajador'])->prefix('worker')->name('worker.')->group(function () {
    // Dashboard con lista de tareas asignadas para hoy
    Route::get('/dashboard', [WorkerDashboardController::class , 'index'])->name('dashboard');

    // El trabajador solo puede Listar, Ver y Actualizar (subir evidencias) sus tareas
    Route::resource('/tasks', \App\Http\Controllers\Worker\TaskController::class)->only(['index', 'show', 'update']);
});

// Importación de rutas de Autenticación (Laravel Breeze/Fortify)
require __DIR__ . '/auth.php';
