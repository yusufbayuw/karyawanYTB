<?php

namespace App\Filament\Resources\KpiKejuaraanResource\Pages;

use App\Filament\Resources\KpiKejuaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKpiKejuaraans extends ListRecords
{
    protected static string $resource = KpiKejuaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
