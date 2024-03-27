<?php

namespace App\Filament\Resources\LaporanResource\Pages;

use Filament\Actions;
use App\Exports\PenilaianExport;
use App\Jobs\ProcessPenilaianJob;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LaporanResource;
use App\Http\Controllers\PenialainController;
use App\Http\Controllers\PenilaianController;

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
                ->hidden(!auth()->user()->hasRole(['super_admin'])),
            Actions\ActionGroup::make([
                Actions\Action::make('all-unit-active-periode')
                    ->label('Semua Unit')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function () {
                        return Excel::download(new PenilaianExport, 'penialaian-' . now() . '.xlsx');
                    })
                    ->color('success')
                    ,
            ])
                ->label('Export')
                ->color('success')
                ->hidden(!auth()->user()->hasRole(['super_admin']))
                ->icon('heroicon-o-arrow-down-on-square-stack')
                ->button(),
        ];
    }
}
