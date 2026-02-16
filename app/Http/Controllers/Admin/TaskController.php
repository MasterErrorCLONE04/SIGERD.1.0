<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $workers = User::where('role', 'trabajador')->get();
        $priorities = ['baja', 'media', 'alta'];

        return view('admin.tasks.index', compact('tasks', 'workers', 'priorities'));
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
        // Validar campos básicos primero
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline_at' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'in:baja,media,alta'],
            'status' => ['nullable', 'string', 'in:pendiente,asignado,en progreso,realizada,finalizada,cancelada,incompleta,retraso en proceso'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'final_description' => ['nullable', 'string'],
        ]);

        $data = $request->except(['initial_evidence_images', 'final_evidence_images', 'reference_images']);
        $data['created_by'] = auth()->id();
        $data['status'] = 'asignado'; // Default status for direct creation

        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        $maxSizeBytes = 2048 * 1024; // 2MB en bytes

        // Función helper para validar y guardar imágenes
        $processImages = function ($files, $fieldName, $folder) use ($allowedExtensions, $maxSizeBytes) {
            $imagePaths = [];

            if (isset($files[$fieldName]) && is_array($files[$fieldName]['name'])) {
                // Múltiples archivos
                $fileCount = count($files[$fieldName]['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($files[$fieldName]['error'][$i] === UPLOAD_ERR_OK) {
                        $fileName = $files[$fieldName]['name'][$i];
                        $fileSize = $files[$fieldName]['size'][$i];
                        $tmpName = $files[$fieldName]['tmp_name'][$i];
                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                        // Validar extensión
                        if (!in_array($extension, $allowedExtensions)) {
                            throw new \Exception("El archivo {$fileName} debe ser una imagen (jpeg, jpg, png o gif).");
                        }

                        // Validar tamaño
                        if ($fileSize > $maxSizeBytes) {
                            throw new \Exception("El archivo {$fileName} no debe exceder 2MB.");
                        }

                        // Generar nombre único
                        $newFileName = $folder . '/' . uniqid() . '_' . time() . '_' . $i . '.' . $extension;
                        $destinationPath = storage_path('app/public/' . $newFileName);

                        // Crear directorio si no existe
                        $directory = dirname($destinationPath);
                        if (!is_dir($directory)) {
                            mkdir($directory, 0755, true);
                        }

                        // Mover el archivo
                        if (move_uploaded_file($tmpName, $destinationPath)) {
                            $imagePaths[] = $newFileName;
                        } else {
                            throw new \Exception("Error al subir el archivo {$fileName}.");
                        }
                    }
                }
            } elseif (isset($files[$fieldName]) && $files[$fieldName]['error'] === UPLOAD_ERR_OK) {
                // Un solo archivo
                $fileName = $files[$fieldName]['name'];
                $fileSize = $files[$fieldName]['size'];
                $tmpName = $files[$fieldName]['tmp_name'];
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Validar extensión
                if (!in_array($extension, $allowedExtensions)) {
                    throw new \Exception("El archivo {$fileName} debe ser una imagen (jpeg, jpg, png o gif).");
                }

                // Validar tamaño
                if ($fileSize > $maxSizeBytes) {
                    throw new \Exception("El archivo {$fileName} no debe exceder 2MB.");
                }

                // Generar nombre único
                $newFileName = $folder . '/' . uniqid() . '_' . time() . '.' . $extension;
                $destinationPath = storage_path('app/public/' . $newFileName);

                // Crear directorio si no existe
                $directory = dirname($destinationPath);
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Mover el archivo
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    $imagePaths[] = $newFileName;
                } else {
                    throw new \Exception("Error al subir el archivo {$fileName}.");
                }
            }

            return $imagePaths;
        };

        try {
            // Handle initial evidence images
            $initialEvidenceImagePaths = [];
            if (isset($_FILES['initial_evidence_images'])) {
                $hasFiles = false;
                if (is_array($_FILES['initial_evidence_images']['error'])) {
                    foreach ($_FILES['initial_evidence_images']['error'] as $error) {
                        if ($error !== UPLOAD_ERR_NO_FILE) {
                            $hasFiles = true;
                            break;
                        }
                    }
                } else {
                    $hasFiles = $_FILES['initial_evidence_images']['error'] !== UPLOAD_ERR_NO_FILE;
                }

                if ($hasFiles) {
                    $initialEvidenceImagePaths = $processImages($_FILES, 'initial_evidence_images', 'tasks-evidence');
                }
            }
            $data['initial_evidence_images'] = $initialEvidenceImagePaths;

            // Handle reference images
            $referenceImagePaths = [];
            if (isset($_FILES['reference_images'])) {
                $hasFiles = false;
                if (is_array($_FILES['reference_images']['error'])) {
                    foreach ($_FILES['reference_images']['error'] as $error) {
                        if ($error !== UPLOAD_ERR_NO_FILE) {
                            $hasFiles = true;
                            break;
                        }
                    }
                } else {
                    $hasFiles = $_FILES['reference_images']['error'] !== UPLOAD_ERR_NO_FILE;
                }

                if ($hasFiles) {
                    $referenceImagePaths = $processImages($_FILES, 'reference_images', 'tasks-reference');
                }
            }
            $data['reference_images'] = $referenceImagePaths;

            $task = Task::create($data);

            // Lógica para cambiar el estado a "incompleta" si la fecha límite ha pasado al momento de la creación
            if ($task->deadline_at < now() && $task->status !== 'finalizada' && $task->status !== 'cancelada') {
                $task->status = 'incompleta';
                $task->save();
            }

            // Crear notificación para el trabajador asignado
            if ($task->assigned_to) {
                \App\Models\Notification::create([
                    'user_id' => $task->assigned_to,
                    'type' => 'task_assigned',
                    'title' => 'Nueva Tarea Asignada',
                    'message' => 'Te han asignado una nueva tarea: ' . $task->title,
                    'link' => route('worker.tasks.show', $task->id),
                ]);
            }

            return redirect()->route('admin.tasks.index')->with('success', 'Tarea creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['images' => $e->getMessage()])
                ->withInput();
        }
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

        // Validar campos básicos primero
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline_at' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'in:baja,media,alta'],
            'status' => ['required', 'string', 'in:pendiente,asignado,en progreso,realizada,finalizada,cancelada,incompleta,retraso en proceso'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'final_description' => ['nullable', 'string'],
        ]);

        $updateData = $request->except(['initial_evidence_images', 'final_evidence_images', 'reference_images']);

        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        $maxSizeBytes = 2048 * 1024; // 2MB en bytes

        // Función helper para validar y guardar imágenes
        $processImages = function ($files, $fieldName, $folder) use ($allowedExtensions, $maxSizeBytes) {
            $imagePaths = [];

            if (isset($files[$fieldName]) && is_array($files[$fieldName]['name'])) {
                // Múltiples archivos
                $fileCount = count($files[$fieldName]['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($files[$fieldName]['error'][$i] === UPLOAD_ERR_OK) {
                        $fileName = $files[$fieldName]['name'][$i];
                        $fileSize = $files[$fieldName]['size'][$i];
                        $tmpName = $files[$fieldName]['tmp_name'][$i];
                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                        // Validar extensión
                        if (!in_array($extension, $allowedExtensions)) {
                            throw new \Exception("El archivo {$fileName} debe ser una imagen (jpeg, jpg, png o gif).");
                        }

                        // Validar tamaño
                        if ($fileSize > $maxSizeBytes) {
                            throw new \Exception("El archivo {$fileName} no debe exceder 2MB.");
                        }

                        // Generar nombre único
                        $newFileName = $folder . '/' . uniqid() . '_' . time() . '_' . $i . '.' . $extension;
                        $destinationPath = storage_path('app/public/' . $newFileName);

                        // Crear directorio si no existe
                        $directory = dirname($destinationPath);
                        if (!is_dir($directory)) {
                            mkdir($directory, 0755, true);
                        }

                        // Mover el archivo
                        if (move_uploaded_file($tmpName, $destinationPath)) {
                            $imagePaths[] = $newFileName;
                        } else {
                            throw new \Exception("Error al subir el archivo {$fileName}.");
                        }
                    }
                }
            } elseif (isset($files[$fieldName]) && $files[$fieldName]['error'] === UPLOAD_ERR_OK) {
                // Un solo archivo
                $fileName = $files[$fieldName]['name'];
                $fileSize = $files[$fieldName]['size'];
                $tmpName = $files[$fieldName]['tmp_name'];
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Validar extensión
                if (!in_array($extension, $allowedExtensions)) {
                    throw new \Exception("El archivo {$fileName} debe ser una imagen (jpeg, jpg, png o gif).");
                }

                // Validar tamaño
                if ($fileSize > $maxSizeBytes) {
                    throw new \Exception("El archivo {$fileName} no debe exceder 2MB.");
                }

                // Generar nombre único
                $newFileName = $folder . '/' . uniqid() . '_' . time() . '.' . $extension;
                $destinationPath = storage_path('app/public/' . $newFileName);

                // Crear directorio si no existe
                $directory = dirname($destinationPath);
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Mover el archivo
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    $imagePaths[] = $newFileName;
                } else {
                    throw new \Exception("Error al subir el archivo {$fileName}.");
                }
            }

            return $imagePaths;
        };

        try {
            // Handle initial evidence images
            if (isset($_FILES['initial_evidence_images'])) {
                $hasFiles = false;
                if (is_array($_FILES['initial_evidence_images']['error'])) {
                    foreach ($_FILES['initial_evidence_images']['error'] as $error) {
                        if ($error !== UPLOAD_ERR_NO_FILE) {
                            $hasFiles = true;
                            break;
                        }
                    }
                } else {
                    $hasFiles = $_FILES['initial_evidence_images']['error'] !== UPLOAD_ERR_NO_FILE;
                }

                if ($hasFiles) {
                    $initialEvidenceImagePaths = $processImages($_FILES, 'initial_evidence_images', 'tasks-evidence');
                    if (!empty($initialEvidenceImagePaths)) {
                        $updateData['initial_evidence_images'] = array_merge((array) $task->initial_evidence_images, $initialEvidenceImagePaths);
                    }
                }
            }

            // Handle final evidence images
            if (isset($_FILES['final_evidence_images'])) {
                $hasFiles = false;
                if (is_array($_FILES['final_evidence_images']['error'])) {
                    foreach ($_FILES['final_evidence_images']['error'] as $error) {
                        if ($error !== UPLOAD_ERR_NO_FILE) {
                            $hasFiles = true;
                            break;
                        }
                    }
                } else {
                    $hasFiles = $_FILES['final_evidence_images']['error'] !== UPLOAD_ERR_NO_FILE;
                }

                if ($hasFiles) {
                    $finalEvidenceImagePaths = $processImages($_FILES, 'final_evidence_images', 'tasks-evidence');
                    if (!empty($finalEvidenceImagePaths)) {
                        $updateData['final_evidence_images'] = array_merge((array) $task->final_evidence_images, $finalEvidenceImagePaths);
                    }
                }
            }

            // Handle reference images
            if (isset($_FILES['reference_images'])) {
                $hasFiles = false;
                if (is_array($_FILES['reference_images']['error'])) {
                    foreach ($_FILES['reference_images']['error'] as $error) {
                        if ($error !== UPLOAD_ERR_NO_FILE) {
                            $hasFiles = true;
                            break;
                        }
                    }
                } else {
                    $hasFiles = $_FILES['reference_images']['error'] !== UPLOAD_ERR_NO_FILE;
                }

                if ($hasFiles) {
                    $referenceImagePaths = $processImages($_FILES, 'reference_images', 'tasks-reference');
                    if (!empty($referenceImagePaths)) {
                        $updateData['reference_images'] = array_merge((array) $task->reference_images, $referenceImagePaths);
                    }
                }
            }

            $task->update($updateData);

            // Lógica para cambiar el estado a "incompleta" si la fecha límite ha pasado
            if ($task->deadline_at && $task->deadline_at < now() && $task->status !== 'finalizada' && $task->status !== 'cancelada') {
                $task->status = 'incompleta';
                $task->save();
            }

            return redirect()->route('admin.tasks.index')->with('success', 'Tarea actualizada exitosamente.');
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
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Review the specified task and update its status.
     */
    public function reviewTask(Request $request, string $id)
    {
        $task = Task::with('incident')->findOrFail($id);

        $request->validate([
            'action' => ['required', 'string', 'in:approve,reject,delay'],
        ]);

        switch ($request->action) {
            case 'approve':
                $task->status = 'finalizada';

                // Si esta tarea está vinculada a un incidente, actualizar el incidente a "resuelto"
                if ($task->incident_id && $task->incident) {
                    $task->incident->update([
                        'status' => 'resuelto',
                        'resolved_at' => now(),
                        'final_evidence_images' => $task->final_evidence_images,
                        'resolution_description' => $task->final_description,
                    ]);
                }
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

    /**
     * Export tasks to PDF for a specific month
     */
    public function exportPDF(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
        ]);

        $month = $request->input('month');
        $year = $request->input('year');

        // Obtener el nombre del mes en español
        $monthNames = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
        $monthName = $monthNames[$month];

        // Filtrar tareas finalizadas en el mes especificado
        $tasks = Task::with(['assignedTo', 'createdBy'])
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', $month)
            ->where('status', 'finalizada')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Estadísticas del mes
        $totalTasks = $tasks->count();
        $tasksByPriority = [
            'alta' => $tasks->where('priority', 'alta')->count(),
            'media' => $tasks->where('priority', 'media')->count(),
            'baja' => $tasks->where('priority', 'baja')->count(),
        ];

        // Calcular tiempo promedio de finalización
        $avgCompletionDays = 0;
        if ($totalTasks > 0) {
            $totalDays = 0;
            foreach ($tasks as $task) {
                if ($task->created_at && $task->updated_at) {
                    $totalDays += $task->created_at->diffInDays($task->updated_at);
                }
            }
            $avgCompletionDays = round($totalDays / $totalTasks, 1);
        }

        // Tareas por trabajador
        $tasksByWorker = $tasks->groupBy('assigned_to')->map(function ($workerTasks) {
            return [
                'worker' => $workerTasks->first()->assignedTo,
                'count' => $workerTasks->count(),
            ];
        })->sortByDesc('count')->take(5);

        $data = [
            'month' => $monthName,
            'year' => $year,
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'tasksByPriority' => $tasksByPriority,
            'avgCompletionDays' => $avgCompletionDays,
            'tasksByWorker' => $tasksByWorker,
            'generatedDate' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('admin.tasks.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->download("reporte-tareas-{$monthName}-{$year}.pdf");
    }
}
