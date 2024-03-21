<?php

namespace App\Filament\Resources\LaporanResource\Pages;

use App\Filament\Resources\LaporanResource;
use App\Jobs\ProcessPenilaianJob;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaporans extends ListRecords
{
    protected static string $resource = LaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),\
            Actions\Action::make('Sync')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    ProcessPenilaianJob::dispatch();
                })
                ->color('primary')
        ];
    }
}
