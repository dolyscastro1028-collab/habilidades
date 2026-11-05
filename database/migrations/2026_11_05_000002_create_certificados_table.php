<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Certificado que recibe un estudiante al completar el 100 % de un curso
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->string('codigo', 20)->unique(); // código de verificación
            $table->unique(['estudiante_id', 'curso_id']); // un certificado por curso
            $table->timestamps(); // created_at = fecha de emisión
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
