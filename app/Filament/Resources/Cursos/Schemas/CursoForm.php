<?php

namespace App\Filament\Resources\Cursos\Schemas;

use Filament\Forms\Components\Select;
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

                TextInput::make('materia')
                    ->label('Temática')
                    ->required(),

                TextInput::make('duracion')
                    ->label('Duración')
                    ->required(),

                Select::make('profesor_id')
                    ->label('Profesor')
                    ->relationship('profesor', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
