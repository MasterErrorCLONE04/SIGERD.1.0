<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Incident;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalUsers = User::count();
        $totalTasks = Task::count();
        $pendingIncidents = Incident::where('status', 'pendiente de revisión')->count();
        $overdueTasks = Task::where('deadline_at', '<', now())
            ->whereNotIn('status', ['finalizada', 'cancelada', 'realizada'])
            ->count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_tasks' => $totalTasks,
            'pending_incidents' => $pendingIncidents,
            'overdue_tasks' => $overdueTasks,
        ]);
    }
}
