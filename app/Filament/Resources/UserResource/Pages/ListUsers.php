<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Imports\UpdateUserImport;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $userAuthSpAd = auth()->user()->hasRole('super_admin');
        return [
            ExcelImportAction::make('update')
                ->label('Update')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->use(UpdateUserImport::class)
                ->hidden(!$userAuthSpAd),
            ExcelImportAction::make('import')
                ->color("primary")
                ->label('Import')
                ->icon('heroicon-o-arrow-up-tray')
                ->hidden(!$userAuthSpAd),
            Actions\CreateAction::make(),
        ];
    }
}
