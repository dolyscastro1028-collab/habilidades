<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Curso 1 ── N Módulos
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->string('titulo');
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        // Módulo 1 ── N Lecciones
        Schema::create('lecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modulo_id')->constrained('modulos')->cascadeOnDelete();
            $table->string('titulo');
            $table->longText('contenido')->nullable();
            $table->string('video_url')->nullable();     // enlace (YouTube, mp4...)
            $table->string('video_archivo')->nullable(); // archivo subido
            $table->string('material')->nullable();        // material de apoyo descargable (PDF, Word...)
            $table->string('material_nombre')->nullable(); // nombre original del archivo
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        // Estudiante N ── N Lecciones completadas (created_at = fecha en que la completó)
        Schema::create('progreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->cascadeOnDelete();
            $table->foreignId('leccion_id')->constrained('lecciones')->cascadeOnDelete();
            $table->unique(['estudiante_id', 'leccion_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progreso');
        Schema::dropIfExists('lecciones');
        Schema::dropIfExists('modulos');
    }
};
