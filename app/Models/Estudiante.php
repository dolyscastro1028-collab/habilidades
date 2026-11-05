<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'nombre',
        'identificacion',
        'edad',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'clases')->withTimestamps();
    }

    public function leccionesCompletadas()
    {
        return $this->belongsToMany(Leccion::class, 'progreso')->withTimestamps();
    }
}