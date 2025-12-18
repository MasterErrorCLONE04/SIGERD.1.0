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
            $query->where(function($q) use ($search) {
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
        $tasks = $query->orderBy('deadline_at', 'asc')->get();

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

        $updateData = ['status' => $request->status];
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        $maxSizeBytes = 2048 * 1024; // 2MB en bytes

        // Función helper para validar y guardar imágenes
        $processImages = function($files, $fieldName) use ($allowedExtensions, $maxSizeBytes) {
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
                        $newFileName = 'tasks-evidence/' . uniqid() . '_' . time() . '_' . $i . '.' . $extension;
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
                $newFileName = 'tasks-evidence/' . uniqid() . '_' . time() . '.' . $extension;
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
            // Manejar la subida de imágenes de evidencia inicial
            if (isset($_FILES['initial_evidence_images'])) {
                $hasFiles = false;
                if (is_array($_FILES['initial_evidence_images']['error'])) {
                    // Múltiples archivos
                    foreach ($_FILES['initial_evidence_images']['error'] as $error) {
                        if ($error !== UPLOAD_ERR_NO_FILE) {
                            $hasFiles = true;
                            break;
                        }
                    }
                } else {
                    // Un solo archivo
                    $hasFiles = $_FILES['initial_evidence_images']['error'] !== UPLOAD_ERR_NO_FILE;
                }

                if ($hasFiles) {
                    $initialEvidenceImagePaths = $processImages($_FILES, 'initial_evidence_images');
                    if (!empty($initialEvidenceImagePaths)) {
                        $updateData['initial_evidence_images'] = array_merge((array)$task->initial_evidence_images, $initialEvidenceImagePaths);

                        // Si se sube evidencia inicial y la tarea está asignada, cambiar a "en progreso"
                        if ($task->status === 'asignado') {
                            $updateData['status'] = 'en progreso';
                        }
                    }
                }
            }
            
            // Manejar la subida de imágenes de evidencia final y descripción final
            if (isset($_FILES['final_evidence_images']) && $request->filled('final_description')) {
                $hasFiles = false;
                if (is_array($_FILES['final_evidence_images']['error'])) {
                    // Múltiples archivos
                    foreach ($_FILES['final_evidence_images']['error'] as $error) {
                        if ($error !== UPLOAD_ERR_NO_FILE) {
                            $hasFiles = true;
                            break;
                        }
                    }
                } else {
                    // Un solo archivo
                    $hasFiles = $_FILES['final_evidence_images']['error'] !== UPLOAD_ERR_NO_FILE;
                }

                if ($hasFiles) {
                    $finalEvidenceImagePaths = $processImages($_FILES, 'final_evidence_images');
                    if (!empty($finalEvidenceImagePaths)) {
                        $updateData['final_evidence_images'] = array_merge((array)$task->final_evidence_images, $finalEvidenceImagePaths);
                        $updateData['final_description'] = $request->final_description;

                        // Si se sube evidencia final y descripción, y la tarea está en progreso, cambiar a "realizada"
                        if ($task->status === 'en progreso') {
                            $updateData['status'] = 'realizada';
                        }
                    }
                }
            }

            $task->update($updateData);

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
