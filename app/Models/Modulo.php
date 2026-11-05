<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable = ['curso_id', 'titulo', 'orden'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function lecciones()
    {
        return $this->hasMany(Leccion::class)->orderBy('orden');
    }
}
