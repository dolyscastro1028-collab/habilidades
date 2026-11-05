<?php

namespace App\Filament\Resources\Profesors\Pages;

use App\Filament\Resources\Profesors\ProfesorResource;
use App\Filament\Resources\CuentaDeUsuario;
use Filament\Resources\Pages\CreateRecord;

class CreateProfesor extends CreateRecord
{
    use CuentaDeUsuario;

    protected static string $resource = ProfesorResource::class;

    protected static string $rol = 'profesor';
}
