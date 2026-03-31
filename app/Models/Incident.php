<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Incident: Representa un reporte de daño inicial realizado por un Instructor.
 */
class Incident extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'report_date',
        'status',
        'reported_by',
        'initial_evidence_images',
        'resolved_at',
        'final_evidence_images',
        'resolution_description',
    ];

    /**
     * Casting de atributos: Manejo de fechas y almacenamiento de múltiples imágenes como arreglos.
     */
    protected $casts = [
        'initial_evidence_images' => 'array',
        'final_evidence_images' => 'array',
        'report_date' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones de Eloquent
    |--------------------------------------------------------------------------
    */

    // El instructor o usuario que reportó el daño
    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    // Un incidente puede dar lugar a una o varias tareas de reparación
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

