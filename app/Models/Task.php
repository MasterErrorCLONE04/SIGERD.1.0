<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

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

    protected $casts = [
        'initial_evidence_images' => 'array',
        'final_evidence_images' => 'array',
        'reference_images' => 'array',
        'deadline_at' => 'datetime',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
