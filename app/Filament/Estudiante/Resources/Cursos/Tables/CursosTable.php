<?php

namespace App\Filament\Estudiante\Resources\Cursos\Tables;

use App\Models\Curso;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CursosTable
{
    public static function configure(Table $table): Table
    {
        // ¿El estudiante logueado ya está inscrito en este curso?
        $inscrito = fn (Curso $record): bool => $record->estudiantes()
            ->whereKey(auth()->user()->estudiante?->id)
            ->exists();

        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('materia')
                    ->label('Temática')
                    ->searchable(),

                TextColumn::make('duracion')
                    ->label('Duración'),

                TextColumn::make('profesor.nombre')
                    ->label('Profesor'),

                TextColumn::make('lecciones_count')
                    ->counts('lecciones')
                    ->label('Lecciones')
                    ->badge(),

                TextColumn::make('progreso')
                    ->label('Mi progreso')
                    ->state(fn (Curso $record) => $inscrito($record)
                        ? auth()->user()->estudiante->progresoEn($record)['porcentaje'] . ' %'
                        : null)
                    ->placeholder('—')
                    ->badge()
                    ->color('success'),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->state(fn (Curso $record) => $inscrito($record) ? 'Inscrito' : 'Disponible')
                    ->badge()
                    ->color(fn (string $state) => $state === 'Inscrito' ? 'success' : 'gray'),
            ])
            ->recordActions([
                // Solo aparece si está inscrito (lo controla canView)
                ViewAction::make()
                    ->label('Ver contenido')
                    ->icon('heroicon-o-book-open'),

                Action::make('inscribirse')
                    ->label('Inscribirme')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('¿Inscribirte en este curso?')
                    ->visible(fn (Curso $record) => ! $inscrito($record))
                    ->action(function (Curso $record) {
                        $record->estudiantes()->attach(auth()->user()->estudiante->id);

                        Notification::make()
                            ->title('Te inscribiste en ' . $record->nombre)
                            ->success()
                            ->send();
                    }),

                Action::make('retirarse')
                    ->label('Retirarme')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('¿Retirarte de este curso?')
                    ->visible(fn (Curso $record) => $inscrito($record))
                    ->action(function (Curso $record) {
                        $record->estudiantes()->detach(auth()->user()->estudiante->id);

                        Notification::make()
                            ->title('Te retiraste de ' . $record->nombre)
                            ->warning()
                            ->send();
                    }),
            ]);
    }
}