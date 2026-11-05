<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre de la habilidad')
                    ->placeholder('Ej. Fotografía profesional')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Descripción')
                    ->placeholder('Describe esta habilidad...')
                    ->rows(4)
                    ->columnSpanFull(),

                Select::make('category')
                    ->label('Categoría')
                    ->options([
                        'Arte' => 'Arte',
                        'Tecnología' => 'Tecnología',
                        'Deportes' => 'Deportes',
                        'Música' => 'Música',
                        'Idiomas' => 'Idiomas',
                        'Educación' => 'Educación',
                    ])
                    ->searchable()
                    ->native(false)
                    ->required(),
            ]);
    }
}