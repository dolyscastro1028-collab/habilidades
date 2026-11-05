<?php

namespace App\Filament\Estudiante\Resources\Cursos\Pages;

use App\Filament\Estudiante\Resources\Cursos\CursoResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCursos extends ListRecords
{
    protected static string $resource = CursoResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $estudianteId = auth()->user()->estudiante?->id;

        return [
            // El catálogo solo muestra cursos publicados
            'todos' => Tab::make('Catálogo')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('publicado', true)),
            'mis' => Tab::make('Mis cursos')
                ->icon('heroicon-o-bookmark')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('estudiantes', fn ($q) => $q->whereKey($estudianteId))),
        ];
    }
}
