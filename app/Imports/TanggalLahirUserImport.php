<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TanggalLahirUserImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            if ($key === 0) {
                //
            } else {
                User::updateOrCreate(
                    ['id' => $row[0] ?? null],
                    array_filter([
                        'tanggal_lahir' => $row[1] ?? null,
                        'tanggal_sk_pegawai_tetap' => $row[2] ?? null
                    ], function ($value) {
                        return !is_null($value);
                    })
                );
            }
            
        }
    }
}
