<?php

namespace App\Filament\Resources\KpiPejabatResource\Pages;

use App\Filament\Resources\KpiPejabatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKpiPejabats extends ListRecords
{
    protected static string $resource = KpiPejabatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
