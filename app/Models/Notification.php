<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Notification: Gestiona los avisos y alertas internas para los usuarios del sistema.
 */
class Notification extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'link',
        'read',
    ];

    /**
     * Casting de atributos: Asegura que el estado de lectura se trate como booleano.
     */
    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * Relación: La notificación pertenece a un usuario específico.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Método Helper: Marca la notificación como leída de forma rápida.
     */
    public function markAsRead()
    {
        $this->update(['read' => true]);
    }
}

