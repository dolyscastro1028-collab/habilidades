<?php

namespace App\Filament\Resources\Cursos\Tables;

use App\Filament\Resources\Cursos\PublicacionCurso;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CursosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                PublicacionCurso::columna(),
                TextColumn::make('tematica.nombre')
                    ->label('Temática')
                    ->badge()
                    ->searchable(),
                TextColumn::make('duracion')
                    ->label('Duración'),
                TextColumn::make('profesor.user.name')
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
                PublicacionCurso::filtro(),
                SelectFilter::make('tematica')
                    ->label('Temática')
                    ->relationship('tematica', 'nombre'),
            ])
            ->recordActions([
                ...PublicacionCurso::acciones(),
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
