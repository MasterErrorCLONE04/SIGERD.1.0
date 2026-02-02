<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class IncidentController extends Controller
{
    /**
     * List incidents reported by the authenticated user.
     */
    public function index(Request $request)
    {
        $incidents = Incident::where('reported_by', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($incidents);
    }

    /**
     * Store a newly created incident in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => ['required', Rule::in(['baja', 'media', 'alta', 'critica'])],
            'location' => 'required|string|max:255',
            'initial_evidence_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $initialEvidenceImagePaths = [];
        if ($request->hasFile('initial_evidence_images')) {
            foreach ($request->file('initial_evidence_images') as $image) {
                $path = $image->store('incident-evidence', 'public');
                $initialEvidenceImagePaths[] = $path;
            }
        }

        $incident = Incident::create([
            'title' => $request->title,
            'description' => $request->description,
            'severity' => $request->severity,
            'location' => $request->location,
            'status' => 'abierto',
            'reported_by' => $request->user()->id,
            'reported_at' => now(),
            'initial_evidence_images' => $initialEvidenceImagePaths, // Eloquent cast should handle array serialization
        ]);

        // Notify Admins
        $admins = User::where('role', 'administrador')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'incident_reported',
                'data' => [
                    'message' => 'Nuevo incidente reportado: ' . $incident->title,
                    'incident_id' => $incident->id,
                    'reported_by' => $request->user()->name,
                ],
                'is_read' => false,
            ]);
        }

        return response()->json([
            'message' => 'Incident reported successfully',
            'incident' => $incident,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $incident = Incident::where('id', $id)
            ->where('reported_by', auth()->id()) // Ensure reporting user owns it
            ->firstOrFail();

        return response()->json($incident);
    }
}
