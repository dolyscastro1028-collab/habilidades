<?php

namespace App\Filament\Estudiante\Resources\Cursos\Pages;

use App\Filament\Estudiante\Resources\Cursos\CursoResource;
use App\Models\Leccion;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\Locked;

class VerLeccion extends Page
{
    use InteractsWithRecord;

    protected static string $resource = CursoResource::class;

    protected string $view = 'filament.estudiante.leccion';

    #[Locked]
    public Leccion $actual;

    public function mount(int|string $record, int|string $leccion): void
    {
        $this->record = $this->resolveRecord($record);

        // Solo estudiantes inscritos, y solo lecciones de este curso
        abort_unless($this->record->tieneInscrito(auth()->user()->estudiante), 403);

        $this->actual = $this->record->lecciones()->with('modulo')->findOrFail($leccion);
    }

    public function getTitle(): string|Htmlable
    {
        return $this->actual->titulo;
    }

    public function getSubheading(): ?string
    {
        return 'Módulo: ' . $this->actual->modulo->titulo;
    }

    public function getBreadcrumbs(): array
    {
        return [
            CursoResource::getUrl() => 'Cursos',
            CursoResource::getUrl('view', ['record' => $this->record]) => $this->record->nombre,
            $this->actual->titulo,
        ];
    }

    public function completada(): bool
    {
        return auth()->user()->estudiante->leccionesCompletadas()->whereKey($this->actual->id)->exists();
    }

    public function urlLeccion(?Leccion $leccion): ?string
    {
        return $leccion ? CursoResource::getUrl('leccion', ['record' => $this->record, 'leccion' => $leccion]) : null;
    }

    public function progreso(): array
    {
        return auth()->user()->estudiante->progresoEn($this->record);
    }

    // Botón debajo del video. Se muestra en la vista con {{ $this->completarAction }}
    public function completarAction(): Action
    {
        return Action::make('completar')
            ->label('Marcar como completada')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->size('lg')
            ->visible(fn () => ! $this->completada())
            ->action(function () {
                auth()->user()->estudiante->leccionesCompletadas()->syncWithoutDetaching($this->actual->id);

                $terminoCurso = $this->progreso()['porcentaje'] === 100;

                Notification::make()
                    ->title($terminoCurso ? '¡Felicitaciones! Terminaste el curso 🎉' : '¡Lección completada!')
                    ->body($terminoCurso ? "Completaste todas las lecciones de {$this->record->nombre}." : null)
                    ->success()
                    ->duration($terminoCurso ? 12000 : 4000)
                    ->actions($terminoCurso ? [
                        Action::make('verCertificado')
                            ->label('Ver mi certificado')
                            ->button()
                            ->url(route('certificado', $this->record), shouldOpenInNewTab: true),
                    ] : [])
                    ->send();

                // La vista escucha este evento y lanza el confeti
                $this->dispatch('leccion-completada', cursoTerminado: $terminoCurso);
            });
    }
}
