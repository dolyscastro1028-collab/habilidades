<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Video de muestra libre (CC0). Reemplazar por los videos reales de cada lección.
    private const VIDEO = 'https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4';

    public function run(): void
    {
        // ── Usuarios (contraseña de todos: password) ──────────────────────
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@plataforma.com',
            'role_id' => Role::idDe('admin'),
        ]);

        $profesor = User::factory()->create([
            'name' => 'Carlos Pérez',
            'email' => 'profesor@plataforma.com',
            'role_id' => Role::idDe('profesor'),
        ])->profesor()->create([
            'nombre' => 'Carlos Pérez',
            'identificacion' => '10203040',
            'edad' => 35,
            'materia' => 'Informática',
        ]);

        $estudiantes = collect([
            ['Laura Gómez', 'laura@plataforma.com', '1001001001', 16],
            ['Andrés Ruiz', 'andres@plataforma.com', '1001001002', 17],
            ['Sofía Torres', 'sofia@plataforma.com', '1001001003', 16],
        ])->map(fn ($e) => User::factory()->create([
            'name' => $e[0],
            'email' => $e[1],
            'role_id' => Role::idDe('estudiante'),
        ])->estudiante()->create([
            'nombre' => $e[0],
            'identificacion' => $e[2],
            'edad' => $e[3],
        ]));

        // ── Cursos → módulos → lecciones ─────────────────────────────────
        $cursos = [
            ['Excel básico', 'Ofimática', '20 horas', [
                'Fórmulas' => ['Introducción a las fórmulas', 'Funciones SUMA y PROMEDIO'],
                'Gráficos' => ['Crear un gráfico de barras', 'Personalizar gráficos'],
            ]],
            ['Programación con Python', 'Programación', '30 horas', [
                'Fundamentos' => ['Variables y tipos de datos', 'Entrada y salida'],
                'Estructuras de control' => ['Condicionales if/else', 'Ciclos for y while'],
            ]],
        ];

        foreach ($cursos as [$nombre, $materia, $duracion, $modulos]) {
            $curso = Curso::create([
                'nombre' => $nombre,
                'materia' => $materia, // temática del curso
                'duracion' => $duracion,
                'profesor_id' => $profesor->id,
            ]);

            $ordenModulo = 1;
            foreach ($modulos as $tituloModulo => $lecciones) {
                $modulo = $curso->modulos()->create(['titulo' => $tituloModulo, 'orden' => $ordenModulo++]);

                foreach ($lecciones as $i => $tituloLeccion) {
                    $modulo->lecciones()->create([
                        'titulo' => $tituloLeccion,
                        'contenido' => "<p>En esta lección aprenderás: {$tituloLeccion}.</p>",
                        'video_url' => self::VIDEO,
                        'orden' => $i + 1,
                    ]);
                }
            }
        }

        // ── Inscripciones y progreso de ejemplo ──────────────────────────
        [$excel, $python] = Curso::orderBy('id')->get();
        [$laura, $andres] = $estudiantes;

        $laura->cursos()->attach([$excel->id, $python->id]);
        $andres->cursos()->attach($excel->id);
        // Sofía queda sin inscripciones para mostrar la inscripción en vivo

        // Laura completó 2 de 4 lecciones de Excel (50 %)
        $laura->leccionesCompletadas()->attach($excel->lecciones()->orderBy('lecciones.id')->limit(2)->pluck('lecciones.id'));
    }
}
