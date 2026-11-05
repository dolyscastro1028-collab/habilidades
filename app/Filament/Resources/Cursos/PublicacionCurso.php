<?php

namespace App\Filament\Resources\Cursos;

use App\Models\Curso;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;

// Publicar / pasar a borrador. Lo usan los paneles admin y profesor.
// Borrador: los estudiantes no lo ven en el catálogo ni pueden inscribirse.
class PublicacionCurso
{
    public const MENSAJE_SIN_LECCIONES = 'Agrega al menos un módulo con una lección antes de publicar el curso.';

    // Interruptor en el formulario del curso
    public static function interruptor(): Toggle
    {
        return Toggle::make('publicado')
            ->label('Publicado')
            ->helperText('Si está apagado, el curso queda en borrador: los estudiantes no lo ven ni pueden inscribirse.')
            ->onColor('success')
            ->rule(fn (?Curso $record) => function (string $attribute, $value, Closure $fail) use ($record) {
                if ($value && ! $record?->puedePublicarse()) {
                    $fail(self::MENSAJE_SIN_LECCIONES);
                }
            })
            ->columnSpanFull();
    }

    // Columna "Estado" en la tabla de cursos
    public static function columna(): TextColumn
    {
        return TextColumn::make('publicado')
            ->label('Estado')
            ->badge()
            ->formatStateUsing(fn (bool $state) => $state ? 'Publicado' : 'Borrador')
            ->color(fn (bool $state) => $state ? 'success' : 'gray')
            ->icon(fn (bool $state) => $state ? 'heroicon-o-globe-alt' : 'heroicon-o-pencil-square');
    }

    public static function filtro(): TernaryFilter
    {
        return TernaryFilter::make('publicado')
            ->label('Estado')
            ->trueLabel('Publicados')
            ->falseLabel('Borradores');
    }

    // Botones "Publicar" y "Pasar a borrador" en cada fila
    public static function acciones(): array
    {
        return [
            Action::make('publicar')
                ->label('Publicar')
                ->icon('heroicon-o-globe-alt')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('¿Publicar este curso?')
                ->modalDescription('Aparecerá en el catálogo y los estudiantes podrán inscribirse.')
                ->visible(fn (Curso $record) => ! $record->publicado)
                ->action(function (Curso $record) {
                    if (! $record->puedePublicarse()) {
                        Notification::make()->title('No se puede publicar')->body(self::MENSAJE_SIN_LECCIONES)->danger()->send();

                        return;
                    }

                    $record->update(['publicado' => true]);
                    Notification::make()->title('Curso publicado')->success()->send();
                }),

            Action::make('borrador')
                ->label('Pasar a borrador')
                ->icon('heroicon-o-eye-slash')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('¿Pasar este curso a borrador?')
                ->modalDescription('Dejará de aparecer en el catálogo. Los estudiantes ya inscritos conservan su acceso y su avance.')
                ->visible(fn (Curso $record) => $record->publicado)
                ->action(function (Curso $record) {
                    $record->update(['publicado' => false]);
                    Notification::make()->title('El curso quedó en borrador')->success()->send();
                }),
        ];
    }
}
