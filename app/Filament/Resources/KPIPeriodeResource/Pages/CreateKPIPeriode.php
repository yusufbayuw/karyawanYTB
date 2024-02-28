<?php

namespace App\Filament\Resources\KPIPeriodeResource\Pages;

use App\Filament\Resources\KPIPeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKPIPeriode extends CreateRecord
{
    protected static string $resource = KPIPeriodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
