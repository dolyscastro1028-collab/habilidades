<?php

namespace App\Filament\Estudiante\Resources\Cursos;

use App\Filament\Estudiante\Resources\Cursos\Pages\ListCursos;
use App\Filament\Estudiante\Resources\Cursos\Pages\VerLeccion;
use App\Filament\Estudiante\Resources\Cursos\Pages\ViewCurso;
use App\Filament\Estudiante\Resources\Cursos\Tables\CursosTable;
use App\Models\Curso;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
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

    // Cualquier estudiante ve la vista previa del curso (descripción y temario).
    // Las lecciones solo se abren estando inscrito (lo controla VerLeccion).
    public static function canView(Model $record): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema; // el estudiante no crea ni edita cursos
    }

    // Datos del curso que se muestran arriba al entrar
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('descripcion')
                    ->hiddenLabel()
                    ->placeholder('Este curso aún no tiene descripción.')
                    ->columnSpanFull(),

                TextEntry::make('tematica.nombre')->label('Temática')->badge(),
                TextEntry::make('duracion')->label('Duración'),
                TextEntry::make('profesor.user.name')->label('Profesor'),
                TextEntry::make('lecciones_count')
                    ->label('Contenido')
                    ->state(fn (Curso $record) => $record->modulos()->count() . ' módulos · ' . $record->lecciones()->count() . ' lecciones'),

                // Solo para inscritos
                TextEntry::make('progreso')
                    ->label('Mi progreso')
                    ->state(fn (Curso $record) => auth()->user()->estudiante->progresoTexto($record))
                    ->visible(fn (Curso $record) => $record->tieneInscrito(auth()->user()->estudiante)),

                ViewEntry::make('barra')
                    ->hiddenLabel()
                    ->state(fn (Curso $record) => auth()->user()->estudiante->progresoEn($record)['porcentaje'])
                    ->view('filament.barra-progreso')
                    ->visible(fn (Curso $record) => $record->tieneInscrito(auth()->user()->estudiante)),

                ViewEntry::make('modulos')
                    ->hiddenLabel()
                    ->view('filament.estudiante.modulos')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return CursosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCursos::route('/'),
            'view' => ViewCurso::route('/{record}'),
            'leccion' => VerLeccion::route('/{record}/lecciones/{leccion}'),
        ];
    }
}