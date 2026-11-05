<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Cursos\CursoResource;
use App\Models\Curso;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

// Inicio del admin: cursos ordenados por número de inscritos
class CursosPopulares extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Cursos más populares')
            ->query(fn () => Curso::query()->with('profesor.user')->withCount(['estudiantes', 'lecciones'])->orderByDesc('estudiantes_count'))
            ->paginated([5])
            ->recordUrl(fn (Curso $record) => CursoResource::getUrl('edit', ['record' => $record]))
            ->columns([
                TextColumn::make('nombre'),
                TextColumn::make('materia')->label('Temática'),
                TextColumn::make('profesor.user.name')->label('Profesor'),
                TextColumn::make('lecciones_count')->label('Lecciones')->badge(),
                TextColumn::make('estudiantes_count')->label('Inscritos')->badge()->color('success'),
            ]);
    }
}
