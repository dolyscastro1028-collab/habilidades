<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\CursosDelPanel;
use Filament\Widgets\ChartWidget;

// Gráfica de barras: cuántos estudiantes hay inscritos en cada curso
class InscripcionesPorCurso extends ChartWidget
{
    use CursosDelPanel;

    protected static ?int $sort = 2;

    protected ?string $heading = 'Inscritos por curso';

    protected ?string $maxHeight = '260px';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $cursos = $this->cursosVisibles()->withCount('estudiantes')->orderByDesc('estudiantes_count')->limit(8)->get();

        return [
            'labels' => $cursos->pluck('nombre')->all(),
            'datasets' => [[
                'label' => 'Inscritos',
                'data' => $cursos->pluck('estudiantes_count')->all(),
                'backgroundColor' => ['#db2777', '#7c3aed', '#c026d3', '#9333ea', '#ec4899', '#8b5cf6', '#d946ef', '#a855f7'],
                'borderRadius' => 6,
            ]],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => ['legend' => ['display' => false]],
            'scales' => ['y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]]],
        ];
    }
}
