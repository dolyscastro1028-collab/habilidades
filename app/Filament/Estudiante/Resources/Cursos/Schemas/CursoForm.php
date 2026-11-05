<?php

namespace App\Filament\Estudiante\Resources\Cursos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CursoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('duracion')
                    ->required(),
                TextInput::make('materia')
                    ->required(),
                TextInput::make('profesor_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
