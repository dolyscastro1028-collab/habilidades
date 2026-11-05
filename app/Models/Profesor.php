<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';

    protected $fillable = [
        'identificacion',
        'edad',
        'materia',
        'user_id',
    ];

    // El nombre vive en users: aquí solo se lee (tabla normalizada)
    protected function nombre(): Attribute
    {
        return Attribute::get(fn () => $this->user?->name);
    }

    // Al borrar el registro también se borra su cuenta de acceso
    protected static function booted(): void
    {
        static::deleted(fn (self $registro) => $registro->user?->delete());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}