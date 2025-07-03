<?php

namespace App\Filament\Resources\PensiunResource\Pages;

use App\Filament\Resources\PensiunResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPensiun extends ViewRecord
{
    protected static string $resource = PensiunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
