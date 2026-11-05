<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $fillable = [
        'curso_id',
        'titulo',
        'descripcion',
        'enlace',
        'archivo',
        'orden',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}