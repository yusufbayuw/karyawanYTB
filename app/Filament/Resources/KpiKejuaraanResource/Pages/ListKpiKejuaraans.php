<?php

namespace App\Filament\Resources\KpiKejuaraanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\KpiKejuaraanResource;

class ListKpiKejuaraans extends ListRecords
{
    protected static string $resource = KpiKejuaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make('import')
                ->color("info")
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
