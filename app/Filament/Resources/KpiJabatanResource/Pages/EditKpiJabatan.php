<?php

namespace App\Filament\Resources\KpiJabatanResource\Pages;

use App\Filament\Resources\KpiJabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKpiJabatan extends EditRecord
{
    protected static string $resource = KpiJabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
