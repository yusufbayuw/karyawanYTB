<?php

namespace App\Filament\Resources\KPIPenilaianResource\Pages;

use App\Filament\Resources\KPIPenilaianResource;
use App\Models\KPIKontrak;
use App\Models\KPIPenilaian;
use App\Models\KPIPeriode;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKPIPenilaians extends ManageRecords
{
    protected static string $resource = KPIPenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Sync')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $periode_id = KPIPeriode::where('is_active', true)->first()->id;
                    if ($periode_id) {
                        $kontraks = KPIKontrak::all();
                        if ($kontraks) {
                            foreach ($kontraks as $key => $kontrak) {
                                if ($kontrak->flow->urutan) {
                                    $kontrak_id = $kontrak->id;
                                    $urutan = $kontrak->flow->urutan;
                                    foreach ($urutan as $key => $jabatan) {
                                        $jabatan_id = $jabatan["jabatan"];
                                        $users = User::where('jabatan_id', $jabatan_id)->get('id');
                                        foreach ($users as $key => $user) {
                                            if ($user->id) 
                                            {
                                                KPIPenilaian::updateOrCreate([
                                                    'user_id' => $user->id,
                                                    'kpi_kontrak_id' => $kontrak_id,
                                                    'kpi_periode_id' => $periode_id,
                                                ]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }),
        ];
    }
}
