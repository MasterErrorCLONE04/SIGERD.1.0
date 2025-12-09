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
    public function index()
    {
        $tasks = Task::where('assigned_to', Auth::id())->with(['assignedTo', 'createdBy'])->get();

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

        $request->validate([
            'status' => ['nullable', 'string', 'in:asignado,en progreso,finalizada,cancelada,incompleta,realizada,retraso en proceso'],
            'initial_evidence_images' => ['nullable', 'array'],
            'initial_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'final_evidence_images' => ['nullable', 'array'],
            'final_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'final_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $updateData = ['status' => $request->status];

        // Manejar la subida de imágenes de evidencia inicial
        if ($request->hasFile('initial_evidence_images')) {
            $initialEvidenceImagePaths = [];
            foreach ($request->file('initial_evidence_images') as $image) {
                $initialEvidenceImagePaths[] = $image->store('tasks-evidence', 'public');
            }
            $updateData['initial_evidence_images'] = array_merge((array)$task->initial_evidence_images, $initialEvidenceImagePaths);

            // Si se sube evidencia inicial y la tarea está asignada, cambiar a "en progreso"
            if ($task->status === 'asignado') {
                $updateData['status'] = 'en progreso';
            }
        }
        
        // Manejar la subida de imágenes de evidencia final y descripción final
        if ($request->hasFile('final_evidence_images') && $request->filled('final_description')) {
            $finalEvidenceImagePaths = [];
            foreach ($request->file('final_evidence_images') as $image) {
                $finalEvidenceImagePaths[] = $image->store('tasks-evidence', 'public');
            }
            $updateData['final_evidence_images'] = array_merge((array)$task->final_evidence_images, $finalEvidenceImagePaths);
            $updateData['final_description'] = $request->final_description;

            // Si se sube evidencia final y descripción, y la tarea está en progreso, cambiar a "realizada"
            if ($task->status === 'en progreso') {
                $updateData['status'] = 'realizada';
            }
        }

        $task->update($updateData);

        return redirect()->route('worker.tasks.index')->with('success', 'Tarea actualizada exitosamente.');
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
