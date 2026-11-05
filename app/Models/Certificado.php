<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificado extends Model
{
    protected $fillable = ['estudiante_id', 'curso_id', 'codigo'];

    // El código se genera solo al crear el certificado, ej: K7QM-2XPA-9D
    protected static function booted(): void
    {
        static::creating(function (self $certificado) {
            $certificado->codigo ??= Str::upper(Str::random(4) . '-' . Str::random(4) . '-' . Str::random(2));
        });
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
