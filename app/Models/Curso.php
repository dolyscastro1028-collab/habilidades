<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nombre',
        'duracion',
        'descripcion',
        'tematica_id',
        'profesor_id',
        'portada',
    ];

    public function tematica()
    {
        return $this->belongsTo(Tematica::class);
    }

    // ¿Este estudiante está inscrito en el curso?
    public function tieneInscrito(?Estudiante $estudiante): bool
    {
        if (! $estudiante) {
            return false;
        }

        return $this->relationLoaded('estudiantes')
            ? $this->estudiantes->contains('id', $estudiante->id)
            : $this->estudiantes()->whereKey($estudiante->id)->exists();
    }

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