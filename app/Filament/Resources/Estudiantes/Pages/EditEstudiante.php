<?php

namespace App\Filament\Resources\Estudiantes\Pages;

use App\Filament\Resources\Estudiantes\EstudianteResource;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\CuentaDeUsuario;
use Filament\Resources\Pages\EditRecord;

class EditEstudiante extends EditRecord
{
    use CuentaDeUsuario;

    protected static string $resource = EstudianteResource::class;

    protected static string $rol = 'estudiante';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
