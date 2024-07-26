<?php

namespace App\Filament\Resources\KpiKejuaraanResource\Pages;

use App\Filament\Resources\KpiKejuaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKpiKejuaraan extends EditRecord
{
    protected static string $resource = KpiKejuaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
