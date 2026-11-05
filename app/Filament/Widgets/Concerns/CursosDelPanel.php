<?php

namespace App\Filament\Widgets\Concerns;

use App\Filament\Profesor\Resources\Cursos\CursoResource as CursoProfesor;
use App\Filament\Resources\Cursos\CursoResource as CursoAdmin;
use App\Models\Curso;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;

// Los widgets del escritorio se usan en el panel admin (todos los cursos)
// y en el panel profesor (solo los cursos del profesor que inició sesión).
trait CursosDelPanel
{
    protected function esProfesor(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'profesor';
    }

    protected function cursosVisibles(): Builder
    {
        return Curso::query()->when(
            $this->esProfesor(),
            fn (Builder $q) => $q->where('profesor_id', auth()->user()->profesor?->id),
        );
    }

    protected function urlEditarCurso(Curso $curso): string
    {
        return ($this->esProfesor() ? CursoProfesor::class : CursoAdmin::class)::getUrl('edit', ['record' => $curso]);
    }
}
