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
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('reportedBy', function ($userQuery) use ($search) {
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
        $incidents = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'report_date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        // Validar manualmente las imágenes sin usar fileinfo
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB en bytes
        $initialEvidenceImagePaths = [];

        if (isset($_FILES['initial_evidence_images']) && $_FILES['initial_evidence_images']['error'][0] !== UPLOAD_ERR_NO_FILE) {
            $files = $_FILES['initial_evidence_images'];
            $fileCount = count($files['name']);

            // Límite de 10 imágenes
            if ($fileCount > 10) {
                return back()->withErrors(['initial_evidence_images' => 'No puedes subir más de 10 imágenes.'])->withInput();
            }

            if ($fileCount === 0) {
                return back()->withErrors(['initial_evidence_images' => 'Debe subir al menos una imagen de evidencia.'])->withInput();
            }

            // Crear directorio si no existe
            $uploadDir = storage_path('app/public/incident-evidence');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            for ($i = 0; $i < $fileCount; $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $fileName = $files['name'][$i];
                    $fileTmpName = $files['tmp_name'][$i];
                    $fileSize = $files['size'][$i];

                    // Validar extensión
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        return back()->withErrors(['initial_evidence_images' => "El archivo '{$fileName}' tiene una extensión no permitida. Solo se permiten: " . implode(', ', $allowedExtensions)])->withInput();
                    }

                    // Validar tamaño
                    if ($fileSize > $maxSize) {
                        return back()->withErrors(['initial_evidence_images' => "El archivo '{$fileName}' excede el tamaño máximo de 2MB."])->withInput();
                    }

                    // Generar nombre único
                    $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
                    $destinationPath = $uploadDir . '/' . $newFileName;

                    // Mover archivo
                    if (move_uploaded_file($fileTmpName, $destinationPath)) {
                        $initialEvidenceImagePaths[] = 'incident-evidence/' . $newFileName;
                    } else {
                        return back()->withErrors(['initial_evidence_images' => "Error al subir el archivo '{$fileName}'."])->withInput();
                    }
                } elseif ($files['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                    return back()->withErrors(['initial_evidence_images' => "Error al subir el archivo: código de error {$files['error'][$i]}."])->withInput();
                }
            }
        } else {
            return back()->withErrors(['initial_evidence_images' => 'Debe subir al menos una imagen de evidencia.'])->withInput();
        }

        $incident = Incident::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'report_date' => $request->report_date,
            'status' => 'pendiente de revisión',
            'reported_by' => Auth::id(),
            'initial_evidence_images' => $initialEvidenceImagePaths,
        ]);

        return redirect()->route('admin.incidents.index')->with('success', 'Falla reportada exitosamente.');
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
