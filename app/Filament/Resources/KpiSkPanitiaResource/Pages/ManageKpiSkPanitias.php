<?php

namespace App\Filament\Resources\KpiSkPanitiaResource\Pages;

use App\Filament\Resources\KpiSkPanitiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKpiSkPanitias extends ManageRecords
{
    protected static string $resource = KpiSkPanitiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
