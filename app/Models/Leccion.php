<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Leccion extends Model
{
    protected $table = 'lecciones';

    protected $fillable = ['modulo_id', 'titulo', 'contenido', 'video_url', 'video_archivo', 'material', 'material_nombre', 'orden'];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    // ID de YouTube si el enlace es de YouTube (watch, youtu.be, embed, shorts)
    public function youtubeId(): ?string
    {
        preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([\w-]{11})~', (string) $this->video_url, $m);

        return $m[1] ?? null;
    }

    // URL reproducible en <video>: archivo subido o enlace directo (.mp4, .webm)
    public function videoSrc(): ?string
    {
        return $this->video_archivo ? Storage::disk('public')->url($this->video_archivo) : $this->video_url;
    }

    public function materialUrl(): ?string
    {
        return $this->material ? Storage::disk('public')->url($this->material) : null;
    }

    // Estudiantes que ya completaron esta lección
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'progreso')->withTimestamps();
    }
}
