<?php

namespace App\Filament\Profesor\Resources\Cursos;

use App\Filament\Profesor\Resources\Cursos\Pages\CreateCurso;
use App\Filament\Profesor\Resources\Cursos\Pages\EditCurso;
use App\Filament\Profesor\Resources\Cursos\Pages\ListCursos;
use App\Filament\Profesor\Resources\Cursos\RelationManagers\ContenidosRelationManager;
use App\Filament\Profesor\Resources\Cursos\Schemas\CursoForm;
use App\Filament\Profesor\Resources\Cursos\Tables\CursosTable;
use App\Models\Curso;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CursoResource extends Resource
{
    protected static ?string $model = Curso::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static ?string $modelLabel = 'curso';

    protected static ?string $pluralModelLabel = 'mis cursos';

    // El profesor solo ve SUS cursos
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('profesor_id', auth()->user()->profesor?->id);
    }

    public static function form(Schema $schema): Schema
    {
        return CursoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CursosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ContenidosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCursos::route('/'),
            'create' => CreateCurso::route('/create'),
            'edit' => EditCurso::route('/{record}/edit'),
        ];
    }
}