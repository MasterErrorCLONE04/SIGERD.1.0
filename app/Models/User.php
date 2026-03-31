<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo User: Gestiona la autenticación, perfiles y roles de los usuarios del sistema.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente (Mass Assignment).
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
    ];

    /**
     * Atributos dinámicos (Accessors) que se añaden a las respuestas JSON.
     * @var array
     */
    protected $appends = ['profile_photo_url', 'initials'];

    /**
     * Accessor: Genera la URL completa de la foto de perfil o un avatar por defecto.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/' . $this->profile_photo))) {
            return asset('storage/' . $this->profile_photo);
        }
        
        return $this->generateAvatarUrl();
    }

    /**
     * Accessor: Obtiene las iniciales del nombre para el avatar fallback.
     */
    public function getInitialsAttribute()
    {
        $names = explode(' ', trim($this->name));
        $initials = '';
        
        foreach ($names as $name) {
            if (!empty($name)) {
                $initials .= strtoupper(substr($name, 0, 1));
            }
        }
        
        return substr($initials, 0, 2) ?: 'U';
    }

    /**
     * Genera una URL de avatar externa (UI Avatars) basada en las iniciales.
     */
    private function generateAvatarUrl()
    {
        $name = urlencode($this->name);
        $initials = urlencode($this->initials);
        
        return "https://ui-avatars.com/api/?name={$initials}&color=ffffff&background=6366f1&size=200&font-size=0.5";
    }

    /**
     * Verifica físicamente si el usuario tiene una foto en el servidor.
     */
    public function hasProfilePhoto()
    {
        return !empty($this->profile_photo) && file_exists(storage_path('app/public/' . $this->profile_photo));
    }

    /**
     * Elimina el archivo de la foto de perfil y actualiza la base de datos.
     */
    public function deleteProfilePhoto()
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/' . $this->profile_photo))) {
            unlink(storage_path('app/public/' . $this->profile_photo));
            $this->update(['profile_photo' => null]);
        }
    }

    /**
     * Atributos ocultos en serialización por seguridad (Contraseñas, tokens).
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting de tipos para atributos específicos.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Validaciones de Roles (Control de Acceso)
    |--------------------------------------------------------------------------
    */

    public function isAdmin()
    {
        return $this->role === 'administrador';
    }

    public function isTrabajador()
    {
        return $this->role === 'trabajador';
    }

    public function isInstructor()
    {
        return $this->role === 'instructor';
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones de Eloquent
    |--------------------------------------------------------------------------
    */

    // Tareas que le han sido asignadas para ejecutar
    public function assignedTasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'assigned_to');
    }

    // Tareas que este usuario (usualmente Admin) ha creado
    public function createdTasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'created_by');
    }

    // Reportes de daño realizados (Instructores/Manual)
    public function reportedIncidents()
    {
        return $this->hasMany(\App\Models\Incident::class, 'reported_by');
    }

    // Alertas y avisos del sistema dirigidos a este usuario
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

}