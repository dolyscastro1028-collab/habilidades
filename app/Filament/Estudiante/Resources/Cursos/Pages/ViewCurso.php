<?php

namespace App\Filament\Estudiante\Resources\Cursos\Pages;

use App\Filament\Estudiante\Resources\Cursos\CursoResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewCurso extends ViewRecord
{
    protected static string $resource = CursoResource::class;

    public function getTitle(): string
    {
        return $this->record->nombre;
    }

    private function inscrito(): bool
    {
        return $this->record->tieneInscrito(auth()->user()->estudiante);
    }

    protected function getHeaderActions(): array
    {
        $estudiante = auth()->user()->estudiante;

        return [
            // Vista previa: todavía no está inscrito
            Action::make('inscribirse')
                ->label('Inscribirme en este curso')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->size('lg')
                ->visible(fn () => ! $this->inscrito())
                ->action(function () use ($estudiante) {
                    $this->record->estudiantes()->syncWithoutDetaching($estudiante->id);
                    $this->record->unsetRelation('estudiantes');

                    Notification::make()->title('Te inscribiste en ' . $this->record->nombre)->success()->send();
                }),

            // Ya inscrito: ir directo a la siguiente lección pendiente
            Action::make('continuar')
                ->label(fn () => $estudiante->progresoEn($this->record)['completadas'] ? 'Continuar' : 'Empezar curso')
                ->icon('heroicon-o-play')
                ->size('lg')
                ->visible(fn () => $this->inscrito() && $estudiante->siguienteLeccion($this->record))
                ->url(fn () => CursoResource::getUrl('leccion', [
                    'record' => $this->record,
                    'leccion' => $estudiante->siguienteLeccion($this->record),
                ])),
        ];
    }
}
