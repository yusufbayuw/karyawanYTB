<?php

namespace App\Exports;

//use App\Models\Penilaian;
use App\Models\Periode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenilaianExport implements FromView, ShouldQueue //FromCollection
{

    /* public function collection()
    {
        return DB::table('penilaians')
                    ->join('users', 'penilaians.user_id', 'users.id')
                    ->join('periodes', 'penilaians.periode_id', 'periodes.id')
                    ->join('parameters', 'penilaians.parameter_id', 'parameters.id')
                    ->join('units', 'users.unit_id', 'units.id')
                    ->select( 
                        'periodes.nama',
                        'units.nama as unit',
                        'users.name',
                        'parameters.title',
                        'parameters.angka_kredit',
                        'penilaians.nilai',
                        'parameters.hasil_kerja',
                        'penilaians.jumlah'
                    )
                    ->get(); 
    } */

    public function view(): View
    {
        $periode_aktif = Periode::where('is_active', true)->first();
        return view('exports.penilaians', [
            'periode_aktif' => $periode_aktif->nama,
            'penilaians' => DB::table('penilaians')
                ->where('periode_id', $periode_aktif->id)
                ->join('users', 'penilaians.user_id', 'users.id')
                ->join('periodes', 'penilaians.periode_id', 'periodes.id')
                ->join('parameters', 'penilaians.parameter_id', 'parameters.id')
                ->join('units', 'users.unit_id', 'units.id')
                ->orderBy('units.id')
                ->orderBy('users.username')
                ->select(
                    'penilaians.id',
                    'periodes.nama',
                    'units.nama as unit',
                    'users.username',
                    'users.name',
                    'parameters.title',
                    'parameters.angka_kredit',
                    'penilaians.nilai',
                    'parameters.hasil_kerja',
                    'penilaians.jumlah'
                )
                ->get(),
        ]);
    }
}
