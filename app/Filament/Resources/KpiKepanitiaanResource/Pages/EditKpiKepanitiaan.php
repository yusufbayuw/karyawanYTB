<?php

namespace App\Filament\Resources\KpiKepanitiaanResource\Pages;

use App\Filament\Resources\KpiKepanitiaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKpiKepanitiaan extends EditRecord
{
    protected static string $resource = KpiKepanitiaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
