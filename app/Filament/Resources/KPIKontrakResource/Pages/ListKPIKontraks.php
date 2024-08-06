<?php

namespace App\Filament\Resources\KPIKontrakResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\KPIKontrakResource;

class ListKPIKontraks extends ListRecords
{
    protected static string $resource = KPIKontrakResource::class;

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
