<?php

namespace App\Filament\Resources\CutiBesarResource\Pages;

use App\Filament\Resources\CutiBesarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCutiBesar extends EditRecord
{
    protected static string $resource = CutiBesarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
