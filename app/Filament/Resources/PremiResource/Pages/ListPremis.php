<?php

namespace App\Filament\Resources\PremiResource\Pages;

use App\Filament\Resources\PremiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPremis extends ListRecords
{
    protected static string $resource = PremiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
