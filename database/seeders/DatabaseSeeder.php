<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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
            'identificacion' => $e[2],
            'edad' => $e[3],
        ]));

        // ── Cursos → módulos → lecciones ─────────────────────────────────
        $cursos = [
            ['Excel básico', 'Ofimática', '20 horas', [
                'Fórmulas' => [
                    'Introducción a las fórmulas' => 'https://www.youtube.com/watch?v=9KiXJtMrmbc',
                    'Funciones SUMA y PROMEDIO' => 'https://www.youtube.com/watch?v=LW0B8hgreeo',
                ],
                'Gráficos' => [
                    'Crear un gráfico de barras' => 'https://www.youtube.com/watch?v=L5567d76dKk',
                    'Personalizar gráficos' => 'https://www.youtube.com/watch?v=ZN_IjSk0tw8',
                ],
            ]],
            ['Programación con Python', 'Programación', '30 horas', [
                'Fundamentos' => [
                    'Variables y tipos de datos' => 'https://www.youtube.com/watch?v=gF62RDGpW1k',
                    'Entrada y salida' => 'https://www.youtube.com/watch?v=EXno9AKikDo',
                ],
                'Estructuras de control' => [
                    'Condicionales if/else' => 'https://www.youtube.com/watch?v=iFBcCDDDsms',
                    'Ciclos for y while' => 'https://www.youtube.com/watch?v=PWocHp9ZpEw',
                ],
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

                $ordenLeccion = 1;
                foreach ($lecciones as $tituloLeccion => $video) {
                    $modulo->lecciones()->create([
                        'titulo' => $tituloLeccion,
                        'contenido' => "<p>En esta lección aprenderás: <strong>{$tituloLeccion}</strong>.</p>"
                            . '<p>Mira el video completo y luego marca la lección como completada.</p>',
                        'video_url' => $video,
                        'orden' => $ordenLeccion++,
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
