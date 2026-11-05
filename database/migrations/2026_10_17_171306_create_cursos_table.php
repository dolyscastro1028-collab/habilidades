<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('duracion');
            $table->text('descripcion')->nullable(); // qué va a aprender el estudiante
            $table->foreignId('tematica_id')->constrained('tematicas')->restrictOnDelete();
            $table->string('portada')->nullable(); // imagen del curso (opcional)
            $table->foreignId('profesor_id')->constrained('profesores')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
