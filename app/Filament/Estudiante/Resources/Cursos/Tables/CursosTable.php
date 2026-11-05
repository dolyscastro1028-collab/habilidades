<?php

namespace App\Filament\Estudiante\Resources\Cursos\Tables;

use App\Filament\Estudiante\Resources\Cursos\CursoResource;
use App\Models\Curso;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class CursosTable
{
    public static function configure(Table $table): Table
    {
        // ¿El estudiante logueado ya está inscrito en este curso?
        // (usa la relación ya cargada en la consulta del catálogo)
        $inscrito = fn (Curso $record): bool => $record->estudiantes->contains('id', auth()->user()->estudiante?->id);

        return $table
            // Catálogo en tarjetas: una tarjeta por curso, 1 / 2 / 3 por fila según la pantalla
            ->modifyQueryUsing(fn ($query) => $query
                ->with(['profesor.user', 'estudiantes'])
                ->withCount(['modulos', 'lecciones']))
            ->contentGrid(['md' => 2, 'xl' => 3])
            ->searchable(['nombre', 'materia'])
            ->searchPlaceholder('Buscar por nombre o temática')
            ->paginated([12, 24])
            ->columns([
                ViewColumn::make('tarjeta')
                    ->view('filament.estudiante.tarjeta-curso'),
            ])
            // Clic en la tarjeta: entra al curso si está inscrito
            ->recordUrl(fn (Curso $record) => $inscrito($record) ? CursoResource::getUrl('view', ['record' => $record]) : null)
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