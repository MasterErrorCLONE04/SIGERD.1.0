<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Incident::where('reported_by', Auth::id())->with('reportedBy');

        // Aplicar búsqueda si se proporciona
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Aplicar filtro de estado
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Ordenar por fecha de creación (más recientes primero)
        $incidents = $query->orderBy('created_at', 'desc')->get();

        return view('instructor.incidents.index', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instructor.incidents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'], // Descripción detallada ahora es obligatoria
            'location' => ['required', 'string', 'max:255'],
            'report_date' => ['required', 'date', 'before_or_equal:today'], // Fecha del reporte, obligatoria
        ]);

        // Validar manualmente las imágenes sin usar fileinfo
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB en bytes
        $initialEvidenceImagePaths = [];

        if (isset($_FILES['initial_evidence_images']) && $_FILES['initial_evidence_images']['error'][0] !== UPLOAD_ERR_NO_FILE) {
            $files = $_FILES['initial_evidence_images'];
            $fileCount = count($files['name']);

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

        // Crear notificaciones para todos los administradores
        $admins = \App\Models\User::where('role', 'administrador')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => 'incident_created',
                'title' => 'Nuevo Incidente Reportado',
                'message' => Auth::user()->name . ' ha reportado: ' . $request->title,
                'link' => route('admin.incidents.show', $incident->id),
            ]);
        }

        return redirect()->route('instructor.incidents.index')->with('success', 'Falla reportada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $incident = Incident::where('reported_by', Auth::id())->findOrFail($id);

        return view('instructor.incidents.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
