<?php

namespace App\Filament\Resources\KpiKepanitiaanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\KpiKepanitiaanResource;

class ListKpiKepanitiaans extends ListRecords
{
    protected static string $resource = KpiKepanitiaanResource::class;

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
