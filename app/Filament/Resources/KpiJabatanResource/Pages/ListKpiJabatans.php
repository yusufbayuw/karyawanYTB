<?php

namespace App\Filament\Resources\KpiJabatanResource\Pages;

use App\Filament\Resources\KpiJabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKpiJabatans extends ListRecords
{
    protected static string $resource = KpiJabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
