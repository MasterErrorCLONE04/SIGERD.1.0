<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

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

    protected $casts = [
        'initial_evidence_images' => 'array',
        'final_evidence_images' => 'array',
        'report_date' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
