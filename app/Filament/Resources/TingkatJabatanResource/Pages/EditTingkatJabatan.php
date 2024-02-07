<?php

namespace App\Filament\Resources\TingkatJabatanResource\Pages;

use App\Filament\Resources\TingkatJabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTingkatJabatan extends EditRecord
{
    protected static string $resource = TingkatJabatanResource::class;

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
