<?php

namespace App\Filament\Resources\KPIFlowResource\Pages;

use App\Filament\Resources\KPIFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKPIFlows extends ListRecords
{
    protected static string $resource = KPIFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
