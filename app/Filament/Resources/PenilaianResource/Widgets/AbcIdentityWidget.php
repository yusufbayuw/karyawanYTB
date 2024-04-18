<?php

namespace App\Filament\Resources\PenilaianResource\Widgets;

use App\Models\Penilaian;
use Filament\Widgets\Widget;

class AbcIdentityWidget extends Widget
{
    protected static string $view = 'filament.resources.penilaian-resource.widgets.abc-identity-widget';

    protected static bool $isLazy = false;

    protected function getViewData(): array
    {
        $userAuth = auth()->user();
        return [ 
            'name' => $userAuth->name, 
            'golongan' => $userAuth->golongan->nama . ' ' . $userAuth->tingkat->title,
            'unit' => $userAuth->unit->nama,
            'total' => Penilaian::where('user_id', $userAuth->id)->where('approval', true)->sum('jumlah'),
        ];
    }
}
