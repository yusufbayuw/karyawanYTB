<?php

namespace App\Filament\Resources\KategoriPenilaianResource\Pages;

use App\Filament\Resources\KategoriPenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriPenilaian extends EditRecord
{
    protected static string $resource = KategoriPenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
