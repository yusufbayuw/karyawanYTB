<?php

namespace App\Exports;

use App\Models\Penilaian;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenilaianExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
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
    }
}
