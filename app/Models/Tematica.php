<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    protected $fillable = ['nombre'];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
