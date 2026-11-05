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
        'publicado',
    ];

    protected function casts(): array
    {
        return ['publicado' => 'boolean'];
    }

    // Solo los cursos publicados aparecen en el catálogo y aceptan inscripciones
    public function scopePublicados($query)
    {
        return $query->where('publicado', true);
    }

    public function puedePublicarse(): bool
    {
        return $this->lecciones()->exists();
    }

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