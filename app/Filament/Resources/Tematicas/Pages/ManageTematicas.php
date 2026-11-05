<?php

namespace App\Filament\Resources\Tematicas\Pages;

use App\Filament\Resources\Tematicas\TematicaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTematicas extends ManageRecords
{
    protected static string $resource = TematicaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
