<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\CursosDelPanel;
use App\Models\Estudiante;
use App\Models\Leccion;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

// Escritorio: cifras generales (admin) o de mis cursos (profesor)
class ResumenPlataforma extends StatsOverviewWidget
{
    use CursosDelPanel;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $cursos = $this->cursosVisibles()->with('estudiantes')->get();
        $idsCursos = $cursos->pluck('id');
        $idsLecciones = Leccion::whereHas('modulo', fn ($q) => $q->whereIn('curso_id', $idsCursos))->pluck('id');

        // Avance promedio de todas las inscripciones de esos cursos
        // ponytail: recorre las inscripciones una por una; calcular en SQL si son miles
        $avances = $cursos->flatMap(fn ($curso) => $curso->estudiantes->map(fn (Estudiante $e) => $e->progresoEn($curso)['porcentaje']));

        $estudiantes = $this->esProfesor()
            ? $cursos->flatMap->estudiantes->unique('id')->count() // inscritos en mis cursos
            : Estudiante::count();                                  // todos los registrados

        return [
            Stat::make($this->esProfesor() ? 'Mis cursos' : 'Cursos', $cursos->count())
                ->description($idsLecciones->count() . ' lecciones en total')
                ->icon('heroicon-o-academic-cap'),

            Stat::make($this->esProfesor() ? 'Mis estudiantes' : 'Estudiantes', $estudiantes)
                ->icon('heroicon-o-user-group'),

            Stat::make('Inscripciones', DB::table('clases')->whereIn('curso_id', $idsCursos)->count())
                ->icon('heroicon-o-clipboard-document-check'),

            Stat::make('Avance promedio', round($avances->avg() ?? 0) . ' %')
                ->description(DB::table('progreso')->whereIn('leccion_id', $idsLecciones)->count() . ' lecciones completadas')
                ->color('success')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
