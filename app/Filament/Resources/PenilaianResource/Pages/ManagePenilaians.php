<?php

namespace App\Filament\Resources\PenilaianResource\Pages;

use Closure;
use App\Models\User;
use Filament\Actions;
use App\Models\Periode;
use App\Models\Golongan;
use App\Models\Parameter;
use App\Models\Penilaian;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\PenilaianResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Resources\Pages\ListRecords\Tab;
use App\Filament\Resources\PenilaianResource\Widgets\AbcIdentityWidget;
use App\Filament\Resources\PenilaianResource\Widgets\AcuanPenilaianWidget;

class ManagePenilaians extends ManageRecords
{
    protected static string $resource = PenilaianResource::class;

    #[On('update-record')]
    public function updateRecord()
    {
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Rangkuman')
                ->icon('heroicon-o-arrows-pointing-in')
                ->color("warning")
                ->action(function () {
                    $user = User::find(auth()->user()->id);
                    $user->gruop_penilaian = !$user->gruop_penilaian;
                    $user->save();
                    //redirect($_SERVER['HTTP_REFERER']);
                })
                ->after(fn () => redirect($_SERVER['HTTP_REFERER'])),
                //->after(fn ($livewire) => $livewire->dispatch('update-record')),
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
                            Penilaian::updateOrCreate([
                                'user_id' => $user->id,
                                'parameter_id' => $parameterGolongan->id,
                                'periode_id' => $periodeId,
                            ], [
                                'leluhur' => $parameterGolongan->ancestors->last()->title,
                                'kategori_id' => $parameterGolongan->kategori_id,
                            ]);
                        }

                        // kasus parameter untuk SEMUA golongan
                        $golongan = Golongan::find($userGolongan);
                        if ($golongan) {
                            $namaGolongan = explode(' - ', $golongan->nama)[0] . ' - ' . config('jabatan.semua');
                            if (Golongan::where('nama', $namaGolongan)->first()->id ?? null) {
                                $golonganId = Golongan::where('nama', $namaGolongan)->first()->id;
                                $parameterGolongans = Parameter::where('golongan_id', $golonganId);

                                foreach ($parameterGolongans->isLeaf()->get() as $key => $parameterGolongan) {

                                    Penilaian::updateOrCreate([
                                        'user_id' => $user->id,
                                        'parameter_id' => $parameterGolongan->id,
                                        'periode_id' => $periodeId,
                                    ], [
                                        'leluhur' => $parameterGolongan->ancestors->last()->title,
                                        'kategori_id' => $parameterGolongan->kategori_id,
                                    ]);
                                }
                            }
                        }
                    }
                })
                ->color("primary")
                ->hidden(fn () => !auth()->user()->hasRole(['super_admin'])),
            ExcelImportAction::make()
                ->color("primary")
                ->icon('heroicon-o-arrow-up-tray')
                ->hidden(fn () => !auth()->user()->hasRole(['super_admin'])),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AbcIdentityWidget::class,
            AcuanPenilaianWidget::class
        ];
    }

    /* public function getTabs(): array
    {
        $periodeAktifId = Periode::where('is_active', true)->first()->id;
        $userAuth = auth()->user();
        $adminAuth = $userAuth->hasRole(['super_admin']);
        
        return [
            'Pelaksanaan Tugas' => Tab::make()->query(fn ($query) => $query->where('user_id', $userAuth->id)->orWhere('user_id', User::find($userAuth->id)->children->id ?? $userAuth->id)->where('periode_id', $periodeAktifId)->where('kategori', 'Pelaksanaan Tugas')),
            'Pengembangan Profesi' => Tab::make()->query(fn ($query) => $query->where('user_id', $userAuth->id)->orWhere('user_id', User::find($userAuth->id)->children->id ?? $userAuth->id)->where('periode_id', $periodeAktifId)->where('kategori', 'Pengembangan Profesi')),
        ];
    } */
}
