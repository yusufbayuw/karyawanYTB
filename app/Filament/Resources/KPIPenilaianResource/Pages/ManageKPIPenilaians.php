<?php

namespace App\Filament\Resources\KPIPenilaianResource\Pages;

use App\Filament\Resources\KPIPenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKPIPenilaians extends ManageRecords
{
    protected static string $resource = KPIPenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
