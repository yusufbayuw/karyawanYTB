<?php

namespace App\Filament\Resources\PremiResource\Pages;

use App\Filament\Resources\PremiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPremi extends EditRecord
{
    protected static string $resource = PremiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
