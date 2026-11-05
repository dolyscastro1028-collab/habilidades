<?php

namespace App\Filament\Resources\Estudiantes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EstudianteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),

                TextInput::make('identificacion')
                    ->label('Identificación')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('edad')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(120)
                    ->required(),

                Select::make('cursos')
                    ->label('Cursos')
                    ->relationship('cursos', 'nombre')
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ]);
    }
}