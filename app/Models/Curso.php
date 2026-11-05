<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nombre',
        'duracion',
        'materia',
        'profesor_id',
        'portada',
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'clases')->withTimestamps();
    }

    public function modulos()
    {
        return $this->hasMany(Modulo::class)->orderBy('orden');
    }

    public function lecciones()
    {
        return $this->hasManyThrough(Leccion::class, Modulo::class);
    }
}