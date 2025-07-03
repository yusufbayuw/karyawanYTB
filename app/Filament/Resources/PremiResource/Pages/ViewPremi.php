<?php

namespace App\Filament\Resources\PremiResource\Pages;

use App\Filament\Resources\PremiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPremi extends ViewRecord
{
    protected static string $resource = PremiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
