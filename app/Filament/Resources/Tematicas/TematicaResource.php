<?php

namespace App\Filament\Resources\Tematicas;

use App\Filament\Resources\Tematicas\Pages\ManageTematicas;
use App\Models\Tematica;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TematicaResource extends Resource
{
    protected static ?string $model = Tematica::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static ?string $modelLabel = 'temática';

    protected static ?string $pluralModelLabel = 'temáticas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nombre')
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cursos_count')
                    ->counts('cursos')
                    ->label('Cursos')
                    ->badge(),
            ])
            ->recordActions([
                EditAction::make(),
                // La base de datos no deja borrar una temática que tiene cursos (restrictOnDelete)
                DeleteAction::make()
                    ->hidden(fn (Tematica $record) => $record->cursos()->exists()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTematicas::route('/'),
        ];
    }
}
