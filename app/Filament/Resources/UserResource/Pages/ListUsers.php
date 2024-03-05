<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Imports\UpdateUserImport;
use Filament\Actions\ExportAction;
use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\Exports\Enums\ExportFormat;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $userAuthSpAd = auth()->user()->hasRole('super_admin');
        return [
            ExportAction::make('Export')
                    ->exporter(UserExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
                    ->fileName(fn (): string => "pegawai-". time() .".xlsx"),
            Actions\Action::make('Basic Role')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action(function () {
                    User::all()->each(function ($user) {
                        $user->assignRole('panel_user');
                    });
                }),
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
