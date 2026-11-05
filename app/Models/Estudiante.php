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

    // Avance en un curso: lecciones completadas / total de lecciones del curso
    // ponytail: 2 consultas por fila; precalcular con withCount si las tablas crecen mucho
    public function progresoEn(Curso $curso): array
    {
        $ids = $curso->lecciones()->pluck('lecciones.id');
        $completadas = $ids->isEmpty() ? 0 : $this->leccionesCompletadas()->whereIn('lecciones.id', $ids)->count();
        $total = $ids->count();

        return [
            'completadas' => $completadas,
            'total' => $total,
            'porcentaje' => $total ? (int) round($completadas * 100 / $total) : 0,
        ];
    }

    // Texto para mostrar: "2 de 4 lecciones (50 %)"
    public function progresoTexto(Curso $curso): string
    {
        $p = $this->progresoEn($curso);

        return "{$p['completadas']} de {$p['total']} lecciones ({$p['porcentaje']} %)";
    }
}