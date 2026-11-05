<?php

namespace App\Filament\Resources\Estudiantes;

use App\Filament\Resources\Estudiantes\Pages\CreateEstudiante;
use App\Filament\Resources\Estudiantes\Pages\EditEstudiante;
use App\Filament\Resources\Estudiantes\Pages\ListEstudiantes;
use App\Filament\Resources\Estudiantes\Schemas\EstudianteForm;
use App\Filament\Resources\Estudiantes\Tables\EstudiantesTable;
use App\Models\Estudiante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 3;


    protected static ?string $modelLabel = 'estudiante';

    protected static ?string $pluralModelLabel = 'estudiantes';

    public static function getRecordTitle(?Model $record): string
    {
        return $record?->nombre ?? static::getModelLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return EstudianteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EstudiantesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEstudiantes::route('/'),
            'create' => CreateEstudiante::route('/create'),
            'edit' => EditEstudiante::route('/{record}/edit'),
        ];
    }
}