<?php

namespace App\Filament\Profesor\Resources\Cursos\Pages;

use App\Filament\Profesor\Resources\Cursos\CursoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCurso extends EditRecord
{
    protected static string $resource = CursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
