<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\CursosDelPanel;
use App\Models\Leccion;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

// Gráfica de línea: lecciones completadas por día en las últimas 2 semanas
class ActividadReciente extends ChartWidget
{
    use CursosDelPanel;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Lecciones completadas (últimos 14 días)';

    protected ?string $maxHeight = '260px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $idsLecciones = Leccion::whereHas('modulo', fn ($q) => $q->whereIn('curso_id', $this->cursosVisibles()->select('id')))->pluck('id');

        // Se agrupa por día en PHP para que funcione igual en MySQL y SQLite
        $porDia = DB::table('progreso')
            ->whereIn('leccion_id', $idsLecciones)
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->pluck('created_at')
            ->countBy(fn ($fecha) => substr($fecha, 0, 10));

        $dias = collect(range(13, 0))->map(fn ($n) => now()->subDays($n));

        return [
            'labels' => $dias->map(fn ($d) => $d->format('d/m'))->all(),
            'datasets' => [[
                'label' => 'Lecciones completadas',
                'data' => $dias->map(fn ($d) => $porDia[$d->toDateString()] ?? 0)->all(),
                'borderColor' => '#db2777',
                'backgroundColor' => 'rgba(219, 39, 119, 0.15)',
                'fill' => true,
                'tension' => 0.35,
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
