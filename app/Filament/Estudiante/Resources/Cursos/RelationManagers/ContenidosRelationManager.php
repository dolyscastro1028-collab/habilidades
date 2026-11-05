<?php

namespace App\Filament\Estudiante\Resources\Cursos\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ContenidosRelationManager extends RelationManager
{
    protected static string $relationship = 'contenidos';

    protected static ?string $title = 'Contenido del curso';

    protected static ?string $modelLabel = 'contenido';

    // El estudiante solo puede ver, no crear ni editar
    public function isReadOnly(): bool
    {
        return true;
    }

    // Lo que se muestra al pulsar "Ver"
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('titulo')
                    ->label('Título')
                    ->columnSpanFull(),

                TextEntry::make('descripcion')
                    ->label('Descripción')
                    ->html()
                    ->placeholder('Sin descripción')
                    ->columnSpanFull(),

                TextEntry::make('enlace')
                    ->label('Enlace')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->placeholder('Sin enlace')
                    ->columnSpanFull(),

                TextEntry::make('archivo')
                    ->label('Archivo')
                    ->formatStateUsing(fn () => 'Descargar archivo')
                    ->url(fn ($record) => $record->archivo ? Storage::disk('public')->url($record->archivo) : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->placeholder('Sin archivo')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('titulo')
            ->defaultSort('orden')
            ->columns([
                TextColumn::make('orden')
                    ->label('#')
                    ->width('50px'),

                TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable(),

                TextColumn::make('enlace')
                    ->label('Enlace')
                    ->formatStateUsing(fn ($state) => $state ? 'Abrir' : '')
                    ->url(fn ($record) => $record->enlace)
                    ->openUrlInNewTab()
                    ->color('primary'),

                TextColumn::make('archivo')
                    ->label('Archivo')
                    ->formatStateUsing(fn ($state) => $state ? 'Descargar' : '')
                    ->url(fn ($record) => $record->archivo ? Storage::disk('public')->url($record->archivo) : null)
                    ->openUrlInNewTab()
                    ->color('primary'),
            ])
            ->recordActions([
                ViewAction::make()->label('Ver'),
            ]);
    }
}