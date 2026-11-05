<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'identificacion',
        'edad',
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

    public function certificados()
    {
        return $this->hasMany(Certificado::class);
    }

    public function terminoCurso(Curso $curso): bool
    {
        return $this->progresoEn($curso)['porcentaje'] === 100;
    }

    // Primera lección del curso (en orden de módulo y lección) que aún no ha completado
    public function siguienteLeccion(Curso $curso): ?Leccion
    {
        $completadas = $this->leccionesCompletadas()->pluck('lecciones.id');

        return $curso->modulos()->with('lecciones')->get()
            ->flatMap->lecciones
            ->first(fn (Leccion $leccion) => ! $completadas->contains($leccion->id));
    }

    // Texto para mostrar: "2 de 4 lecciones (50 %)"
    public function progresoTexto(Curso $curso): string
    {
        $p = $this->progresoEn($curso);

        return "{$p['completadas']} de {$p['total']} lecciones ({$p['porcentaje']} %)";
    }
}