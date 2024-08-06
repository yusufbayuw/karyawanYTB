<?php

namespace App\Filament\Resources\KpiDataPrestasiResource\Pages;

use App\Filament\Resources\KpiDataPrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKpiDataPrestasis extends ManageRecords
{
    protected static string $resource = KpiDataPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
