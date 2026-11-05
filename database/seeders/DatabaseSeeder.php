<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Role;
use App\Models\Tematica;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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

        // ── Temáticas ────────────────────────────────────────────────────
        $tematicas = collect(['Ofimática', 'Programación', 'Diseño gráfico', 'Idiomas'])
            ->mapWithKeys(fn ($nombre) => [$nombre => Tematica::create(['nombre' => $nombre])->id]);

        // ── Cursos → módulos → lecciones ─────────────────────────────────
        $cursos = [
            ['Excel básico', 'Ofimática', '20 horas',
                'Aprende a usar Excel desde cero: escribe fórmulas, usa funciones como SUMA y PROMEDIO y presenta tus datos con gráficos claros.', [
                'Fórmulas' => [
                    'Introducción a las fórmulas' => 'https://www.youtube.com/watch?v=9KiXJtMrmbc',
                    'Funciones SUMA y PROMEDIO' => 'https://www.youtube.com/watch?v=LW0B8hgreeo',
                ],
                'Gráficos' => [
                    'Crear un gráfico de barras' => 'https://www.youtube.com/watch?v=L5567d76dKk',
                    'Personalizar gráficos' => 'https://www.youtube.com/watch?v=ZN_IjSk0tw8',
                ],
            ]],
            ['Programación con Python', 'Programación', '30 horas',
                'Da tus primeros pasos en programación con Python: variables, entrada y salida de datos, condicionales y ciclos con ejemplos prácticos.', [
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

        foreach ($cursos as [$nombre, $tematica, $duracion, $descripcion, $modulos]) {
            $curso = Curso::create([
                'nombre' => $nombre,
                'tematica_id' => $tematicas[$tematica],
                'publicado' => true,
                'descripcion' => $descripcion,
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

        // Curso en borrador: aún no tiene lecciones, así que no se puede publicar
        // y los estudiantes no lo ven en el catálogo
        Curso::create([
            'nombre' => 'Diseño con Canva',
            'tematica_id' => $tematicas['Diseño gráfico'],
            'duracion' => '12 horas',
            'descripcion' => 'Crea presentaciones, afiches y publicaciones para redes sociales con Canva.',
            'profesor_id' => $profesor->id,
            'publicado' => false,
        ])->modulos()->create(['titulo' => 'Primeros pasos', 'orden' => 1]);

        // Material de apoyo de ejemplo en la primera lección de Excel
        Storage::disk('public')->put('materiales/guia-formulas-excel.pdf', file_get_contents(database_path('seeders/archivos/guia-formulas-excel.pdf')));
        Curso::where('nombre', 'Excel básico')->first()->lecciones()->orderBy('lecciones.id')->first()->update([
            'material' => 'materiales/guia-formulas-excel.pdf',
            'material_nombre' => 'Guía de fórmulas básicas de Excel.pdf',
        ]);

        // ── Inscripciones y progreso de ejemplo ──────────────────────────
        [$excel, $python] = Curso::orderBy('id')->take(2)->get();
        [$laura, $andres] = $estudiantes;

        $laura->cursos()->attach([$excel->id, $python->id]);
        $andres->cursos()->attach($excel->id);
        // Sofía queda sin inscripciones para mostrar la inscripción en vivo

        // Laura completó 2 de 4 lecciones de Excel (50 %), hace 5 y hace 2 días
        $excel->lecciones()->orderBy('lecciones.id')->limit(2)->pluck('lecciones.id')
            ->each(fn ($id, $i) => $laura->leccionesCompletadas()->attach($id, [
                'created_at' => now()->subDays([5, 2][$i]),
                'updated_at' => now()->subDays([5, 2][$i]),
            ]));
    }
}
