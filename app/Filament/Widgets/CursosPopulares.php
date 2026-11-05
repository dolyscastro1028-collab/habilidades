<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\CursosDelPanel;
use App\Models\Curso;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

// Escritorio: cursos ordenados por número de inscritos (admin: todos; profesor: los suyos)
class CursosPopulares extends TableWidget
{
    use CursosDelPanel;

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Cursos más populares')
            ->query(fn () => $this->cursosVisibles()->with(['profesor.user', 'tematica'])->withCount(['estudiantes', 'lecciones'])->orderByDesc('estudiantes_count'))
            ->paginated([5])
            ->recordUrl(fn (Curso $record) => $this->urlEditarCurso($record))
            ->columns([
                TextColumn::make('nombre'),
                TextColumn::make('tematica.nombre')->label('Temática')->badge(),
                TextColumn::make('profesor.user.name')->label('Profesor'),
                TextColumn::make('lecciones_count')->label('Lecciones')->badge(),
                TextColumn::make('estudiantes_count')->label('Inscritos')->badge()->color('success'),
            ]);
    }
}
