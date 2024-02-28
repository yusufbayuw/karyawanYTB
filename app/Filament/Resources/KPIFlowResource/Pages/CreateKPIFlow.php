<?php

namespace App\Filament\Resources\KPIFlowResource\Pages;

use App\Filament\Resources\KPIFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKPIFlow extends CreateRecord
{
    protected static string $resource = KPIFlowResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
