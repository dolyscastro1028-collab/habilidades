<?php

namespace App\Filament\Widgets;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Leccion;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

// Inicio del admin: cifras generales de la plataforma
class ResumenPlataforma extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Avance promedio de todas las inscripciones
        // ponytail: recorre todas las inscripciones; calcular en SQL si son miles
        $avances = Estudiante::with('cursos')->get()
            ->flatMap(fn (Estudiante $e) => $e->cursos->map(fn (Curso $c) => $e->progresoEn($c)['porcentaje']));

        return [
            Stat::make('Cursos', Curso::count())
                ->description(Leccion::count() . ' lecciones en total')
                ->icon('heroicon-o-academic-cap'),

            Stat::make('Estudiantes', Estudiante::count())
                ->icon('heroicon-o-user-group'),

            Stat::make('Inscripciones', DB::table('clases')->count())
                ->icon('heroicon-o-clipboard-document-check'),

            Stat::make('Avance promedio', round($avances->avg() ?? 0) . ' %')
                ->description(DB::table('progreso')->count() . ' lecciones completadas')
                ->color('success')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
