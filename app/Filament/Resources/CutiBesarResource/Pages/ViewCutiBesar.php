<?php

namespace App\Filament\Resources\CutiBesarResource\Pages;

use App\Filament\Resources\CutiBesarResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCutiBesar extends ViewRecord
{
    protected static string $resource = CutiBesarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
