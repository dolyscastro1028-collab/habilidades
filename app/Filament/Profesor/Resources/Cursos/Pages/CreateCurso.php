<?php

namespace App\Filament\Profesor\Resources\Cursos\Pages;

use App\Filament\Profesor\Resources\Cursos\CursoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCurso extends CreateRecord
{
    protected static string $resource = CursoResource::class;

    // Asigna automáticamente el profesor logueado
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['profesor_id'] = auth()->user()->profesor->id;

        return $data;
    }
}