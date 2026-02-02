<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * List tasks assigned to the authenticated user (Worker).
     */
    public function index(Request $request)
    {
        $tasks = Task::where('assigned_to', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($tasks);
    }

    /**
     * Display the specified task.
     */
    public function show($id)
    {
        $task = Task::where('id', $id)
            ->where('assigned_to', auth()->id()) // Ensure worker owns it
            ->firstOrFail();

        return response()->json($task);
    }

    /**
     * Update the specified task status and add resolution details.
     */
    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)
            ->where('assigned_to', auth()->id())
            ->firstOrFail();

        $request->validate([
            'status' => ['required', Rule::in(['pendiente', 'en_progreso', 'completada', 'cancelada'])],
            'resolution_description' => 'nullable|string',
            'final_evidence_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $finalEvidenceImagePaths = $task->final_evidence_images ?? [];
        if ($request->hasFile('final_evidence_images')) {
            foreach ($request->file('final_evidence_images') as $image) {
                $path = $image->store('task-evidence', 'public');
                $finalEvidenceImagePaths[] = $path;
            }
        }

        $task->update([
            'status' => $request->status,
            'resolution_description' => $request->resolution_description ?? $task->resolution_description,
            'final_evidence_images' => $finalEvidenceImagePaths,
            'completed_at' => $request->status === 'completada' ? now() : $task->completed_at,
        ]);

        // Notify Admin if task is completed
        if ($request->status === 'completada') {
            $createdByUser = User::find($task->created_by);
            if ($createdByUser) {
                Notification::create([
                    'user_id' => $createdByUser->id, // Validate who created it? Or just generic admins?
                    'type' => 'task_completed',
                    'data' => [
                        'message' => 'Tarea completada: ' . $task->title,
                        'task_id' => $task->id,
                        'completed_by' => $request->user()->name,
                    ],
                    'is_read' => false,
                ]);
            }
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }
}
