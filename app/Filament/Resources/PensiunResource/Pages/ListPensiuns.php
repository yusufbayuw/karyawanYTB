<?php

namespace App\Filament\Resources\PensiunResource\Pages;

use App\Filament\Resources\PensiunResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPensiuns extends ListRecords
{
    protected static string $resource = PensiunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
