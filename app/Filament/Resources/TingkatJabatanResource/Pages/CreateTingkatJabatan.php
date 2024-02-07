<?php

namespace App\Filament\Resources\TingkatJabatanResource\Pages;

use App\Filament\Resources\TingkatJabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTingkatJabatan extends CreateRecord
{
    protected static string $resource = TingkatJabatanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
