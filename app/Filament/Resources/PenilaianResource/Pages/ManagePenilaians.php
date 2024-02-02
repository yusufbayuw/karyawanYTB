<?php

namespace App\Filament\Resources\PenilaianResource\Pages;

use Closure;
use App\Models\User;
use Filament\Actions;
use App\Models\Periode;
use App\Models\Golongan;
use App\Models\Parameter;
use App\Models\Penilaian;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\PenilaianResource;
use EightyNine\ExcelImport\ExcelImportAction;

class ManagePenilaians extends ManageRecords
{
    protected static string $resource = PenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Sync')
            ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    // get semua pengguna
                    $users = User::all();
                    // periode aktif saja
                    $periodeId = Periode::where('is_active', true)->first()->id;

                    // loop semua user
                    foreach ($users as $key => $user) {
                        // id user
                        $userGolongan = $user->golongan->id;
                        // golongan_id pada parameter sesuai dengan golongan_id pada user
                        $parameterGolongans = Parameter::where('golongan_id', $userGolongan);
                        // loop parameter leaf 
                        foreach ($parameterGolongans->isLeaf()->get() as $key => $parameterGolongan) {
                            
                            // assign ke user_id , periode_id, dan parameter_id
                            Penilaian::firstOrCreate([
                                'user_id' => $user->id,
                                'parameter_id' => $parameterGolongan->id,
                                'periode_id' => $periodeId,
                                'leluhur' => $parameterGolongan->ancestors->last()->title,
                            ]);
                        }

                        // kasus parameter untuk SEMUA golongan
                        $golongan = Golongan::find($userGolongan);
                        if ($golongan) {
                            $namaGolongan = explode(' - ',$golongan->nama)[0] . ' - ' . config('jabatan.semua');
                            $golonganId = Golongan::where('nama', $namaGolongan)->first()->id;
                            $parameterGolongans = Parameter::where('golongan_id', $golonganId);
                            
                            foreach ($parameterGolongans->isLeaf()->get() as $key => $parameterGolongan) {
                               
                                Penilaian::firstOrCreate([
                                    'user_id' => $user->id,
                                    'parameter_id' => $parameterGolongan->id,
                                    'periode_id' => $periodeId,
                                    'leluhur' => $parameterGolongan->ancestors->last()->title,
                                ]);
                            }
                        }
                    }

                }),
            ExcelImportAction::make()
                ->color("primary")
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }
}
