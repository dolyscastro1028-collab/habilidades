<?php

namespace App\Filament\Resources\Profesors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProfesorForm
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
                    ->minValue(18)
                    ->maxValue(120)
                    ->required(),

                TextInput::make('materia')
                    ->required(),

                // Solo aparecen al crear (son los datos de login del profesor)
                TextInput::make('email')
                    ->label('Correo para iniciar sesión')
                    ->email()
                    ->required()
                    ->unique('users', 'email')
                    ->visibleOn('create'),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->revealable()
                    ->required()
                    ->visibleOn('create'),
            ]);
    }
}