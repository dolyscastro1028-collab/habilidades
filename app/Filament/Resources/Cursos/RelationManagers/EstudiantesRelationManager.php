<?php

namespace App\Filament\Resources\Cursos\RelationManagers;

use App\Models\Estudiante;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

// Admin y profesor: estudiantes inscritos en el curso y su avance
class EstudiantesRelationManager extends RelationManager
{
    protected static string $relationship = 'estudiantes';

    protected static ?string $title = 'Estudiantes inscritos y progreso';

    protected static ?string $modelLabel = 'estudiante';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        $porcentaje = fn (Estudiante $record) => $record->progresoEn($this->getOwnerRecord())['porcentaje'];

        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),

                TextColumn::make('identificacion')
                    ->label('Identificación'),

                TextColumn::make('inscrito_el')
                    ->label('Inscrito el')
                    ->state(fn (Estudiante $record) => $record->pivot?->created_at)
                    ->date('d/m/Y'),

                TextColumn::make('avance_lecciones')
                    ->label('Lecciones completadas')
                    ->state(function (Estudiante $record) {
                        $p = $record->progresoEn($this->getOwnerRecord());

                        return "{$p['completadas']} de {$p['total']}";
                    }),

                TextColumn::make('porcentaje')
                    ->label('Avance')
                    ->state(fn (Estudiante $record) => $porcentaje($record) . ' %')
                    ->badge()
                    ->color(fn (Estudiante $record) => match (true) {
                        $porcentaje($record) === 100 => 'success',
                        $porcentaje($record) > 0 => 'warning',
                        default => 'gray',
                    }),
            ]);
    }
}
