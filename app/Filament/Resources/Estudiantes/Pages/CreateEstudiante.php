<?php

namespace App\Filament\Resources\Estudiantes\Pages;

use App\Filament\Resources\Estudiantes\EstudianteResource;
use App\Filament\Resources\CuentaDeUsuario;
use Filament\Resources\Pages\CreateRecord;

class CreateEstudiante extends CreateRecord
{
    use CuentaDeUsuario;

    protected static string $resource = EstudianteResource::class;

    protected static string $rol = 'estudiante';
}
