<?php

namespace App\Filament\Resources\KPIKontrakResource\Pages;

use App\Filament\Resources\KPIKontrakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKPIKontraks extends ListRecords
{
    protected static string $resource = KPIKontrakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
