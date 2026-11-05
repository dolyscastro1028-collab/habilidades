<?php

namespace App\Filament\Resources\Cursos\Schemas;

use App\Models\Profesor;
use Filament\Forms\Components\Select;
use App\Filament\Resources\Cursos\PublicacionCurso;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CursoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),

                Select::make('tematica_id')
                    ->label('Temática')
                    ->relationship('tematica', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required()
                    // Permite crear una temática nueva sin salir del formulario
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->label('Nombre de la temática')
                            ->required()
                            ->unique('tematicas', 'nombre')
                            ->maxLength(100),
                    ]),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->helperText('Qué va a aprender el estudiante. Se muestra en el catálogo y en la vista previa del curso.')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),

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

                PublicacionCurso::interruptor(),
            ]);
    }
}
