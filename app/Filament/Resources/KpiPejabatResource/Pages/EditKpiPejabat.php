<?php

namespace App\Filament\Resources\KpiPejabatResource\Pages;

use App\Filament\Resources\KpiPejabatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKpiPejabat extends EditRecord
{
    protected static string $resource = KpiPejabatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
