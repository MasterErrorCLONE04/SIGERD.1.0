<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['profile_photo_url', 'initials'];

    /**
     * Get the user's profile photo URL.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/' . $this->profile_photo))) {
            return asset('storage/' . $this->profile_photo);
        }
        
        // Retornar una imagen por defecto si no tiene foto
        return $this->generateAvatarUrl();
    }

    /**
     * Get the user's initials for avatar fallback.
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
     * Generate a default avatar URL using a service like UI Avatars
     */
    private function generateAvatarUrl()
    {
        $name = urlencode($this->name);
        $initials = urlencode($this->initials);
        
        // Usar UI Avatars como servicio de avatares por defecto
        return "https://ui-avatars.com/api/?name={$initials}&color=ffffff&background=6366f1&size=200&font-size=0.5";
    }

    /**
     * Check if user has a profile photo
     */
    public function hasProfilePhoto()
    {
        return !empty($this->profile_photo) && file_exists(storage_path('app/public/' . $this->profile_photo));
    }

    /**
     * Delete the user's profile photo
     */
    public function deleteProfilePhoto()
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/' . $this->profile_photo))) {
            unlink(storage_path('app/public/' . $this->profile_photo));
            $this->update(['profile_photo' => null]);
        }
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    // Tareas que tiene asignadas este usuario
    public function assignedTasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'assigned_to');
    }

    // Tareas que este usuario creó
    public function createdTasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'created_by');
    }

    // Incidentes que este usuario reportó
    public function reportedIncidents()
    {
        return $this->hasMany(\App\Models\Incident::class, 'reported_by');
    }

    // Notificaciones del usuario
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

}