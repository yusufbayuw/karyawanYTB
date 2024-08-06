<?php

namespace App\Filament\Resources\KPIKontrakResource\Pages;

use App\Filament\Resources\KPIKontrakResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKPIKontrak extends CreateRecord
{
    protected static string $resource = KPIKontrakResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
