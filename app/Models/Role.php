<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['nombre'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function idDe(string $nombre): int
    {
        return static::where('nombre', $nombre)->value('id');
    }
}
