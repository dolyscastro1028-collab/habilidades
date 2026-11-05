<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    protected $table = 'lecciones';

    protected $fillable = ['modulo_id', 'titulo', 'contenido', 'video_url', 'video_archivo', 'orden'];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    // Estudiantes que ya completaron esta lección
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'progreso')->withTimestamps();
    }
}
