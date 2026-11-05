<?php

namespace App\Filament\Resources\Profesors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfesorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label('Correo')
                    ->searchable(),

                TextColumn::make('identificacion')
                    ->label('Identificación')
                    ->searchable(),

                TextColumn::make('edad')
                    ->sortable(),

                TextColumn::make('materia')
                    ->searchable(),

                TextColumn::make('cursos_count')
                    ->counts('cursos')
                    ->label('Cursos')
                    ->badge(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}