<?php

namespace App\Filament\Profesor\Resources\Cursos\Schemas;

use Filament\Forms\Components\FileUpload;
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
                    ->label('Duración')
                    ->required(),

                TextInput::make('materia')
                    ->label('Temática')
                    ->required(),
                FileUpload::make('portada')
                    ->label('Imagen de portada')
                    ->helperText('Opcional. Si no subes una, se muestra un fondo de color.')
                    ->image()
                    ->disk('public')
                    ->directory('portadas')
                    ->maxSize(4096)
                    ->columnSpanFull(),
            ]);
    }
}