<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Incident; // Importar el modelo Incident

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas de Usuarios
        $totalUsers = User::count();
        $adminUsers = User::where('role', 'administrador')->count();
        $workerUsers = User::where('role', 'trabajador')->count();
        $instructorUsers = User::where('role', 'instructor')->count();

        // Estadísticas de Tareas
        $totalTasks = Task::count();
        $tasksByStatus = Task::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                               ->groupBy('status')
                               ->pluck('count', 'status');
        $tasksByPriority = Task::select('priority', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                                 ->groupBy('priority')
                                 ->pluck('count', 'priority');
        $pendingTasks = Task::where('status', 'pendiente')->count();
        $inProgressTasks = Task::where('status', 'en progreso')->count();
        $completedTasks = Task::where('status', 'finalizada')->count();
        $realizedTasks = Task::where('status', 'realizada')->count();
        $cancelledTasks = Task::where('status', 'cancelada')->count();
        $incompleteTasks = Task::where('status', 'incompleta')->count();
        $delayedTasks = Task::where('status', 'retraso en proceso')->count();
        $assignedTasksCount = Task::where('status', 'asignado')->count();
        
        // Tareas con fecha límite próxima (ej. en los próximos 7 días) o vencida
        $upcomingDeadlineTasks = Task::where('deadline_at', '>=', now())
                                    ->where('deadline_at', '<=', now()->addDays(7))
                                    ->whereNotIn('status', ['finalizada', 'cancelada', 'realizada'])
                                    ->count();

        $overdueTasks = Task::where('deadline_at', '<', now())
                              ->whereNotIn('status', ['finalizada', 'cancelada', 'realizada'])
                              ->count();

        // Estadísticas de Incidentes
        $totalIncidents = Incident::count();
        $incidentsByStatus = Incident::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                                     ->groupBy('status')
                                     ->pluck('count', 'status');
        $pendingReviewIncidents = Incident::where('status', 'pendiente de revisión')->count();
        $assignedIncidents = Incident::where('status', 'asignado')->count();

        // Datos para los modales de creación
        $roles = ['administrador', 'trabajador', 'instructor'];
        $workers = User::where('role', 'trabajador')->get();
        $priorities = ['baja', 'media', 'alta'];

        return view('admin.dashboard', compact(
            'totalUsers', 'adminUsers', 'workerUsers', 'instructorUsers',
            'totalTasks', 'tasksByStatus', 'tasksByPriority', 'pendingTasks', 'inProgressTasks', 'completedTasks', 'realizedTasks', 'cancelledTasks', 'incompleteTasks', 'delayedTasks', 'assignedTasksCount',
            'upcomingDeadlineTasks', 'overdueTasks',
            'totalIncidents', 'incidentsByStatus', 'pendingReviewIncidents', 'assignedIncidents',
            'roles', 'workers', 'priorities'
        ));
    }
}
