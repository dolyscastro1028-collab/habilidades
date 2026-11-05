<?php

namespace App\Filament\Resources\Profesors\Pages;

use App\Filament\Resources\Profesors\ProfesorResource;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\CuentaDeUsuario;
use Filament\Resources\Pages\EditRecord;

class EditProfesor extends EditRecord
{
    use CuentaDeUsuario;

    protected static string $resource = ProfesorResource::class;

    protected static string $rol = 'profesor';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
