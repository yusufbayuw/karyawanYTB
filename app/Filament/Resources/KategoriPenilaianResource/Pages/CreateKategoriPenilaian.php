<?php

namespace App\Filament\Resources\KategoriPenilaianResource\Pages;

use App\Filament\Resources\KategoriPenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriPenilaian extends CreateRecord
{
    protected static string $resource = KategoriPenilaianResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
