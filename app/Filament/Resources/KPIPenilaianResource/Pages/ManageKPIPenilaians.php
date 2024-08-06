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
            Actions\Action::make('sync')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $periode = KPIPeriode::where('is_active', true)->first();
                    if ($periode) {
                        $users = User::all();
                        if ($users) {
                            foreach ($users as $key => $user) {
                                if ($user->unit_kpi_id && $user->jabatan->code) {
                                    $jabatans = explode(',', $user->jabatan->code);
                                    foreach ($jabatans as $key => $jabatan) {
                                        $kontraks = KPIKontrak::where('periode_kpi_id', $periode->id)
                                                            ->where('unit_kpi_id', $user->unit_kpi_id)
                                                            ->where('job_code', $jabatan)
                                                            ->get();
                                        foreach ($kontraks as $key => $kontrak) {
                                            KPIPenilaian::updateOrCreate(
                                                [
                                                    'periode_kpi_id' => $periode->id,
                                                    'user_id' => $user->id,
                                                    'kpi_kontrak_id' => $kontrak->id,
                                                ],
                                                [
                                                    'target' => $kontrak->target,
                                                ]
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }),
            //Actions\CreateAction::make(),
        ];
    }
}
