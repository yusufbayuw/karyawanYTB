<?php

namespace App\Filament\Resources\KPIPeriodeResource\Pages;

use App\Filament\Resources\KPIPeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKPIPeriodes extends ListRecords
{
    protected static string $resource = KPIPeriodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
