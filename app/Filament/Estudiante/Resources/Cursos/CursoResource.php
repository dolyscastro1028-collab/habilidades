<?php

namespace App\Filament\Estudiante\Resources\Cursos;

use App\Filament\Estudiante\Resources\Cursos\Pages\ListCursos;
use App\Filament\Estudiante\Resources\Cursos\Pages\ViewCurso;
use App\Filament\Estudiante\Resources\Cursos\RelationManagers\ContenidosRelationManager;
use App\Filament\Estudiante\Resources\Cursos\Schemas\CursoForm;
use App\Filament\Estudiante\Resources\Cursos\Tables\CursosTable;
use App\Models\Curso;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CursoResource extends Resource
{
    protected static ?string $model = Curso::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static ?string $modelLabel = 'curso';

    protected static ?string $pluralModelLabel = 'cursos disponibles';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    // Solo puede ver el curso (y su contenido) si está inscrito
    public static function canView(Model $record): bool
    {
        return $record->estudiantes()
            ->whereKey(auth()->user()->estudiante?->id)
            ->exists();
    }

    public static function form(Schema $schema): Schema
    {
        return CursoForm::configure($schema);
    }

    // Datos del curso que se muestran arriba al entrar
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre'),
                TextEntry::make('materia'),
                TextEntry::make('duracion')->label('Duración'),
                TextEntry::make('profesor.nombre')->label('Profesor'),
            ]);
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
            'view' => ViewCurso::route('/{record}'),
        ];
    }
}