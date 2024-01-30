<?php

namespace App\Filament\Resources\JabatanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\JabatanResource;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\JabatanResource\Widgets\JabatanWidget;

class ListJabatans extends ListRecords
{
    protected static string $resource = JabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->color("primary")
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            JabatanWidget::class
        ];
    }
}
