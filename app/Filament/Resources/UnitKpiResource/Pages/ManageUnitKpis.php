<?php

namespace App\Filament\Resources\UnitKpiResource\Pages;

use App\Filament\Resources\UnitKpiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUnitKpis extends ManageRecords
{
    protected static string $resource = UnitKpiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
