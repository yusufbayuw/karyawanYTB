<?php

namespace App\Filament\Resources\KPIPeriodeResource\Pages;

use App\Filament\Resources\KPIPeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKPIPeriode extends EditRecord
{
    protected static string $resource = KPIPeriodeResource::class;

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
