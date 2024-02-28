<?php

namespace App\Filament\Resources\KPIKontrakResource\Pages;

use App\Filament\Resources\KPIKontrakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKPIKontrak extends EditRecord
{
    protected static string $resource = KPIKontrakResource::class;

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
