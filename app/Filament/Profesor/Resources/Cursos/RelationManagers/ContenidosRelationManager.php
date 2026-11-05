<?php

namespace App\Filament\Profesor\Resources\Cursos\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContenidosRelationManager extends RelationManager
{
    protected static string $relationship = 'contenidos';

    protected static ?string $title = 'Contenido del curso';

    protected static ?string $modelLabel = 'contenido';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título')
                    ->required()
                    ->columnSpanFull(),

                RichEditor::make('descripcion')
                    ->label('Descripción')
                    ->columnSpanFull(),

                TextInput::make('enlace')
                    ->label('Enlace (video, página, etc.)')
                    ->url()
                    ->columnSpanFull(),

                FileUpload::make('archivo')
                    ->label('Archivo')
                    ->disk('public')
                    ->directory('contenidos')
                    ->maxSize(10240) // 10 MB
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('titulo')
            ->reorderable('orden')
            ->defaultSort('orden')
            ->columns([
                TextColumn::make('orden')
                    ->label('#')
                    ->width('50px'),

                TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable(),

                IconColumn::make('enlace')
                    ->label('Enlace')
                    ->boolean()
                    ->state(fn ($record) => filled($record->enlace)),

                IconColumn::make('archivo')
                    ->label('Archivo')
                    ->boolean()
                    ->state(fn ($record) => filled($record->archivo)),
            ])
            ->headerActions([
                CreateAction::make()->label('Agregar contenido'),
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