<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignedTo', 'createdBy']);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('priority') && !empty($request->priority)) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->get();

        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $workers = User::where('role', 'trabajador')->get();
        $priorities = ['baja', 'media', 'alta'];

        return view('admin.tasks.create', compact('workers', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline_at' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'in:baja,media,alta'],
            'status' => ['nullable', 'string', 'in:pendiente,asignado,en progreso,realizada,finalizada,cancelada,incompleta,retraso en proceso'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'initial_evidence_images' => ['nullable', 'array'],
            'initial_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'final_evidence_images' => ['nullable', 'array'],
            'final_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'final_description' => ['nullable', 'string'],
            'reference_images' => ['nullable', 'array'],
            'reference_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->except(['initial_evidence_images', 'final_evidence_images', 'reference_images']);
        $data['created_by'] = auth()->id();
        $data['status'] = 'asignado'; // Default status for direct creation

        // Handle initial evidence images
        $initialEvidenceImagePaths = [];
        if ($request->hasFile('initial_evidence_images')) {
            foreach ($request->file('initial_evidence_images') as $image) {
                $initialEvidenceImagePaths[] = $image->store('tasks-evidence', 'public');
            }
        }
        $data['initial_evidence_images'] = $initialEvidenceImagePaths;

        // Handle reference images
        $referenceImagePaths = [];
        if ($request->hasFile('reference_images')) {
            foreach ($request->file('reference_images') as $image) {
                $referenceImagePaths[] = $image->store('tasks-reference', 'public');
            }
        }
        $data['reference_images'] = $referenceImagePaths;

        $task = Task::create($data);

        // Lógica para cambiar el estado a "incompleta" si la fecha límite ha pasado al momento de la creación
        if ($task->deadline_at < now() && $task->status !== 'finalizada' && $task->status !== 'cancelada') {
            $task->status = 'incompleta';
            $task->save();
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['assignedTo', 'createdBy', 'incident'])->findOrFail($id);
        $statuses = ['asignado', 'en progreso', 'realizada', 'finalizada', 'cancelada', 'incompleta', 'retraso en proceso'];

        return view('admin.tasks.show', compact('task', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $workers = User::where('role', 'trabajador')->get();
        $priorities = ['baja', 'media', 'alta'];
        $statuses = ['asignado', 'en progreso', 'realizada', 'finalizada', 'cancelada', 'incompleta', 'retraso en proceso'];

        return view('admin.tasks.edit', compact('task', 'workers', 'priorities', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline_at' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'in:baja,media,alta'],
            'status' => ['required', 'string', 'in:pendiente,asignado,en progreso,realizada,finalizada,cancelada,incompleta,retraso en proceso'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'initial_evidence_images' => ['nullable', 'array'],
            'initial_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'final_evidence_images' => ['nullable', 'array'],
            'final_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'final_description' => ['nullable', 'string'],
            'reference_images' => ['nullable', 'array'],
            'reference_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $updateData = $request->except(['initial_evidence_images', 'final_evidence_images', 'reference_images']);

        // Handle initial evidence images
        if ($request->hasFile('initial_evidence_images')) {
            $initialEvidenceImagePaths = [];
            foreach ($request->file('initial_evidence_images') as $image) {
                $initialEvidenceImagePaths[] = $image->store('tasks-evidence', 'public');
            }
            $updateData['initial_evidence_images'] = array_merge((array)$task->initial_evidence_images, $initialEvidenceImagePaths);
        }

        // Handle final evidence images
        if ($request->hasFile('final_evidence_images')) {
            $finalEvidenceImagePaths = [];
            foreach ($request->file('final_evidence_images') as $image) {
                $finalEvidenceImagePaths[] = $image->store('tasks-evidence', 'public');
            }
            $updateData['final_evidence_images'] = array_merge((array)$task->final_evidence_images, $finalEvidenceImagePaths);
        }

        // Handle reference images
        if ($request->hasFile('reference_images')) {
            $referenceImagePaths = [];
            foreach ($request->file('reference_images') as $image) {
                $referenceImagePaths[] = $image->store('tasks-reference', 'public');
            }
            $updateData['reference_images'] = array_merge((array)$task->reference_images, $referenceImagePaths);
        }

        $task->update($updateData);

        // Lógica para cambiar el estado a "incompleta" si la fecha límite ha pasado
        if ($task->deadline_at && $task->deadline_at < now() && $task->status !== 'finalizada' && $task->status !== 'cancelada') {
            $task->status = 'incompleta';
            $task->save();
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Review the specified task and update its status.
     */
    public function reviewTask(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'action' => ['required', 'string', 'in:approve,reject,delay'],
        ]);

        switch ($request->action) {
            case 'approve':
                $task->status = 'finalizada';
                break;
            case 'reject':
                $task->status = 'en progreso'; // Regresa a en progreso para corrección
                break;
            case 'delay':
                $task->status = 'retraso en proceso'; // Pasa a retraso en proceso
                break;
        }

        $task->save();

        return redirect()->route('admin.tasks.show', $task->id)->with('success', 'Revisión de tarea realizada exitosamente.');
    }
}
