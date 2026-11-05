<?php

namespace App\Filament\Estudiante\Resources\Cursos\Pages;

use App\Filament\Estudiante\Resources\Cursos\CursoResource;
use App\Models\Leccion;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
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
        abort_unless(CursoResource::canView($this->record), 403);

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

    // Todas las lecciones del curso en orden (módulo, luego lección) para anterior / siguiente
    public function leccionesDelCurso(): Collection
    {
        return $this->record->modulos()->with('lecciones')->get()->flatMap->lecciones->values();
    }

    public function urlLeccion(?Leccion $leccion): ?string
    {
        return $leccion ? CursoResource::getUrl('leccion', ['record' => $this->record, 'leccion' => $leccion]) : null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('completar')
                ->label('Marcar como completada')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => ! $this->completada())
                ->action(function () {
                    auth()->user()->estudiante->leccionesCompletadas()->syncWithoutDetaching($this->actual->id);

                    Notification::make()->title('¡Lección completada!')->success()->send();
                }),

            Action::make('yaCompletada')
                ->label('Completada')
                ->icon('heroicon-s-check-circle')
                ->color('gray')
                ->disabled()
                ->visible(fn () => $this->completada()),
        ];
    }
}
