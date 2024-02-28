<?php

namespace App\Filament\Resources\KPIFlowResource\Pages;

use App\Filament\Resources\KPIFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKPIFlow extends EditRecord
{
    protected static string $resource = KPIFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
