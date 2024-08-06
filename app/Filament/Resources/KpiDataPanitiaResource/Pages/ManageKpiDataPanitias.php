<?php

namespace App\Filament\Resources\KpiDataPanitiaResource\Pages;

use App\Filament\Resources\KpiDataPanitiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKpiDataPanitias extends ManageRecords
{
    protected static string $resource = KpiDataPanitiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
