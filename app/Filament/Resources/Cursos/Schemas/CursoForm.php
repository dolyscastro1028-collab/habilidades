<?php

namespace App\Filament\Resources\Cursos\Schemas;

use App\Models\Profesor;
use Filament\Forms\Components\Select;
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

                TextInput::make('materia')
                    ->label('Temática')
                    ->required(),

                TextInput::make('duracion')
                    ->label('Duración')
                    ->required(),

                Select::make('profesor_id')
                    ->label('Profesor')
                    ->options(fn () => Profesor::with('user')->get()->pluck('nombre', 'id'))
                    ->searchable()
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
