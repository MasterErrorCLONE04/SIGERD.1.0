<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Estadísticas de tareas del trabajador
        $totalTasks = Task::where('assigned_to', $userId)->count();
        $assignedTasks = Task::where('assigned_to', $userId)->where('status', 'asignado')->count();
        $inProgressTasks = Task::where('assigned_to', $userId)->where('status', 'en progreso')->count();
        $completedTasks = Task::where('assigned_to', $userId)->where('status', 'finalizada')->count();
        $realizedTasks = Task::where('assigned_to', $userId)->where('status', 'realizada')->count();
        
        // Tareas con fecha límite próxima (próximos 7 días)
        $upcomingDeadlineTasks = Task::where('assigned_to', $userId)
            ->where('deadline_at', '>=', now())
            ->where('deadline_at', '<=', now()->addDays(7))
            ->whereNotIn('status', ['finalizada', 'cancelada', 'realizada'])
            ->count();
        
        // Tareas vencidas
        $overdueTasks = Task::where('assigned_to', $userId)
            ->where('deadline_at', '<', now())
            ->whereNotIn('status', ['finalizada', 'cancelada', 'realizada'])
            ->count();
        
        // Tareas recientes
        $recentTasks = Task::where('assigned_to', $userId)
            ->with(['createdBy'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Tareas urgentes (alta prioridad y no completadas)
        $urgentTasks = Task::where('assigned_to', $userId)
            ->where('priority', 'alta')
            ->whereNotIn('status', ['finalizada', 'cancelada', 'realizada'])
            ->orderBy('deadline_at', 'asc')
            ->limit(5)
            ->get();

        return view('worker.dashboard', compact(
            'totalTasks',
            'assignedTasks',
            'inProgressTasks',
            'completedTasks',
            'realizedTasks',
            'upcomingDeadlineTasks',
            'overdueTasks',
            'recentTasks',
            'urgentTasks'
        ));
    }
}
