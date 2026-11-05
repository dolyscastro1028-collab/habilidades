<?php

namespace App\Filament\Estudiante\Widgets;

use App\Filament\Estudiante\Resources\Cursos\CursoResource;
use Filament\Widgets\Widget;

// Inicio del estudiante: sus cursos con progreso y botón para continuar
class MisCursosWidget extends Widget
{
    protected string $view = 'filament.estudiante.widgets.mis-cursos';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getViewData(): array
    {
        $estudiante = auth()->user()->estudiante;

        $cursos = $estudiante->cursos()->with(['profesor.user', 'tematica'])->get()->map(function ($curso) use ($estudiante) {
            $siguiente = $estudiante->siguienteLeccion($curso);

            return [
                'curso' => $curso,
                'progreso' => $estudiante->progresoEn($curso),
                'siguiente' => $siguiente,
                'url' => $siguiente
                    ? CursoResource::getUrl('leccion', ['record' => $curso, 'leccion' => $siguiente])
                    : CursoResource::getUrl('view', ['record' => $curso]),
            ];
        });

        return [
            'cursos' => $cursos,
            'catalogo' => CursoResource::getUrl(),
        ];
    }
}
