<?php

namespace App\Filament\Resources\KategoriPenilaianResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\KategoriPenilaianResource;

class ListKategoriPenilaians extends ListRecords
{
    protected static string $resource = KategoriPenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->color("primary")
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
