<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Estadísticas de incidentes del instructor
        $totalIncidents = Incident::where('reported_by', $userId)->count();
        $pendingReviewIncidents = Incident::where('reported_by', $userId)->where('status', 'pendiente de revisión')->count();
        $assignedIncidents = Incident::where('reported_by', $userId)->where('status', 'asignado')->count();
        $resolvedIncidents = Incident::where('reported_by', $userId)->where('status', 'resuelto')->count();
        $closedIncidents = Incident::where('reported_by', $userId)->where('status', 'cerrado')->count();
        
        // Incidentes recientes
        $recentIncidents = Incident::where('reported_by', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Incidentes pendientes de revisión
        $pendingIncidents = Incident::where('reported_by', $userId)
            ->where('status', 'pendiente de revisión')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('instructor.dashboard', compact(
            'totalIncidents',
            'pendingReviewIncidents',
            'assignedIncidents',
            'resolvedIncidents',
            'closedIncidents',
            'recentIncidents',
            'pendingIncidents'
        ));
    }
}
