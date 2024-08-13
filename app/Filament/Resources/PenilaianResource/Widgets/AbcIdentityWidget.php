<?php

namespace App\Filament\Resources\PenilaianResource\Widgets;

use App\Filament\Resources\PenilaianResource\Pages\ManagePenilaians;
use App\Models\Penilaian;
use App\Models\Periode;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\Widget;

class AbcIdentityWidget extends Widget
{
    use InteractsWithPageTable;
    protected static string $view = 'filament.resources.penilaian-resource.widgets.abc-identity-widget';

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ManagePenilaians::class;
    }

    protected function getViewData(): array
    {
        // Fetch the necessary data once
        $user = $this->getPageTableQuery()->first()->user ?? "";
        $periode = Periode::where('is_active', true)->first() ?? "";

        // Ensure the $user object is not null
        if ($user) {
            $userName = $user->name ?? "";
            $golongan = $user->golongan->nama . ' ' . $user->tingkat->title;
            $unit = $user->unit->nama;
            $total = Penilaian::where('user_id', $user->id)
                ->where('periode_id', $periode->id)
                ->where('approval', true)
                ->sum('jumlah');
        } else {
            // Handle the case where there is no user found
            $userName = "Tidak Ditemukan";
            $golongan = "-";
            $unit = "";
            $total = 0;
        }

        // Output the data
        $data = [
            'name' => $userName,
            'golongan' => $golongan,
            'unit' => $unit,
            'total' => $total,
        ];

        return $data;
    }
}
