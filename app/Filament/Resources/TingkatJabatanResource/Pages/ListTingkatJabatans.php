<?php

namespace App\Filament\Resources\TingkatJabatanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\TingkatJabatanResource;

class ListTingkatJabatans extends ListRecords
{
    protected static string $resource = TingkatJabatanResource::class;

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
