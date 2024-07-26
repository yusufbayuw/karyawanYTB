<?php

namespace App\Filament\Resources\KpiKepanitiaanResource\Pages;

use App\Filament\Resources\KpiKepanitiaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKpiKepanitiaans extends ListRecords
{
    protected static string $resource = KpiKepanitiaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
