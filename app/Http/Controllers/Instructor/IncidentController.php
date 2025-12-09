<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = Incident::where('reported_by', Auth::id())->with('reportedBy')->get();

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
            'initial_evidence_images' => ['required', 'array', 'min:1'], // Al menos una imagen es obligatoria
            'initial_evidence_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validar cada imagen
            'report_date' => ['required', 'date', 'before_or_equal:today'], // Fecha del reporte, obligatoria
        ]);

        $initialEvidenceImagePaths = [];
        if ($request->hasFile('initial_evidence_images')) {
            foreach ($request->file('initial_evidence_images') as $image) {
                $initialEvidenceImagePaths[] = $image->store('incident-evidence', 'public');
            }
        }

        Incident::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'report_date' => $request->report_date,
            'status' => 'pendiente de revisión',
            'reported_by' => Auth::id(),
            'initial_evidence_images' => $initialEvidenceImagePaths,
        ]);

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
