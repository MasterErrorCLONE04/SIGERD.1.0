<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::where('assigned_to', Auth::id())->with(['assignedTo', 'createdBy']);

        // Aplicar búsqueda si se proporciona
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Aplicar filtro de estado
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Aplicar filtro de prioridad
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // Ordenar por fecha límite (más urgentes primero)
        $tasks = $query->orderBy('deadline_at', 'asc')->paginate(10)->withQueryString();

        return view('worker.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No se permite al trabajador crear tareas, solo al administrador.
        abort(403, 'Unauthorized action.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // No se permite al trabajador crear tareas, solo al administrador.
        abort(403, 'Unauthorized action.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('assigned_to', Auth::id())->with(['assignedTo', 'createdBy'])->findOrFail($id);
        $statuses = ['pendiente', 'en progreso', 'finalizada', 'cancelada'];

        return view('worker.tasks.show', compact('task', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // No se requiere un método edit separado ya que show manejará la vista de detalle/edición.
        abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::where('assigned_to', Auth::id())->findOrFail($id);

        // Validar campos básicos primero
        $request->validate([
            'status' => ['nullable', 'string', 'in:asignado,en progreso,finalizada,cancelada,incompleta,realizada,retraso en proceso'],
            'final_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $updateData = [];
        // Optional: only allow safe statuses if explicitly requested
        if ($request->filled('status') && in_array($request->status, ['en progreso', 'realizada'])) {
            $updateData['status'] = $request->status;
        }
        $request->validate([
            'initial_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'final_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        try {
            // Manejar la subida de imágenes de evidencia inicial
            if ($request->hasFile('initial_evidence_images')) {
                $initialPaths = [];
                foreach ($request->file('initial_evidence_images') as $file) {
                    $initialPaths[] = $file->store('tasks-evidence', 'public');
                }
                $updateData['initial_evidence_images'] = array_merge((array) $task->initial_evidence_images, $initialPaths);

                if ($task->status === 'asignado') {
                    $updateData['status'] = 'en progreso';
                }
            }

            // Manejar la subida de imágenes de evidencia final
            if ($request->hasFile('final_evidence_images') && $request->filled('final_description')) {
                $finalPaths = [];
                foreach ($request->file('final_evidence_images') as $file) {
                    $finalPaths[] = $file->store('tasks-evidence', 'public');
                }
                $updateData['final_evidence_images'] = array_merge((array) $task->final_evidence_images, $finalPaths);
                $updateData['final_description'] = $request->final_description;

                if ($task->status === 'en progreso') {
                    $updateData['status'] = 'realizada';
                }
            }

            $task->update($updateData);

            // Crear notificación para el administrador que creó la tarea
            if ($task->created_by) {
                $notificationMessage = '';
                $notificationType = 'task_updated';

                if (isset($updateData['status'])) {
                    if ($updateData['status'] === 'en progreso') {
                        $notificationMessage = Auth::user()->name . ' ha iniciado el trabajo en: ' . $task->title;
                    } elseif ($updateData['status'] === 'realizada') {
                        $notificationMessage = Auth::user()->name . ' ha completado: ' . $task->title;
                        $notificationType = 'task_completed';
                    } else {
                        $notificationMessage = Auth::user()->name . ' actualizó la tarea: ' . $task->title;
                    }

                    \App\Models\Notification::create([
                        'user_id' => $task->created_by,
                        'type' => $notificationType,
                        'title' => 'Actualización de Tarea',
                        'message' => $notificationMessage,
                        'link' => route('admin.tasks.show', $task->id),
                    ]);
                }
            }

            return redirect()->route('worker.tasks.index')->with('success', 'Tarea actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['images' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // No se permite al trabajador eliminar tareas, solo al administrador.
        abort(403, 'Unauthorized action.');
    }
}
