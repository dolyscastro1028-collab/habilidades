<?php

namespace App\Filament\Resources\Cursos\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

// Lo usan el panel admin y el panel profesor: Curso → Módulos → Lecciones
class ModulosRelationManager extends RelationManager
{
    protected static string $relationship = 'modulos';

    protected static ?string $title = 'Módulos y lecciones';

    protected static ?string $modelLabel = 'módulo';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título del módulo')
                    ->required()
                    ->columnSpanFull(),

                // ponytail: lecciones editadas dentro del módulo; pasar a recurso anidado si crecen mucho
                Repeater::make('lecciones')
                    ->relationship()
                    ->orderColumn('orden')
                    ->label('Lecciones')
                    ->addActionLabel('Agregar lección')
                    ->itemLabel(fn (array $state) => $state['titulo'] ?? 'Nueva lección')
                    ->collapsible()
                    ->minItems(1)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('titulo')
                            ->label('Título de la lección')
                            ->required(),

                        RichEditor::make('contenido')
                            ->label('Contenido')
                            ->required(),

                        TextInput::make('video_url')
                            ->label('Enlace del video (YouTube o .mp4)')
                            ->url()
                            ->required(fn (Get $get) => blank($get('video_archivo')))
                            ->validationMessages(['required' => 'Agrega un enlace o sube un archivo de video.']),

                        FileUpload::make('video_archivo')
                            ->label('…o sube el video')
                            ->disk('public')
                            ->directory('videos')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->maxSize(12288), // 12 MB: límite de subida de Livewire
                    ]),
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
                    ->label('Módulo')
                    ->searchable(),

                TextColumn::make('lecciones_count')
                    ->counts('lecciones')
                    ->label('Lecciones')
                    ->badge(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Agregar módulo')
                    // el módulo nuevo queda al final
                    ->mutateDataUsing(fn (array $data) => [
                        ...$data,
                        'orden' => $this->getOwnerRecord()->modulos()->max('orden') + 1,
                    ]),
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
