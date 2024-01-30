<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ParameterResource;
use App\Filament\Resources\ParameterResource\Widgets\ParameterWidget;
use App\Imports\ParameterAutoImport;
use EightyNine\ExcelImport\ExcelImportAction;

class ListParameters extends ListRecords
{
    protected static string $resource = ParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make('update')
                ->label('Import')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->use(ParameterAutoImport::class),
            Actions\CreateAction::make(),
        ];
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            ParameterWidget::class
        ];
    }
}
