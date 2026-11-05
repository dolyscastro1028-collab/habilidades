<?php

namespace App\Filament\Resources\Cursos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CursosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('materia')
                    ->label('Temática')
                    ->searchable(),
                TextColumn::make('duracion')
                    ->label('Duración'),
                TextColumn::make('profesor.nombre')
                    ->label('Profesor')
                    ->searchable(),
                TextColumn::make('modulos_count')
                    ->counts('modulos')
                    ->label('Módulos')
                    ->badge(),
                TextColumn::make('lecciones_count')
                    ->counts('lecciones')
                    ->label('Lecciones')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
