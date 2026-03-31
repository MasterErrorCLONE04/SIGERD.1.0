<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Task: Representa una orden de trabajo asignada a un operario para resolver un daño.
 */
class Task extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'deadline_at',
        'location',
        'status',
        'assigned_to',
        'created_by',
        'incident_id',
        'initial_evidence_images',
        'final_evidence_images',
        'final_description',
        'reference_images',
    ];

    /**
     * Casting de atributos: Convierte automáticamente formatos JSON de la DB en Arreglos de PHP.
     */
    protected $casts = [
        'initial_evidence_images' => 'array',
        'final_evidence_images' => 'array',
        'reference_images' => 'array',
        'deadline_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones de Eloquent
    |--------------------------------------------------------------------------
    */

    // El trabajador responsable de ejecutar la tarea
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // El administrador que generó la orden de trabajo
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // El incidente o reporte de daño original que dio origen a esta tarea
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}

