<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Cada usuario solo entra al panel que coincide con su rol
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role?->nombre === $panel->getId();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class);
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }
}