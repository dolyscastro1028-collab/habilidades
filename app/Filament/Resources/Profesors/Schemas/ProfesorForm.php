<?php

namespace App\Filament\Resources\Profesors\Schemas;

use App\Filament\Resources\CamposCuenta;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProfesorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                CamposCuenta::seccion()->columnSpanFull(),

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
            ]);
    }
}