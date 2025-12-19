<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Incident::with('reportedBy');

        // Aplicar búsqueda si se proporciona
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('reportedBy', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Aplicar filtro de fecha de creación (fecha específica)
        if ($request->filled('created_at_from')) {
            $query->whereDate('created_at', '=', $request->input('created_at_from'));
        }

        // Ordenar por fecha de creación (más recientes primero)
        $incidents = $query->orderBy('created_at', 'desc')->get();

        return view('admin.incidents.index', compact('incidents'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $incident = Incident::with('reportedBy')->findOrFail($id);
        $workers = User::where('role', 'trabajador')->get();
        $priorities = ['baja', 'media', 'alta'];

        return view('admin.incidents.show', compact('incident', 'workers', 'priorities'));
    }

    /**
     * Convert the incident to a task.
     */
    public function convertToTask(Request $request, Incident $incident)
    {
        $request->validate([
            'task_title' => ['required', 'string', 'max:255'],
            'task_description' => ['required', 'string'],
            'assigned_to' => ['required', 'exists:users,id'],
            'priority' => ['required', 'string', 'in:baja,media,alta'],
            'deadline_at' => ['required', 'date', 'after_or_equal:today'],
            'location' => ['required', 'string', 'max:255'],
        ]);

        // Crear la tarea
        $task = Task::create([
            'title' => $request->task_title,
            'description' => $request->task_description,
            'priority' => $request->priority,
            'status' => 'asignado', // Estado inicial: "Asignado"
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(), // El administrador que convierte el incidente
            'incident_id' => $incident->id,
            'deadline_at' => $request->deadline_at,
            'location' => $request->location,
            'reference_images' => $incident->initial_evidence_images, // Las imágenes del incidente se convierten en imágenes de referencia de la tarea
        ]);

        // Actualizar el estado del incidente a "Asignado"
        $incident->update([
            'status' => 'asignado',
        ]);

        // Crear notificación para el trabajador asignado
        \App\Models\Notification::create([
            'user_id' => $request->assigned_to,
            'type' => 'task_assigned',
            'title' => 'Nueva Tarea Asignada',
            'message' => 'Te han asignado una nueva tarea: ' . $request->task_title,
            'link' => route('worker.tasks.show', $task->id),
        ]);

        // Crear notificación para el instructor que reportó el incidente
        \App\Models\Notification::create([
            'user_id' => $incident->reported_by,
            'type' => 'incident_converted',
            'title' => 'Incidente Convertido a Tarea',
            'message' => 'Tu incidente "' . $incident->title . '" ha sido convertido en una tarea',
            'link' => route('instructor.incidents.show', $incident->id),
        ]);

        return redirect()->route('admin.incidents.index')->with('success', 'Incidente convertido a tarea exitosamente.');
    }
}
