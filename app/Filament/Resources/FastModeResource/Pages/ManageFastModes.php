<?php

namespace App\Filament\Resources\FastModeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\FastModeResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ManageFastModes extends ManageRecords
{
    protected static string $resource = FastModeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        
        return [
            'Belum Verifikasi' => Tab::make()->query(fn ($query) => 
                        $query->whereNotNull('nilai')
                            ->whereNotNull('file')
                            ->where('approval', false)
                            ->whereNull('komentar')),
            'Revisi' => Tab::make()->query(fn ($query) => 
                        $query->whereNotNull('nilai')
                            ->whereNotNull('file')
                            ->where('approval', false)
                            ->whereNotNull('komentar')),
            'Sudah Verifikasi' => Tab::make()->query(fn ($query) => 
                        $query->whereNotNull('nilai')
                            ->whereNotNull('file')
                            ->where('approval', true)),
        ];
    }
}
